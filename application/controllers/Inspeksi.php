<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inspeksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Pengajuan_model', 'Checklist_model']);
        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('id_user')) redirect('auth/login');

        // Hanya Mekanik (3) dan Admin (1) boleh akses
        $role = (int) $this->session->userdata('role');
        if (!in_array($role, [1, 3])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    // =============================================
    // INDEX — daftar pengajuan siap diinspeksi
    // =============================================
    public function index()
    {
        $data['title'] = 'Form Inspeksi';
        $data['user']  = $this->session->userdata();

        // Ambil semua pengajuan status scheduled
        $this->db->select('pu.*, k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe, k.tahun,
                           u.nama AS nama_pemohon,
                           j.tanggal_uji, j.lokasi,
                           uk.id_uji, uk.hasil AS hasil_uji');
        $this->db->from('pengajuan_uji pu');
        $this->db->join('kendaraan k',    'k.id_kendaraan = pu.id_kendaraan');
        $this->db->join('users u',        'u.id_user = pu.id_pemohon');
        $this->db->join('jadwal_uji j',   'j.id_pengajuan = pu.id_pengajuan AND j.status = "scheduled"', 'left');
        $this->db->join('uji_kelayakan uk', 'uk.id_pengajuan = pu.id_pengajuan', 'left');
        $this->db->where('pu.status', 'scheduled');
        $this->db->order_by('j.tanggal_uji', 'ASC');

        $data['list_inspeksi'] = $this->db->get()->result();

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('inspeksi/index',    $data);
        $this->load->view('templates/footer',  $data);
    }
}
