<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kendaraan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kendaraan_model', 'kendaraan_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
    }

    // =============================================
    // INDEX — Halaman Daftar Kendaraan
    // =============================================
    public function index()
    {
        $data['title'] = 'Data Kendaraan';
        $data['user']  = $this->session->userdata();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('kendaraan/index', $data);
        $this->load->view('templates/footer', $data);
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

        $filters = [
            'search'          => $this->input->post('search')['value'],
            'jenis_kendaraan' => $this->input->post('filter_jenis'),
            'is_unit_baru'    => $this->input->post('filter_unit'),
        ];

        $total    = $this->kendaraan_model->count_all($filters);
        $filtered = $this->kendaraan_model->count_filtered($filters);
        $rows     = $this->kendaraan_model->get_datatable($start, $length, $filters);

        $data = [];
        $no   = $start + 1;

        foreach ($rows as $row) {
            $badge_unit = $row->is_unit_baru
                ? '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Unit Baru</span>'
                : '<span class="badge bg-secondary">Unit Lama</span>';

            $aksi =
                '<div class="d-flex gap-1 justify-content-center">' .
                '<button class="btn btn-sm btn-outline-primary py-0 btn-detail" data-id="' . $row->id_kendaraan . '" title="Detail"><i class="bi bi-eye"></i></button>' .
                '<button class="btn btn-sm btn-outline-warning py-0 btn-edit" data-id="' . $row->id_kendaraan . '" title="Edit"><i class="bi bi-pencil"></i></button>' .
                '<button class="btn btn-sm btn-outline-danger py-0 btn-delete" data-id="' . $row->id_kendaraan . '" data-nopol="' . html_escape($row->no_polisi) . '" title="Hapus"><i class="bi bi-trash"></i></button>' .
                '</div>';

            $data[] = [
                'no'              => $no++,
                'no_polisi'       => '<span class="badge bg-dark font-monospace fs-6">' . html_escape($row->no_polisi) . '</span>',
                'jenis_kendaraan' => html_escape($row->jenis_kendaraan),
                'merk_tipe'       => '<strong>' . html_escape($row->merk) . '</strong><br><small class="text-muted">' . html_escape($row->tipe) . '</small>',
                'tahun'           => $row->tahun,
                'unit'            => $badge_unit,
                'total_pengajuan' => '<span class="badge bg-primary rounded-pill">' . $row->total_pengajuan . '</span>',
                'created_at'      => date('d M Y', strtotime($row->created_at)),
                'aksi'            => $aksi,
            ];
        }

        echo json_encode([
            'draw'            => (int) $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $data,
        ]);
    }

    // =============================================
    // AJAX — Get data untuk modal (detail & edit)
    // =============================================
    public function get_by_id()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id  = (int) $this->input->post('id');
        $row = $this->kendaraan_model->get_by_id($id);

        if (!$row) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
            return;
        }

        echo json_encode(['status' => 'success', 'data' => $row]);
    }

    // =============================================
    // AJAX — Simpan (Insert / Update)
    // =============================================
    public function save()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id        = (int) $this->input->post('id_kendaraan');
        $no_polisi = strtoupper(trim($this->input->post('no_polisi')));

        // Validasi
        $this->form_validation->set_rules('no_polisi',       'No. Polisi',       'required|max_length[20]');
        $this->form_validation->set_rules('jenis_kendaraan', 'Jenis Kendaraan',  'required|max_length[50]');
        $this->form_validation->set_rules('merk',            'Merk',             'required|max_length[50]');
        $this->form_validation->set_rules('tipe',            'Tipe',             'required|max_length[50]');
        $this->form_validation->set_rules('tahun',           'Tahun',            'required|is_natural_no_zero|exact_length[4]');

        if (!$this->form_validation->run()) {
            echo json_encode([
                'status'  => 'error',
                'message' => validation_errors(' ', ' | '),
            ]);
            return;
        }

        // Cek duplikat no_polisi
        if ($this->kendaraan_model->is_no_polisi_exists($no_polisi, $id ?: null)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'No. Polisi <strong>' . html_escape($no_polisi) . '</strong> sudah terdaftar.',
            ]);
            return;
        }

        $payload = [
            'no_polisi'       => $no_polisi,
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'merk'            => $this->input->post('merk'),
            'tipe'            => $this->input->post('tipe'),
            'tahun'           => $this->input->post('tahun'),
            'is_unit_baru'    => $this->input->post('is_unit_baru') ? 1 : 0,
        ];

        if ($id) {
            // UPDATE
            $this->kendaraan_model->update($id, $payload);

            // Audit log
            $this->_audit('update_kendaraan', 'kendaraan', $id);

            echo json_encode([
                'status'  => 'success',
                'message' => 'Data kendaraan <strong>' . html_escape($no_polisi) . '</strong> berhasil diperbarui.',
            ]);
        } else {
            // INSERT
            $new_id = $this->kendaraan_model->insert($payload);

            // Audit log
            $this->_audit('tambah_kendaraan', 'kendaraan', $new_id);

            echo json_encode([
                'status'  => 'success',
                'message' => 'Kendaraan <strong>' . html_escape($no_polisi) . '</strong> berhasil ditambahkan.',
            ]);
        }
    }

    // =============================================
    // AJAX — Delete
    // =============================================
    public function delete()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id = (int) $this->input->post('id');

        // Cek apakah ada pengajuan terkait
        if ($this->kendaraan_model->has_pengajuan($id)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Kendaraan tidak dapat dihapus karena memiliki riwayat pengajuan uji kelayakan.',
            ]);
            return;
        }

        $this->kendaraan_model->delete($id);
        $this->_audit('hapus_kendaraan', 'kendaraan', $id);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Kendaraan berhasil dihapus.',
        ]);
    }

    // =============================================
    // AJAX — Get dropdown list (untuk form pengajuan)
    // =============================================
    public function get_dropdown()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $rows = $this->kendaraan_model->get_all();
        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'id'   => $row->id_kendaraan,
                'text' => $row->no_polisi . ' — ' . $row->merk . ' ' . $row->tipe . ' (' . $row->jenis_kendaraan . ')',
            ];
        }
        echo json_encode(['results' => $data]);
    }

    // =============================================
    // Helper: Audit Log
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
