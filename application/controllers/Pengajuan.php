<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengajuan_model', 'pengajuan_model');
        $this->load->model('Kendaraan_model', 'kendaraan_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
    }

    // =============================================
    // INDEX — Daftar Pengajuan
    // =============================================
    public function index()
    {
        $data['title'] = 'Daftar Pengajuan';
        $data['user']  = $this->session->userdata();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengajuan/index', $data);
        $this->load->view('templates/footer', $data);
    }

    // =============================================
    // CREATE — Halaman Form Buat Pengajuan
    // =============================================
    public function create()
    {
        $data['title']     = 'Buat Pengajuan Uji Kelayakan';
        $data['user']      = $this->session->userdata();
        $data['kendaraan'] = $this->kendaraan_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengajuan/create', $data);
        $this->load->view('templates/footer', $data);
    }

    // =============================================
    // STORE — Proses simpan pengajuan baru (AJAX)
    // =============================================
    public function store()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_user      = $this->session->userdata('id_user');
        $id_kendaraan = (int) $this->input->post('id_kendaraan');

        // Validasi input
        $this->form_validation->set_rules('id_kendaraan',   'Kendaraan',         'required|is_natural_no_zero');
        $this->form_validation->set_rules('email_pemohon',  'Email Pemohon',     'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('tipe_pengajuan', 'Tipe Pengajuan',    'required|in_list[new_commissioning,recommissioning]');
        $this->form_validation->set_rules('tipe_akses',     'Tipe Akses',        'required|in_list[mining,non_mining]');
        $this->form_validation->set_rules('tujuan',         'Tujuan Penggunaan', 'required|max_length[1000]');

        if (!$this->form_validation->run()) {
            echo json_encode([
                'status'  => 'error',
                'message' => validation_errors('<li>', '</li>'),
            ]);
            return;
        }

        // Ambil data kendaraan
        $kendaraan = $this->kendaraan_model->get_by_id($id_kendaraan);
        if (!$kendaraan) {
            echo json_encode(['status' => 'error', 'message' => 'Kendaraan tidak ditemukan.']);
            return;
        }

        // Validasi lampiran wajib untuk unit baru
        if ($kendaraan->is_unit_baru) {
            $required = ['stnk', 'unit_depan', 'unit_belakang', 'unit_kiri', 'unit_kanan'];
            $label    = [
                'stnk'         => 'Foto STNK',
                'unit_depan'   => 'Foto Unit Depan',
                'unit_belakang' => 'Foto Unit Belakang',
                'unit_kiri'    => 'Foto Unit Kiri',
                'unit_kanan'   => 'Foto Unit Kanan',
            ];
            foreach ($required as $jenis) {
                if (empty($_FILES['lampiran_' . $jenis]['name'])) {
                    echo json_encode([
                        'status'  => 'error',
                        'message' => 'Unit baru wajib melampirkan <strong>' . $label[$jenis] . '</strong>.',
                    ]);
                    return;
                }
            }
        }

        // Insert pengajuan
        $id_pengajuan = $this->pengajuan_model->insert_pengajuan([
            'id_kendaraan'     => $id_kendaraan,
            'id_pemohon'       => $id_user,
            'email_pemohon'    => $this->input->post('email_pemohon'),
            'tipe_pengajuan'   => $this->input->post('tipe_pengajuan'),
            'tipe_akses'       => $this->input->post('tipe_akses'),
            'tujuan'           => $this->input->post('tujuan'),
            'nomor_rangka'     => $this->input->post('nomor_rangka'),
            'nomor_mesin'      => $this->input->post('nomor_mesin'),
            'status'           => 'submitted',
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
        ]);

        if (!$id_pengajuan) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pengajuan. Silakan coba lagi.']);
            return;
        }

        // Upload lampiran jika unit baru
        if ($kendaraan->is_unit_baru) {
            $upload_errors = $this->_upload_lampiran($id_pengajuan);
            if (!empty($upload_errors)) {
                $this->pengajuan_model->delete_pengajuan($id_pengajuan);
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Gagal upload lampiran:<ul><li>' . implode('</li><li>', $upload_errors) . '</li></ul>',
                ]);
                return;
            }
        }

        // Buat record approval awal (pending ke manager)
        $this->pengajuan_model->insert_approval([
            'id_pengajuan'   => $id_pengajuan,
            'level_approval' => 'manager',
            'status'         => 'pending',
        ]);

        // Audit log
        $this->_audit('buat_pengajuan', 'pengajuan_uji', $id_pengajuan);

        $no = '#PU-' . str_pad($id_pengajuan, 4, '0', STR_PAD_LEFT);

        echo json_encode([
            'status'   => 'success',
            'message'  => 'Pengajuan <strong>' . $no . '</strong> berhasil disubmit dan menunggu review Manager.',
            'redirect' => site_url('pengajuan'),
        ]);
    }

    // =============================================
    // AJAX — DataTables server-side
    // =============================================
    public function get_data()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $draw   = $this->input->post('draw');
        $start  = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];

        $filters = [
            'status'     => $this->input->post('filter_status'),
            'jenis'      => $this->input->post('filter_jenis'),
            'tgl_dari'   => $this->input->post('filter_tgl_dari'),
            'tgl_sampai' => $this->input->post('filter_tgl_sampai'),
            'search'     => $search,
        ];

        $total    = $this->pengajuan_model->count_all($filters);
        $filtered = $this->pengajuan_model->count_filtered($filters);
        $rows     = $this->pengajuan_model->get_datatable($start, $length, $filters);

        $data_rows = [];
        $no        = $start + 1;

        foreach ($rows as $row) {
            $badge_unit = $row->is_unit_baru
                ? '<span class="badge bg-warning text-dark">Unit Baru</span>'
                : '<span class="badge bg-secondary">Unit Lama</span>';

            $data_rows[] = [
                'no'              => $no++,
                'id_display'      => '<span class="fw-bold text-primary">#PU-' . str_pad($row->id_pengajuan, 4, '0', STR_PAD_LEFT) . '</span>',
                'pemohon'         => html_escape($row->nama_pemohon),
                'no_polisi'       => '<span class="badge bg-secondary font-monospace">' . html_escape($row->no_polisi) . '</span>',
                'jenis_kendaraan' => html_escape($row->jenis_kendaraan) . '<br><small class="text-muted">' . html_escape($row->merk) . ' ' . html_escape($row->tipe) . '</small>',
                'unit_baru'       => $badge_unit,
                'status'          => $this->_badge_status($row->status),
                'tgl_pengajuan'   => date('d M Y', strtotime($row->tanggal_pengajuan)) . '<br><small class="text-muted">' . date('H:i', strtotime($row->tanggal_pengajuan)) . '</small>',
                'aksi'            => $this->_tombol_aksi($row),
            ];
        }

        echo json_encode([
            'draw'            => (int) $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $data_rows,
        ]);
    }

    // =============================================
    // AJAX — Detail untuk modal
    // =============================================
    public function detail($id = null)
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id   = (int) $id;
        $data = $this->pengajuan_model->get_detail($id);

        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
            return;
        }

        $data->lampiran = $this->pengajuan_model->get_lampiran($id);
        $data->approval = $this->pengajuan_model->get_approval($id);
        $data->jadwal   = $this->pengajuan_model->get_jadwal($id);
        $data->uji      = $this->pengajuan_model->get_uji($id);

        echo json_encode(['status' => 'success', 'data' => $data]);
    }

    // =============================================
    // AJAX — Info kendaraan untuk form create
    // =============================================
    public function get_kendaraan_info()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id  = (int) $this->input->post('id_kendaraan');
        $row = $this->kendaraan_model->get_by_id($id);

        if (!$row) {
            echo json_encode(['status' => 'error']);
            return;
        }

        echo json_encode(['status' => 'success', 'data' => $row]);
    }

    // =============================================
    // Private — Upload lampiran
    // =============================================
    private function _upload_lampiran($id_pengajuan)
    {
        $errors      = [];
        $jenis_list  = ['stnk', 'unit_depan', 'unit_belakang', 'unit_kiri', 'unit_kanan'];
        $upload_path = FCPATH . './assets/uploads/lampiran/' . $id_pengajuan . '/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        foreach ($jenis_list as $jenis) {
            $field = 'lampiran_' . $jenis;
            if (empty($_FILES[$field]['name'])) continue;

            $this->upload->initialize([
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|pdf',
                'max_size'      => 5120,
                'file_name'     => $jenis . '_' . time(),
                'overwrite'     => TRUE,
            ]);

            if (!$this->upload->do_upload($field)) {
                $errors[] = $this->upload->display_errors('', '');
            } else {
                $info = $this->upload->data();
                $this->pengajuan_model->insert_lampiran([
                    'id_pengajuan'   => $id_pengajuan,
                    'jenis_lampiran' => $jenis,
                    'file_path'      => 'uploads/lampiran/' . $id_pengajuan . '/' . $info['file_name'],
                    'uploaded_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return $errors;
    }

    // =============================================
    // Private — Badge status
    // =============================================
    private function _badge_status($status)
    {
        $map = [
            'draft'            => ['bg-secondary',         'Draft'],
            'submitted'        => ['bg-primary',           'Submitted'],
            'review_manager'   => ['bg-warning text-dark', 'Review Manager'],
            'approved_manager' => ['bg-info text-dark',    'Approved Manager'],
            'review_admin'     => ['bg-warning text-dark', 'Review Admin OHS'],
            'approved_admin'   => ['bg-info text-dark',    'Approved Admin'],
            'scheduled'        => ['bg-primary',           'Terjadwal'],
            'inspected'        => ['bg-info text-dark',    'Diinspeksi'],
            'review_ohs'       => ['bg-warning text-dark', 'Review OHS'],
            'approved_ohs'     => ['bg-info text-dark',    'Approved OHS'],
            'approved_ktt'     => ['bg-success',           'Approved KTT'],
            'sticker_released' => ['bg-success',           'Sticker Released'],
            'rejected'         => ['bg-danger',            'Ditolak'],
        ];

        $cfg = isset($map[$status]) ? $map[$status] : ['bg-secondary', $status];
        return '<span class="badge ' . $cfg[0] . '">' . $cfg[1] . '</span>';
    }

    // =============================================
    // Private — Tombol aksi per role & status
    // =============================================
    private function _tombol_aksi($row)
    {
        $id   = $row->id_pengajuan;
        $role = $this->session->userdata('role');

        $btn  = '<div class="d-flex gap-1 flex-wrap">';
        $btn .= '<button class="btn btn-sm btn-outline-primary py-0 btn-detail" data-id="' . $id . '" title="Detail"><i class="bi bi-eye"></i></button>';

        if (in_array($row->status, ['draft', 'rejected']) && $this->session->userdata('id_user') == $row->id_pemohon) {
            $btn .= '<a href="' . site_url('pengajuan/edit/' . $id) . '" class="btn btn-sm btn-outline-secondary py-0" title="Edit"><i class="bi bi-pencil"></i></a>';
        }

        $can_approve = false;
        if ($role === 'manager'         && $row->status === 'review_manager')                       $can_approve = true;
        if ($role === 'ohs_coordinator' && in_array($row->status, ['review_admin', 'review_ohs'])) $can_approve = true;
        if ($role === 'ohs_supt'        && $row->status === 'approved_ohs')                        $can_approve = true;
        if ($role === 'ktt'             && $row->status === 'approved_ohs')                        $can_approve = true;

        if ($can_approve) {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-approve" data-id="' . $id . '" title="Setujui"><i class="bi bi-check-lg"></i></button>';
            $btn .= '<button class="btn btn-sm btn-danger py-0 btn-reject"  data-id="' . $id . '" title="Tolak"><i class="bi bi-x-lg"></i></button>';
        }

        if ($role === 'ohs_coordinator' && $row->status === 'approved_admin') {
            $btn .= '<button class="btn btn-sm btn-info py-0 btn-jadwal text-white" data-id="' . $id . '" title="Jadwalkan"><i class="bi bi-calendar-plus"></i></button>';
        }

        if ($role === 'mekanik' && $row->status === 'scheduled') {
            $btn .= '<a href="' . site_url('inspeksi/form/' . $id) . '" class="btn btn-sm btn-warning py-0" title="Isi Form Inspeksi"><i class="bi bi-tools"></i></a>';
        }

        if ($role === 'ohs_coordinator' && $row->status === 'approved_ktt') {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-sticker" data-id="' . $id . '" title="Terbitkan Sticker"><i class="bi bi-patch-check"></i></button>';
        }

        $btn .= '</div>';
        return $btn;
    }

    // =============================================
    // Private — Audit log
    // =============================================
    private function _audit($aksi, $tabel, $id_ref)
    {
        $this->db->insert('audit_log', [
            'id_user'    => $this->session->userdata('id_user'),
            'aksi'       => $aksi,
            'tabel'      => $tabel,
            'id_ref'     => $id_ref,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
