<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checklist extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Checklist_model'  => 'checklist_model',
            'Pengajuan_model'  => 'pengajuan_model',
            'Kendaraan_model'  => 'kendaraan_model'
        ]);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
    }

    // =============================================
    // DAFTAR TEMPLATE — halaman manajemen template
    // =============================================
    public function index()
    {
        $data['title']     = 'Checklist Template';
        $data['user']      = $this->session->userdata();
        $data['templates'] = $this->checklist_model->get_all_templates();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('checklist/index', $data);
        $this->load->view('templates/footer', $data);
    }

    // =============================================
    // DETAIL TEMPLATE — kelola items per template
    // =============================================
    public function template($id_template = null)
    {
        $id_template = (int) $id_template;
        $template    = $this->checklist_model->get_template($id_template);

        if (!$template) {
            $this->session->set_flashdata('error', 'Template tidak ditemukan.');
            redirect('checklist');
        }

        $items = $this->checklist_model->get_items($id_template);

        $grouped = ['CRITICAL' => [], 'GENERAL' => []];
        foreach ($items as $item) {
            $grouped[$item->kategori][] = $item;
        }

        $data['title']    = 'Template: ' . $template->jenis_unit;
        $data['user']     = $this->session->userdata();
        $data['template'] = $template;
        $data['grouped']  = $grouped;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('checklist/template', $data);
        $this->load->view('templates/footer', $data);
    }

    // =============================================
    // FORM INSPEKSI — mekanik isi checklist
    // =============================================
    public function form($id_pengajuan = null)
    {
        $id_pengajuan = (int) $id_pengajuan;
        $pengajuan    = $this->pengajuan_model->get_detail($id_pengajuan);

        if (!$pengajuan) {
            $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan.');
            redirect('pengajuan');
        }

        // Cari template berdasarkan jenis kendaraan
        $jenis_unit = Checklist_model::map_jenis($pengajuan->jenis_kendaraan);
        $template   = $jenis_unit ? $this->checklist_model->get_template_by_jenis($jenis_unit) : null;

        if (!$template) {
            $this->session->set_flashdata('error', 'Template checklist untuk jenis kendaraan "' . $pengajuan->jenis_kendaraan . '" tidak ditemukan.');
            redirect('pengajuan');
        }

        $items = $this->checklist_model->get_items($template->id_template);

        // Kelompokkan per kategori
        $grouped = ['CRITICAL' => [], 'GENERAL' => []];
        foreach ($items as $item) {
            $grouped[$item->kategori][] = $item;
        }

        // Jawaban existing (jika sudah pernah diisi)
        $existing = [];
        if ($pengajuan->status === 'inspected' || $pengajuan->status === 'review_ohs') {
            $uji = $this->pengajuan_model->get_uji($id_pengajuan);
            if ($uji) {
                $answers = $this->checklist_model->get_checklist_answers($uji->id_uji);
                foreach ($answers as $a) {
                    $existing[$a->id_item] = ['hasil' => $a->hasil, 'keterangan' => $a->keterangan];
                }
            }
        }

        $data['title']        = 'Form Inspeksi — ' . $pengajuan->no_polisi;
        $data['user']         = $this->session->userdata();
        $data['pengajuan']    = $pengajuan;
        $data['template']     = $template;
        $data['grouped']      = $grouped;
        $data['existing']     = $existing;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('checklist/form', $data);
        $this->load->view('templates/footer', $data);
    }

    // =============================================
    // SUBMIT HASIL INSPEKSI (AJAX)
    // =============================================
    public function submit()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_pengajuan = (int) $this->input->post('id_pengajuan');
        $id_template  = (int) $this->input->post('id_template');
        $catatan      = $this->input->post('catatan_umum');
        $items_post   = $this->input->post('items'); // array [id_item => [hasil, keterangan]]
        if (!is_array($items_post)) $items_post = [];

        $pengajuan = $this->pengajuan_model->get_detail($id_pengajuan);
        if (!$pengajuan) {
            echo json_encode(['status' => 'error', 'message' => 'Data pengajuan tidak ditemukan.']);
            return;
        }

        // Validasi: semua item harus dijawab
        $template_items = $this->checklist_model->get_items($id_template);
        $missing = [];
        foreach ($template_items as $item) {
            if (empty($items_post[$item->id_item]['hasil'])) {
                $missing[] = $item->no_urut;
            }
        }
        if (!empty($missing)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Item no. ' . implode(', ', $missing) . ' belum dijawab.',
            ]);
            return;
        }

        // Insert atau update uji_kelayakan
        $id_mekanik = $this->session->userdata('id_user');
        $uji_existing = $this->pengajuan_model->get_uji($id_pengajuan);

        if ($uji_existing) {
            $id_uji = $uji_existing->id_uji;
            $this->db->where('id_uji', $id_uji)->update('uji_kelayakan', [
                'catatan_umum' => $catatan,
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->db->insert('uji_kelayakan', [
                'id_pengajuan' => $id_pengajuan,
                'id_mekanik'   => $id_mekanik,
                'id_template'  => $id_template,
                'tanggal_uji'  => date('Y-m-d'),
                'catatan_umum' => $catatan,
                'hasil'        => 'pending', // akan diupdate setelah hitung
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
            $id_uji = $this->db->insert_id();
        }

        // Simpan jawaban checklist
        $this->checklist_model->save_checklist($id_uji, $items_post);

        // Hitung hasil
        $summary = $this->checklist_model->get_summary($id_uji);
        $hasil   = $summary['lulus'] ? 'lulus' : 'tidak_lulus';

        // Update hasil di uji_kelayakan
        $this->db->where('id_uji', $id_uji)->update('uji_kelayakan', ['hasil' => $hasil]);

        // Update status pengajuan
        $new_status = $summary['lulus'] ? 'review_ohs' : 'rejected';
        $this->db->where('id_pengajuan', $id_pengajuan)->update('pengajuan_uji', [
            'status' => $new_status,
        ]);

        // Audit log
        $this->db->insert('audit_log', [
            'id_user'    => $id_mekanik,
            'aksi'       => 'submit_inspeksi',
            'tabel'      => 'uji_kelayakan',
            'id_ref'     => $id_uji,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $summary['lulus']
            ? 'Inspeksi selesai. Kendaraan <strong>LULUS</strong> uji kelayakan dan diteruskan ke OHS untuk review.'
            : 'Inspeksi selesai. Kendaraan <strong>TIDAK LULUS</strong> — terdapat ' . $summary['critical_no'] . ' item CRITICAL yang tidak memenuhi syarat.';

        echo json_encode([
            'status'  => 'success',
            'message' => $msg,
            'hasil'   => $hasil,
            'summary' => $summary,
            'redirect' => site_url('pengajuan'),
        ]);
    }

    // =============================================
    // AJAX — Get template items (untuk dropdown jenis)
    // =============================================
    public function get_items()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_template = (int) $this->input->post('id_template');
        $items       = $this->checklist_model->get_items($id_template);

        echo json_encode(['status' => 'success', 'data' => $items]);
    }

    // =============================================
    // AJAX — Save item (tambah/edit dari halaman template)
    // =============================================
    public function save_item()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id       = (int) $this->input->post('id_item');
        $payload  = [
            'id_template' => (int) $this->input->post('id_template'),
            'kategori'    => $this->input->post('kategori'),
            'no_urut'     => $this->input->post('no_urut'),
            'kriteria'    => $this->input->post('kriteria'),
        ];

        if ($id) {
            $this->checklist_model->update_item($id, $payload);
            echo json_encode(['status' => 'success', 'message' => 'Item berhasil diperbarui.']);
        } else {
            $new_id = $this->checklist_model->insert_item($payload);
            echo json_encode(['status' => 'success', 'message' => 'Item berhasil ditambahkan.', 'id' => $new_id]);
        }
    }

    // =============================================
    // AJAX — Delete item
    // =============================================
    public function delete_item()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id = (int) $this->input->post('id_item');
        $this->checklist_model->delete_item($id);

        echo json_encode(['status' => 'success', 'message' => 'Item berhasil dihapus.']);
    }
}
