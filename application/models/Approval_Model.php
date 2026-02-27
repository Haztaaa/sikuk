<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // =============================================
    // Daftar pengajuan per level approval
    // =============================================
    public function get_list($status_pengajuan, $filters = [])
    {
        $this->db->select('
            pu.*,
            k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe, k.tahun, k.is_unit_baru,
            u.nama AS nama_pemohon, u.email AS email_pemohon,
            pa.id_approval, pa.status AS status_approval, pa.catatan AS catatan_approval, pa.created_at AS tgl_approval
        ');
        $this->db->from('pengajuan_uji pu');
        $this->db->join('kendaraan k',          'k.id_kendaraan = pu.id_kendaraan');
        $this->db->join('users u',              'u.id_user = pu.id_pemohon');
        $this->db->join('pengajuan_approval pa', 'pa.id_pengajuan = pu.id_pengajuan AND pa.status = "pending"', 'left');

        if (is_array($status_pengajuan)) {
            $this->db->where_in('pu.status', $status_pengajuan);
        } else {
            $this->db->where('pu.status', $status_pengajuan);
        }

        if (!empty($filters['search'])) {
            $kw = $filters['search'];
            $this->db->group_start();
            $this->db->like('k.no_polisi', $kw);
            $this->db->or_like('u.nama',   $kw);
            $this->db->group_end();
        }

        $this->db->order_by('pu.tanggal_pengajuan', 'ASC');
        return $this->db->get()->result();
    }

    // =============================================
    // Detail pengajuan + semua relasi
    // =============================================
    public function get_detail($id)
    {
        $this->db->select('
            pu.*,
            k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe, k.tahun, k.is_unit_baru,
            u.nama AS nama_pemohon, u.email AS email_pemohon
        ');
        $this->db->from('pengajuan_uji pu');
        $this->db->join('kendaraan k', 'k.id_kendaraan = pu.id_kendaraan');
        $this->db->join('users u',     'u.id_user = pu.id_pemohon');
        $this->db->where('pu.id_pengajuan', $id);
        return $this->db->get()->row();
    }

    // =============================================
    // Riwayat approval
    // =============================================
    public function get_riwayat($id_pengajuan)
    {
        $this->db->select('pa.*, u.nama AS nama_approver');
        $this->db->from('pengajuan_approval pa');
        $this->db->join('users u', 'u.id_user = pa.id_approver', 'left');
        $this->db->where('pa.id_pengajuan', $id_pengajuan);
        $this->db->order_by('pa.id_approval', 'ASC');
        return $this->db->get()->result();
    }

    // =============================================
    // Lampiran
    // =============================================
    public function get_lampiran($id_pengajuan)
    {
        return $this->db
            ->where('id_pengajuan', $id_pengajuan)
            ->get('pengajuan_lampiran')->result();
    }

    // =============================================
    // Proses approve / reject
    // params:
    //   $id_pengajuan  : int
    //   $aksi          : 'approve' | 'reject'
    //   $level         : 'manager' | 'admin' (sesuai level_approval)
    //   $status_next   : status pengajuan setelah approve
    //   $status_next_reject : status jika reject (default: rejected)
    //   $level_next    : level approval berikutnya (null jika tidak ada)
    //   $id_approver   : int
    //   $catatan       : string
    // =============================================
    public function proses($params)
    {
        extract($params);
        // $id_pengajuan, $aksi, $level, $status_next, $id_approver, $catatan
        // $level_next (optional), $status_reject (optional)

        $status_reject = isset($status_reject) ? $status_reject : 'rejected';

        $this->db->trans_start();

        // 1. Update record approval yang pending
        $this->db->where('id_pengajuan', $id_pengajuan)
            ->where('status', 'pending')
            ->update('pengajuan_approval', [
                'id_approver'    => $id_approver,
                'status'         => ($aksi === 'approve') ? 'approved' : 'rejected',
                'catatan'        => $catatan,
                'created_at'     => date('Y-m-d H:i:s'),
            ]);

        if ($aksi === 'approve') {
            // 2a. Update status pengajuan
            $this->db->where('id_pengajuan', $id_pengajuan)
                ->update('pengajuan_uji', ['status' => $status_next]);

            // 2b. Buat record approval berikutnya jika ada
            if (!empty($level_next)) {
                $this->db->insert('pengajuan_approval', [
                    'id_pengajuan'   => $id_pengajuan,
                    'level_approval' => $level_next,
                    'status'         => 'pending',
                ]);
            }
        } else {
            // Reject → update status
            $this->db->where('id_pengajuan', $id_pengajuan)
                ->update('pengajuan_uji', ['status' => $status_reject]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
