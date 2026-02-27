<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Jadwal_model', 'jadwal_model']);
        $this->load->model(['Pengajuan_model', 'pengajuan_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('id_user')) redirect('auth/login');

        // Hanya Admin (1) dan OHS (4)
        $role = (int) $this->session->userdata('role');
        if (!in_array($role, [1, 4])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    // =============================================
    // INDEX — daftar & kalender jadwal
    // =============================================
    public function index()
    {
        $filter = [
            'status' => $this->input->get('status'),
            'bulan'  => $this->input->get('bulan'),
            'tahun'  => $this->input->get('tahun') ?: date('Y'),
        ];

        $data['title']    = 'Jadwal Uji Kelayakan';
        $data['user']     = $this->session->userdata();
        $data['jadwals']  = $this->jadwal_model->get_all($filter);
        $data['filter']   = $filter;
        $data['mekaniks'] = $this->jadwal_model->get_mekanik();

        // Data untuk kalender (JSON)
        $events = [];
        foreach ($data['jadwals'] as $j) {
            $color = $j->status === 'scheduled' ? '#4154f1'
                : ($j->status === 'done'      ? '#2eca6a' : '#dc3545');
            $events[] = [
                'id'    => $j->id_jadwal,
                'title' => $j->no_polisi . ' — ' . $j->jenis_kendaraan,
                'start' => date('Y-m-d\TH:i:s', strtotime($j->tanggal_uji)),
                'color' => $color,
                'extendedProps' => [
                    'id_jadwal'   => $j->id_jadwal,
                    'no_polisi'   => $j->no_polisi,
                    'jenis'       => $j->jenis_kendaraan,
                    'pemohon'     => $j->nama_pemohon,
                    'lokasi'      => $j->lokasi,
                    'status'      => $j->status,
                    'keterangan'  => $j->keterangan,
                ],
            ];
        }
        $data['events_json'] = json_encode($events);

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal/index',      $data);
        $this->load->view('templates/footer',  $data);
    }

    // =============================================
    // CREATE — form buat jadwal dari id_pengajuan
    // =============================================
    public function create($id_pengajuan = null)
    {
        $id_pengajuan = (int) $id_pengajuan;
        $pengajuan    = $this->pengajuan_model->get_detail($id_pengajuan);

        // Status yang boleh masuk ke form jadwal
        $status_boleh = ['approved_admin', 'scheduled'];

        if (!$pengajuan || !in_array($pengajuan->status, $status_boleh)) {
            $this->session->set_flashdata(
                'error',
                'Pengajuan tidak ditemukan atau belum disetujui Admin OHS. '
                    . 'Status saat ini: ' . ($pengajuan->status ?? 'tidak ada')
            );
            redirect('jadwal');
        }

        // Cek apakah sudah ada jadwal
        $existing = $this->jadwal_model->get_by_pengajuan($id_pengajuan);

        $data['title']      = 'Buat Jadwal Inspeksi';
        $data['user']       = $this->session->userdata();
        $data['pengajuan']  = $pengajuan;
        $data['existing']   = $existing;
        $data['mekaniks']   = $this->jadwal_model->get_mekanik();

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal/form',       $data);
        $this->load->view('templates/footer',  $data);
    }

    // =============================================
    // STORE — simpan jadwal (AJAX)
    // =============================================
    public function store()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_pengajuan = (int) $this->input->post('id_pengajuan');
        $tanggal_uji  = $this->input->post('tanggal_uji');
        $lokasi       = $this->input->post('lokasi');
        $id_mekanik   = (int) $this->input->post('id_mekanik');
        $keterangan   = $this->input->post('keterangan');
        $id_jadwal    = (int) $this->input->post('id_jadwal'); // jika edit

        // Validasi
        if (!$tanggal_uji || !$lokasi || !$id_mekanik) {
            echo json_encode(['status' => 'error', 'message' => 'Tanggal, lokasi, dan mekanik wajib diisi.']);
            return;
        }

        if (strtotime($tanggal_uji) < strtotime('today')) {
            echo json_encode(['status' => 'error', 'message' => 'Tanggal tidak boleh di masa lalu.']);
            return;
        }

        // Cek konflik mekanik
        if ($this->jadwal_model->cek_konflik($tanggal_uji, $id_mekanik, $id_jadwal ?: null)) {
            echo json_encode(['status' => 'error', 'message' => 'Mekanik sudah memiliki jadwal inspeksi di tanggal yang sama.']);
            return;
        }

        $payload = [
            'id_pengajuan' => $id_pengajuan,
            'tanggal_uji'  => date('Y-m-d H:i:s', strtotime($tanggal_uji)),
            'lokasi'       => $lokasi,
            'id_mekanik'   => $id_mekanik,
            'keterangan'   => $keterangan,
            'status'       => 'scheduled',
            'dibuat_oleh'  => $this->session->userdata('id_user'),
        ];

        $this->db->trans_start();

        if ($id_jadwal) {
            // Edit jadwal existing
            $this->jadwal_model->update($id_jadwal, $payload);
        } else {
            // Jadwal baru
            $payload['created_at'] = date('Y-m-d H:i:s');
            $id_jadwal = $this->jadwal_model->insert($payload);

            // Update status pengajuan → scheduled
            $this->db->where('id_pengajuan', $id_pengajuan)
                ->update('pengajuan_uji', ['status' => 'scheduled']);
        }

        // Audit log
        $this->db->insert('audit_log', [
            'id_user'    => $this->session->userdata('id_user'),
            'aksi'       => $id_jadwal ? 'edit_jadwal' : 'buat_jadwal',
            'tabel'      => 'jadwal_uji',
            'id_ref'     => $id_jadwal,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan jadwal.']);
            return;
        }

        echo json_encode([
            'status'   => 'success',
            'message'  => 'Jadwal inspeksi berhasil disimpan.',
            'redirect' => site_url('jadwal'),
        ]);
    }

    // =============================================
    // EDIT — form edit jadwal
    // =============================================
    public function edit($id_jadwal = null)
    {
        $id_jadwal = (int) $id_jadwal;
        $jadwal    = $this->jadwal_model->get_by_id($id_jadwal);

        if (!$jadwal || $jadwal->status !== 'scheduled') {
            $this->session->set_flashdata('error', 'Jadwal tidak ditemukan atau tidak dapat diubah.');
            redirect('jadwal');
        }

        $pengajuan = $this->pengajuan_model->get_detail($jadwal->id_pengajuan);

        $data['title']     = 'Edit Jadwal Inspeksi';
        $data['user']      = $this->session->userdata();
        $data['pengajuan'] = $pengajuan;
        $data['existing']  = $jadwal;
        $data['mekaniks']  = $this->jadwal_model->get_mekanik();

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal/form',       $data);
        $this->load->view('templates/footer',  $data);
    }

    // =============================================
    // CANCEL — batalkan jadwal (AJAX)
    // =============================================
    public function cancel()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_jadwal = (int) $this->input->post('id_jadwal');
        $result    = $this->jadwal_model->cancel($id_jadwal);

        if ($result) {
            $this->db->insert('audit_log', [
                'id_user'    => $this->session->userdata('id_user'),
                'aksi'       => 'cancel_jadwal',
                'tabel'      => 'jadwal_uji',
                'id_ref'     => $id_jadwal,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Jadwal berhasil dibatalkan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal membatalkan jadwal.']);
        }
    }

    // =============================================
    // GET DETAIL — AJAX untuk popup kalender
    // =============================================
    public function detail()
    {
        if (!$this->input->is_ajax_request()) show_404();
        $id = (int) $this->input->post('id_jadwal');
        $jadwal = $this->jadwal_model->get_by_id($id);
        echo json_encode(['status' => 'success', 'data' => $jadwal]);
    }
}
