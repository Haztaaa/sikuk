<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // =============================================
    // Base query builder dengan JOIN
    // =============================================
    private function _base_query($filters = [])
    {
        $this->db->select('
            pu.*,
            k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe, k.tahun, k.is_unit_baru,
            u.nama AS nama_pemohon, u.email AS email_user
        ');
        $this->db->from('pengajuan_uji pu');
        $this->db->join('kendaraan k', 'k.id_kendaraan = pu.id_kendaraan', 'left');
        $this->db->join('users u',     'u.id_user = pu.id_pemohon',        'left');

        if (!empty($filters['status'])) {
            $this->db->where('pu.status', $filters['status']);
        }
        if (!empty($filters['jenis'])) {
            $this->db->where('k.jenis_kendaraan', $filters['jenis']);
        }
        if (!empty($filters['tgl_dari'])) {
            $this->db->where('DATE(pu.tanggal_pengajuan) >=', $filters['tgl_dari']);
        }
        if (!empty($filters['tgl_sampai'])) {
            $this->db->where('DATE(pu.tanggal_pengajuan) <=', $filters['tgl_sampai']);
        }
        if (!empty($filters['search'])) {
            $kw = $filters['search'];
            $this->db->group_start();
            $this->db->like('k.no_polisi',          $kw);
            $this->db->or_like('u.nama',             $kw);
            $this->db->or_like('k.jenis_kendaraan',  $kw);
            $this->db->or_like('k.merk',             $kw);
            $this->db->or_like('k.tipe',             $kw);
            $this->db->group_end();
        }
    }

    // =============================================
    // Count
    // =============================================
    public function count_all($filters = [])
    {
        $this->_base_query($filters);
        return $this->db->count_all_results();
    }

    public function count_filtered($filters = [])
    {
        $this->_base_query($filters);
        return $this->db->count_all_results();
    }

    // =============================================
    // DataTables
    // =============================================
    public function get_datatable($start, $length, $filters = [])
    {
        $this->_base_query($filters);
        $this->db->order_by('pu.tanggal_pengajuan', 'DESC');
        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }

    // =============================================
    // Detail satu pengajuan
    // =============================================
    public function get_detail($id)
    {
        $this->db->select('
            pu.*,
            k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe, k.tahun, k.is_unit_baru,
            u.nama AS nama_pemohon, u.email AS email_user
        ');
        $this->db->from('pengajuan_uji pu');
        $this->db->join('kendaraan k', 'k.id_kendaraan = pu.id_kendaraan', 'left');
        $this->db->join('users u',     'u.id_user = pu.id_pemohon',        'left');
        $this->db->where('pu.id_pengajuan', $id);
        return $this->db->get()->row();
    }

    // =============================================
    // Insert pengajuan baru
    // =============================================
    public function insert_pengajuan($data)
    {
        $this->db->insert('pengajuan_uji', $data);
        return $this->db->insert_id();
    }

    // =============================================
    // Delete pengajuan (rollback jika upload gagal)
    // =============================================
    public function delete_pengajuan($id)
    {
        $this->db->where('id_pengajuan', $id);
        return $this->db->delete('pengajuan_uji');
    }

    // =============================================
    // Insert lampiran
    // =============================================
    public function insert_lampiran($data)
    {
        $this->db->insert('pengajuan_lampiran', $data);
        return $this->db->insert_id();
    }

    // =============================================
    // Get lampiran by id_pengajuan
    // =============================================
    public function get_lampiran($id)
    {
        return $this->db
            ->where('id_pengajuan', $id)
            ->get('pengajuan_lampiran')
            ->result();
    }

    // =============================================
    // Insert approval record
    // =============================================
    public function insert_approval($data)
    {
        $this->db->insert('pengajuan_approval', $data);
        return $this->db->insert_id();
    }

    // =============================================
    // Get riwayat approval
    // =============================================
    public function get_approval($id)
    {
        $this->db->select('pa.*, u.nama AS nama_approver');
        $this->db->from('pengajuan_approval pa');
        $this->db->join('users u', 'u.id_user = pa.id_approver', 'left');
        $this->db->where('pa.id_pengajuan', $id);
        $this->db->order_by('pa.id_approval', 'ASC');
        return $this->db->get()->result();
    }

    // =============================================
    // Get jadwal uji
    // =============================================
    public function get_jadwal($id)
    {
        $this->db->select('j.*, u.nama AS dibuat_oleh_nama');
        $this->db->from('jadwal_uji j');
        $this->db->join('users u', 'u.id_user = j.dibuat_oleh', 'left');
        $this->db->where('j.id_pengajuan', $id);
        return $this->db->get()->row();
    }

    // =============================================
    // Get hasil uji kelayakan
    // =============================================
    public function get_uji($id)
    {
        $this->db->select('uk.*, u.nama AS nama_mekanik');
        $this->db->from('uji_kelayakan uk');
        $this->db->join('users u', 'u.id_user = uk.id_mekanik', 'left');
        $this->db->where('uk.id_pengajuan', $id);
        return $this->db->get()->row();
    }

    // =============================================
    // Count by status (untuk dashboard/badge sidebar)
    // =============================================
    public function count_by_status($status)
    {
        return $this->db
            ->where('status', $status)
            ->count_all_results('pengajuan_uji');
    }
}
