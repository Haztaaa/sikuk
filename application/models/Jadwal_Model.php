<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Semua jadwal dengan join detail
    public function get_all($filter = [])
    {
        $this->db->select('j.*, 
            pu.tipe_pengajuan, pu.tipe_akses, pu.status AS status_pengajuan,
            k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe AS tipe_kendaraan, k.tahun,
            u_pemohon.nama AS nama_pemohon,
            u_dibuat.nama AS dibuat_oleh_nama');
        $this->db->from('jadwal_uji j');
        $this->db->join('pengajuan_uji pu', 'pu.id_pengajuan = j.id_pengajuan');
        $this->db->join('kendaraan k',      'k.id_kendaraan = pu.id_kendaraan');
        $this->db->join('users u_pemohon',  'u_pemohon.id_user = pu.id_pemohon');
        $this->db->join('users u_dibuat',   'u_dibuat.id_user = j.dibuat_oleh', 'left');

        if (!empty($filter['status']))    $this->db->where('j.status', $filter['status']);
        if (!empty($filter['bulan']))     $this->db->where('MONTH(j.tanggal_uji)', $filter['bulan']);
        if (!empty($filter['tahun']))     $this->db->where('YEAR(j.tanggal_uji)', $filter['tahun']);

        $this->db->order_by('j.tanggal_uji', 'ASC');
        return $this->db->get()->result();
    }

    // Jadwal by id
    public function get_by_id($id)
    {
        $this->db->select('j.*,
            pu.tipe_pengajuan, pu.tipe_akses, pu.status AS status_pengajuan,
            pu.nomor_mesin, pu.nomor_rangka, pu.tujuan,
            k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe AS tipe_kendaraan, k.tahun,
            u_pemohon.nama AS nama_pemohon, u_pemohon.email AS email_pemohon,
            u_dibuat.nama AS dibuat_oleh_nama');
        $this->db->from('jadwal_uji j');
        $this->db->join('pengajuan_uji pu', 'pu.id_pengajuan = j.id_pengajuan');
        $this->db->join('kendaraan k',      'k.id_kendaraan = pu.id_kendaraan');
        $this->db->join('users u_pemohon',  'u_pemohon.id_user = pu.id_pemohon');
        $this->db->join('users u_dibuat',   'u_dibuat.id_user = j.dibuat_oleh', 'left');
        $this->db->where('j.id_jadwal', $id);
        return $this->db->get()->row();
    }

    // Jadwal by id_pengajuan
    public function get_by_pengajuan($id_pengajuan)
    {
        $this->db->where('id_pengajuan', $id_pengajuan);
        return $this->db->get('jadwal_uji')->row();
    }

    // Insert jadwal
    public function insert($data)
    {
        $this->db->insert('jadwal_uji', $data);
        return $this->db->insert_id();
    }

    // Update jadwal
    public function update($id, $data)
    {
        $this->db->where('id_jadwal', $id);
        return $this->db->update('jadwal_uji', $data);
    }

    // Update status jadwal
    public function update_status($id, $status)
    {
        $this->db->where('id_jadwal', $id);
        return $this->db->update('jadwal_uji', ['status' => $status]);
    }

    // Hapus jadwal (cancel — status kembali ke approved_admin)
    public function cancel($id)
    {
        $jadwal = $this->get_by_id($id);
        if (!$jadwal) return false;

        $this->db->trans_start();
        $this->db->where('id_jadwal', $id)->update('jadwal_uji', ['status' => 'cancelled']);
        $this->db->where('id_pengajuan', $jadwal->id_pengajuan)
            ->update('pengajuan_uji', ['status' => 'approved_admin']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Ambil mekanik tersedia (role=3)
    public function get_mekanik()
    {
        // Coba pakai kolom id_role langsung di tabel users
        // Jika pakai tabel user_roles, gunakan query di bawah
        $this->db->select('u.id_user, u.nama, u.email');
        $this->db->from('users u');
        // Coba join user_roles dulu, fallback ke kolom id_role
        // Support kedua struktur: id_role di users ATAU tabel user_roles
        $this->db->join('user_roles ur', 'ur.id_user = u.id_user', 'left');
        $this->db->group_start();
        $this->db->where('ur.id_role', 3);
        $this->db->or_where('u.id_role', 3);
        $this->db->group_end();
        $this->db->where('u.is_active', 1);
        $this->db->group_by('u.id_user');
        $this->db->order_by('u.nama', 'ASC');
        return $this->db->get()->result();
    }

    // Cek konflik jadwal (mekanik sudah terjadwal di tanggal yang sama)
    public function cek_konflik($tanggal_uji, $id_mekanik, $exclude_id = null)
    {
        $tgl = date('Y-m-d', strtotime($tanggal_uji));
        $this->db->where("DATE(j.tanggal_uji)", $tgl);
        $this->db->where('j.id_mekanik', $id_mekanik);
        $this->db->where('j.status', 'scheduled');
        if ($exclude_id) $this->db->where('j.id_jadwal !=', $exclude_id);
        $this->db->from('jadwal_uji j');
        return $this->db->count_all_results() > 0;
    }
}
