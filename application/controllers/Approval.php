<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends CI_Controller
{

    // =============================================
    // Konfigurasi per level — sesuai alur baru
    // =============================================
    private $_levels = [

        // Step 2: Manager review submitted
        'manager' => [
            'role_required'  => [1, 2],
            'status_masuk'   => ['submitted'],
            'status_approve' => 'approved_manager',
            'status_reject'  => 'rejected',
            'level_next'     => 'admin_ohs',   // setelah approve → ke admin ohs
            'label'          => 'Review Manager',
            'desc'           => 'Setujui atau tolak pengajuan dari user departemen.',
            'can_reject_to'  => null,           // rejected = final
        ],

        // Step 3: Admin OHS — jika setuju buat jadwal, jika tolak → balik ke rejected
        'admin_ohs' => [
            'role_required'  => [1, 4],
            'status_masuk'   => ['approved_manager'],
            'status_approve' => 'scheduled',    // approve = langsung buat jadwal
            'status_reject'  => 'rejected',
            'level_next'     => null,
            'label'          => 'Review Admin OHS',
            'desc'           => 'Periksa dokumen. Jika setuju, buat jadwal uji. Jika tolak, pengajuan dikembalikan.',
            'approve_action' => 'jadwal',       // approve → redirect ke form jadwal
        ],

        // Step 5b: Admin OHS review hasil inspeksi mekanik
        'admin_ohs_hasil' => [
            'role_required'  => [1, 4],
            'status_masuk'   => ['review_ohs'],
            'status_approve' => 'approved_ohs',  // lanjut ke OHS Superintendent
            'status_reject'  => 'rejected',       // tolak → balik ke user dept
            'level_next'     => 'ohs_supt',
            'label'          => 'Admin OHS — Review Hasil Inspeksi',
            'desc'           => 'Review hasil checklist dari mekanik. Semua Critical item harus YES.',
        ],

        // Step 6: OHS Superintendent
        'ohs_supt' => [
            'role_required'  => [1, 4],
            'status_masuk'   => ['approved_ohs'],
            'status_approve' => 'approved_ktt',  // lanjut ke KTT — WAIT: sebenarnya ke approved_ohs_supt dulu
            'status_reject'  => 'review_ohs',    // tolak → balik ke Admin OHS (review_ohs)
            'level_next'     => 'ktt',
            'label'          => 'OHS Superintendent',
            'desc'           => 'Review & tanda tangan persetujuan OHS Superintendent.',
            'reject_label'   => 'Kembalikan ke Admin OHS',
        ],

        // Step 7: KTT
        'ktt' => [
            'role_required'  => [1, 5],
            'status_masuk'   => ['approved_ktt'],
            'status_approve' => 'sticker_released', // langsung siap rilis
            'status_reject'  => 'review_ohs',       // tolak → balik ke Admin OHS
            'level_next'     => null,
            'label'          => 'Approval KTT',
            'desc'           => 'Approval final Kepala Teknik Tambang.',
            'reject_label'   => 'Kembalikan ke Admin OHS',
        ],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Approval_model', 'approval_model');
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this->session->userdata('id_user')) redirect('auth/login');
    }

    // =============================================
    // Routes per level
    // =============================================
    public function manager()
    {
        $this->_index('manager');
    }
    public function admin_ohs()
    {
        $this->_index('admin_ohs');
    }
    public function admin_hasil()
    {
        $this->_index('admin_ohs_hasil');
    }
    public function ohs_supt()
    {
        $this->_index('ohs_supt');
    }
    public function ktt()
    {
        $this->_index('ktt');
    }

    private function _index($level)
    {
        $cfg  = $this->_cfg($level);
        $role = (int) $this->session->userdata('role');

        if (!in_array($role, $cfg['role_required'])) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('dashboard');
        }

        // Tampil semua yang relevan: pending + sudah diproses level ini
        $status_show = array_merge(
            $cfg['status_masuk'],
            [$cfg['status_approve'], $cfg['status_reject']]
        );
        $status_show = array_unique($status_show);

        $list    = $this->approval_model->get_list($status_show, [
            'search' => $this->input->get('search'),
        ]);
        $pending = $this->approval_model->get_list($cfg['status_masuk'], []);

        $data['title']         = $cfg['label'];
        $data['user']          = $this->session->userdata();
        $data['level']         = $level;
        $data['cfg']           = $cfg;
        $data['list']          = $list;
        $data['pending_count'] = count($pending);
        $data['status_masuk']  = $cfg['status_masuk'];

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('approval/index',    $data);
        $this->load->view('templates/footer',  $data);
    }

    // =============================================
    // DETAIL
    // =============================================
    public function detail($level, $id_pengajuan = null)
    {
        $cfg  = $this->_cfg($level);
        $role = (int) $this->session->userdata('role');

        if (!in_array($role, $cfg['role_required'])) {
            redirect('dashboard');
        }

        $pengajuan = $this->approval_model->get_detail($id_pengajuan);
        if (!$pengajuan) show_404();

        $data['title']     = 'Detail — ' . $pengajuan->no_polisi;
        $data['user']      = $this->session->userdata();
        $data['level']     = $level;
        $data['cfg']       = $cfg;
        $data['pengajuan'] = $pengajuan;
        $data['lampiran']  = $this->approval_model->get_lampiran($id_pengajuan);
        $data['riwayat']   = $this->approval_model->get_riwayat($id_pengajuan);

        // Jika level admin_ohs_hasil, load juga data checklist
        if ($level === 'admin_ohs_hasil') {
            $this->load->model('Checklist_model');
            $uji = $this->db->where('id_pengajuan', $id_pengajuan)
                ->get('uji_kelayakan')->row();
            $data['uji']     = $uji;
            $data['summary'] = $uji ? $this->checklist_model->get_summary($uji->id_uji) : null;
        }

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('approval/detail',   $data);
        $this->load->view('templates/footer',  $data);
    }

    // =============================================
    // PROSES — AJAX approve / reject
    // =============================================
    public function proses()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $level        = $this->input->post('level');
        $id_pengajuan = (int) $this->input->post('id_pengajuan');
        $aksi         = $this->input->post('aksi'); // approve | reject
        $catatan      = $this->input->post('catatan');

        $cfg  = $this->_cfg($level);
        $role = (int) $this->session->userdata('role');

        if (!in_array($role, $cfg['role_required'])) {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak.']);
            return;
        }

        if ($aksi === 'reject' && empty(trim($catatan))) {
            echo json_encode(['status' => 'error', 'message' => 'Catatan wajib diisi saat menolak.']);
            return;
        }

        $pengajuan = $this->approval_model->get_detail($id_pengajuan);
        if (!$pengajuan || !in_array($pengajuan->status, $cfg['status_masuk'])) {
            echo json_encode(['status' => 'error', 'message' => 'Status pengajuan tidak sesuai.']);
            return;
        }

        // Tentukan status tujuan
        $status_tujuan = $aksi === 'approve' ? $cfg['status_approve'] : $cfg['status_reject'];

        // Jika admin_ohs approve → redirect ke form jadwal, bukan proses langsung
        if ($level === 'admin_ohs' && $aksi === 'approve') {
            // Update status dulu ke approved_manager_ohs (siap dijadwalkan)
            $this->db->where('id_pengajuan', $id_pengajuan)
                ->update('pengajuan_uji', ['status' => 'approved_admin']);

            // Insert approval record
            $this->db->insert('pengajuan_approval', [
                'id_pengajuan'   => $id_pengajuan,
                'id_approver'    => $this->session->userdata('id_user'),
                'level_approval' => $level,
                'status'         => 'approved',
                'catatan'        => $catatan,
                'created_at'     => date('Y-m-d H:i:s'),
            ]);

            $this->_audit('approve_' . $level, $id_pengajuan);

            echo json_encode([
                'status'        => 'success',
                'aksi'          => 'approve',
                'message'       => 'Pengajuan disetujui. Silakan buat jadwal uji.',
                'redirect_jadwal' => site_url('jadwal/create/' . $id_pengajuan),
            ]);
            return;
        }

        // Proses normal
        $ok = $this->approval_model->proses([
            'id_pengajuan' => $id_pengajuan,
            'aksi'         => $aksi,
            'level'        => $level,
            'status_next'  => $status_tujuan,
            'level_next'   => ($aksi === 'approve' && !empty($cfg['level_next'])) ? $cfg['level_next'] : null,
            'id_approver'  => $this->session->userdata('id_user'),
            'catatan'      => $catatan,
        ]);

        if (!$ok) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memproses. Coba lagi.']);
            return;
        }

        $this->_audit(($aksi === 'approve' ? 'approve_' : 'reject_') . $level, $id_pengajuan);

        $no  = '#PU-' . str_pad($id_pengajuan, 4, '0', STR_PAD_LEFT);
        $msg = $aksi === 'approve'
            ? 'Pengajuan <strong>' . $no . '</strong> disetujui.'
            : 'Pengajuan <strong>' . $no . '</strong> ditolak.';

        // Tentukan redirect per level
        $redirect_map = [
            'manager'        => 'approval/manager',
            'admin_ohs'      => 'approval/admin_ohs',
            'admin_ohs_hasil' => 'approval/admin_hasil',
            'ohs_supt'       => 'approval/ohs_supt',
            'ktt'            => 'approval/ktt',
        ];

        echo json_encode([
            'status'   => 'success',
            'message'  => $msg,
            'aksi'     => $aksi,
            'redirect' => site_url($redirect_map[$level] ?? 'dashboard'),
        ]);
    }

    // =============================================
    // Helpers
    // =============================================
    private function _cfg($level)
    {
        if (!isset($this->_levels[$level])) show_404();
        return $this->_levels[$level];
    }

    private function _audit($aksi, $id_pengajuan)
    {
        $this->db->insert('audit_log', [
            'id_user'    => $this->session->userdata('id_user'),
            'aksi'       => $aksi,
            'tabel'      => 'pengajuan_uji',
            'id_ref'     => $id_pengajuan,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
