<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kendaraan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // =============================================
    // Base Query
    // =============================================
    private function _base_query($filters = [])
    {
        $this->db->select('k.*, COUNT(pu.id_pengajuan) AS total_pengajuan');
        $this->db->from('kendaraan k');
        $this->db->join('pengajuan_uji pu', 'pu.id_kendaraan = k.id_kendaraan', 'left');
        $this->db->group_by('k.id_kendaraan');

        if (!empty($filters['search'])) {
            $kw = $filters['search'];
            $this->db->group_start();
            $this->db->like('k.no_polisi',       $kw);
            $this->db->or_like('k.jenis_kendaraan', $kw);
            $this->db->or_like('k.merk',          $kw);
            $this->db->or_like('k.tipe',          $kw);
            $this->db->group_end();
        }

        if (!empty($filters['jenis_kendaraan'])) {
            $this->db->where('k.jenis_kendaraan', $filters['jenis_kendaraan']);
        }

        if (isset($filters['is_unit_baru']) && $filters['is_unit_baru'] !== '') {
            $this->db->where('k.is_unit_baru', $filters['is_unit_baru']);
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
        $this->db->order_by('k.created_at', 'DESC');
        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }

    // =============================================
    // Get semua (untuk dropdown)
    // =============================================
    public function get_all()
    {
        return $this->db
            ->order_by('no_polisi', 'ASC')
            ->get('kendaraan')
            ->result();
    }

    // =============================================
    // Get by ID
    // =============================================
    public function get_by_id($id)
    {
        return $this->db
            ->where('id_kendaraan', $id)
            ->get('kendaraan')
            ->row();
    }

    // =============================================
    // Cek no_polisi unik (exclude ID saat edit)
    // =============================================
    public function is_no_polisi_exists($no_polisi, $exclude_id = null)
    {
        $this->db->where('no_polisi', $no_polisi);
        if ($exclude_id) {
            $this->db->where('id_kendaraan !=', $exclude_id);
        }
        return $this->db->count_all_results('kendaraan') > 0;
    }

    // =============================================
    // Insert
    // =============================================
    public function insert($data)
    {
        $this->db->insert('kendaraan', $data);
        return $this->db->insert_id();
    }

    // =============================================
    // Update
    // =============================================
    public function update($id, $data)
    {
        $this->db->where('id_kendaraan', $id);
        return $this->db->update('kendaraan', $data);
    }

    // =============================================
    // Delete (cek dulu apakah ada pengajuan)
    // =============================================
    public function delete($id)
    {
        $this->db->where('id_kendaraan', $id);
        return $this->db->delete('kendaraan');
    }

    public function has_pengajuan($id)
    {
        return $this->db
            ->where('id_kendaraan', $id)
            ->count_all_results('pengajuan_uji') > 0;
    }

    // =============================================
    // Get daftar jenis (untuk dropdown filter)
    // =============================================
    public function get_jenis_list()
    {
        return $this->db
            ->select('jenis_kendaraan')
            ->distinct()
            ->order_by('jenis_kendaraan')
            ->get('kendaraan')
            ->result();
    }
}
