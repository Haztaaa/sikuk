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
        $data['kendaraan']      = $this->kendaraan_model->get_all();
        $data['tipe_kendaraan'] = $this->db->where('is_active', 1)->order_by('nama_tipe', 'ASC')->get('tipe_kendaraan')->result();
        $data['perusahaan']     = $this->db->where('is_active', 1)->order_by('nama_perusahaan', 'ASC')->get('perusahaan')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengajuan/create', $data);
        $this->load->view('templates/footer', $data);
    }

    // =============================================
    // STORE — Proses simpan pengajuan baru (AJAX)
    // mode_unit = 'baru'  → insert kendaraan baru + upload lampiran
    // mode_unit = 'lama'  → pakai id_kendaraan existing
    // =============================================
    public function store()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_user   = $this->session->userdata('id_user');
        $mode_unit = $this->input->post('mode_unit'); // 'baru' | 'lama'

        // --- Validasi field umum ---
        $this->form_validation->set_rules('tipe_pengajuan', 'Tipe Pengajuan',    'required|in_list[new_commissioning,recommissioning]');
        $this->form_validation->set_rules('tipe_akses',     'Tipe Akses',        'required|in_list[mining,non_mining]');
        $this->form_validation->set_rules('tujuan',         'Tujuan Penggunaan', 'required|max_length[1000]');
        $this->form_validation->set_rules('email_pemohon',  'Email Pemohon',     'required|valid_email|max_length[100]');

        if (!$this->form_validation->run()) {
            echo json_encode(['status' => 'error', 'message' => validation_errors('<li>', '</li>')]);
            return;
        }

        $id_kendaraan = 0;
        $is_unit_baru = false;

        // ==========================================
        // MODE: UNIT BARU — daftar kendaraan + upload
        // ==========================================
        if ($mode_unit === 'baru') {
            $no_polisi = strtoupper(trim($this->input->post('no_polisi')));
            $required  = ['jenis_kendaraan', 'nomor_unit', 'merk', 'model_unit', 'no_polisi', 'nomor_rangka', 'nomor_mesin', 'perusahaan', 'tahun'];
            foreach ($required as $f) {
                if (!$this->input->post($f)) {
                    echo json_encode(['status' => 'error', 'message' => 'Field <strong>' . $f . '</strong> wajib diisi.']);
                    return;
                }
            }

            // Cek no_polisi belum terdaftar
            $cek = $this->db->where('no_polisi', $no_polisi)->get('kendaraan')->row();
            if ($cek) {
                echo json_encode(['status' => 'error', 'message' => 'Nomor polisi <strong>' . $no_polisi . '</strong> sudah terdaftar. Gunakan Recommissioning.']);
                return;
            }

            // Validasi file lampiran wajib
            $foto_required = ['stnk', 'unit_depan', 'unit_belakang', 'unit_kiri', 'unit_kanan'];
            $foto_label    = ['stnk' => 'Foto STNK', 'unit_depan' => 'Foto Depan', 'unit_belakang' => 'Foto Belakang', 'unit_kiri' => 'Foto Kiri', 'unit_kanan' => 'Foto Kanan'];
            foreach ($foto_required as $f) {
                if (empty($_FILES['lampiran_' . $f]['name'])) {
                    echo json_encode(['status' => 'error', 'message' => '<strong>' . $foto_label[$f] . '</strong> wajib diupload untuk unit baru.']);
                    return;
                }
            }

            // Insert kendaraan baru
            $id_kendaraan = $this->kendaraan_model->insert([
                'no_polisi'       => $no_polisi,
                'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
                'nomor_unit'      => $this->input->post('nomor_unit'),
                'merk'            => $this->input->post('merk'),
                'tipe'            => $this->input->post('model_unit'), // tipe = model
                'model_unit'      => $this->input->post('model_unit'),
                'perusahaan'      => $this->input->post('perusahaan'),
                'tahun'           => (int) $this->input->post('tahun'),
                'is_unit_baru'    => 1,
                'created_at'      => date('Y-m-d H:i:s'),
            ]);

            if (!$id_kendaraan) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftarkan kendaraan baru.']);
                return;
            }
            $is_unit_baru = true;

            // ==========================================
            // MODE: UNIT LAMA — pakai kendaraan existing
            // ==========================================
        } elseif ($mode_unit === 'lama') {
            $id_kendaraan = (int) $this->input->post('id_kendaraan');
            if (!$id_kendaraan) {
                echo json_encode(['status' => 'error', 'message' => 'Pilih kendaraan yang sudah terdaftar.']);
                return;
            }
            $kendaraan = $this->kendaraan_model->get_by_id($id_kendaraan);
            if (!$kendaraan) {
                echo json_encode(['status' => 'error', 'message' => 'Kendaraan tidak ditemukan.']);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Mode unit tidak valid.']);
            return;
        }

        // ==========================================
        // Insert pengajuan
        // ==========================================
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
            // Rollback: hapus kendaraan baru jika insert pengajuan gagal
            if ($is_unit_baru) $this->db->where('id_kendaraan', $id_kendaraan)->delete('kendaraan');
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pengajuan.']);
            return;
        }

        // Upload lampiran (unit baru)
        if ($is_unit_baru) {
            $upload_errors = $this->_upload_lampiran($id_pengajuan);
            if (!empty($upload_errors)) {
                $this->pengajuan_model->delete_pengajuan($id_pengajuan);
                $this->db->where('id_kendaraan', $id_kendaraan)->delete('kendaraan');
                echo json_encode(['status' => 'error', 'message' => 'Gagal upload:<ul><li>' . implode('</li><li>', $upload_errors) . '</li></ul>']);
                return;
            }
        }

        // Buat record approval awal → manager
        $this->pengajuan_model->insert_approval([
            'id_pengajuan'   => $id_pengajuan,
            'level_approval' => 'manager',
            'status'         => 'pending',
        ]);

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
        $upload_path = FCPATH . 'uploads/lampiran/' . $id_pengajuan . '/';

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

        // Role sekarang integer: 1=Admin, 2=User, 3=Mekanik, 4=OHS, 5=KTT
        $role = (int) $role;

        // Manager (role 2) approve submitted
        if (in_array($role, [1, 2]) && $row->status === 'submitted') {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-approve" data-id="' . $id . '" data-level="manager" title="Setujui"><i class="bi bi-check-lg"></i></button>';
            $btn .= '<button class="btn btn-sm btn-danger py-0 btn-reject"  data-id="' . $id . '" data-level="manager" title="Tolak"><i class="bi bi-x-lg"></i></button>';
        }

        // Admin OHS (role 4) buat jadwal setelah approved_admin
        if (in_array($role, [1, 4]) && $row->status === 'approved_admin') {
            $btn .= '<a href="' . site_url('jadwal/create/' . $id) . '" class="btn btn-sm btn-info py-0 text-white" title="Buat Jadwal"><i class="bi bi-calendar-plus"></i></a>';
        }

        // Admin OHS review hasil inspeksi
        if (in_array($role, [1, 4]) && $row->status === 'review_ohs') {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-approve" data-id="' . $id . '" data-level="admin_ohs_hasil" title="Setujui Hasil"><i class="bi bi-check-lg"></i></button>';
            $btn .= '<button class="btn btn-sm btn-danger py-0 btn-reject"  data-id="' . $id . '" data-level="admin_ohs_hasil" title="Tolak"><i class="bi bi-x-lg"></i></button>';
        }

        // OHS Superintendent (role 4)
        if (in_array($role, [1, 4]) && $row->status === 'approved_ohs') {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-approve" data-id="' . $id . '" data-level="ohs_supt" title="Setujui OHS"><i class="bi bi-check-lg"></i></button>';
            $btn .= '<button class="btn btn-sm btn-danger py-0 btn-reject"  data-id="' . $id . '" data-level="ohs_supt" title="Tolak"><i class="bi bi-x-lg"></i></button>';
        }

        // KTT (role 5)
        if (in_array($role, [1, 5]) && $row->status === 'approved_ktt') {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-approve" data-id="' . $id . '" data-level="ktt" title="Approve KTT"><i class="bi bi-check-lg"></i></button>';
            $btn .= '<button class="btn btn-sm btn-danger py-0 btn-reject"  data-id="' . $id . '" data-level="ktt" title="Tolak"><i class="bi bi-x-lg"></i></button>';
        }

        // Mekanik (role 3) isi form inspeksi
        if (in_array($role, [1, 3]) && $row->status === 'scheduled') {
            $btn .= '<a href="' . site_url('checklist/form/' . $id) . '" class="btn btn-sm btn-warning py-0" title="Isi Form Inspeksi"><i class="bi bi-tools"></i></a>';
        }

        // Admin OHS / Admin rilis sticker
        if (in_array($role, [1, 4]) && $row->status === 'sticker_released') {
            $btn .= '<button class="btn btn-sm btn-success py-0 btn-sticker" data-id="' . $id . '" title="Cetak Sticker"><i class="bi bi-patch-check"></i></button>';
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
