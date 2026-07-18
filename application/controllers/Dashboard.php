<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Pengajuan_model', 'Jadwal_model']);
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this->session->userdata('id_user')) redirect('auth/login');
    }

    public function index()
    {
        $roles   = $this->_user_roles();
        $id_user = (int) $this->session->userdata('id_user');
        $bln     = date('m');
        $thn     = date('Y');
        $bln_lalu = date('m', strtotime('last month'));
        $thn_lalu = date('Y', strtotime('last month'));

        // ── Status aktif (semua yang sedang berjalan) ─────────────────────────
        $status_aktif = [
            'pengajuan_baru',
            'pengajuan_ulang',
            'diterima_manager',
            'dijadwalkan',
            'selesai_inspeksi',
            'diterima_admin_ohs',
            'diterima_ohs_supt',
            'acc_ktt',
        ];

        $status_selesai = ['stiker_keluar'];
        $status_ditolak = ['ditolak_manager', 'ditolak_admin_ohs', 'ditolak_ohs_supt', 'ditolak_ktt', 'rejected'];

        // ── Stat Cards ────────────────────────────────────────────────────────
        $total_bulan = $this->db
            ->where('MONTH(tanggal_pengajuan)', $bln)->where('YEAR(tanggal_pengajuan)', $thn)
            ->count_all_results('pengajuan_uji');

        $total_lalu = $this->db
            ->where('MONTH(tanggal_pengajuan)', $bln_lalu)->where('YEAR(tanggal_pengajuan)', $thn_lalu)
            ->count_all_results('pengajuan_uji');

        $delta_pengajuan = $total_bulan - $total_lalu;

        $lulus_bulan = $this->db
            ->where('MONTH(tanggal_pengajuan)', $bln)->where('YEAR(tanggal_pengajuan)', $thn)
            ->where_in('status', ['stiker_keluar', 'acc_ktt'])
            ->count_all_results('pengajuan_uji');

        $pass_rate = $total_bulan > 0 ? round(($lulus_bulan / $total_bulan) * 100) : 0;

        $menunggu = $this->db->where_in('status', $status_aktif)->count_all_results('pengajuan_uji');

        $perlu_tindakan = $this->db
            ->where_in('status', ['pengajuan_baru', 'pengajuan_ulang', 'selesai_inspeksi', 'ditolak_admin_ohs'])
            ->where('tanggal_pengajuan <', date('Y-m-d H:i:s', strtotime('-3 days')))
            ->count_all_results('pengajuan_uji');

        // ── Pipeline ──────────────────────────────────────────────────────────
        $pipeline = [
            'pengajuan_masuk' => $this->db->where_in('status', ['pengajuan_baru', 'pengajuan_ulang'])->count_all_results('pengajuan_uji'),
            'review_manager'  => $this->db->where('status', 'diterima_manager')->count_all_results('pengajuan_uji'),
            'dijadwalkan'     => $this->db->where('status', 'dijadwalkan')->count_all_results('pengajuan_uji'),
            'inspeksi'        => $this->db->where_in('status', ['selesai_inspeksi', 'diterima_admin_ohs', 'diterima_ohs_supt'])->count_all_results('pengajuan_uji'),
            'stiker_keluar'   => $this->db->where('status', 'stiker_keluar')->count_all_results('pengajuan_uji'),
        ];

        // ── Trend Chart (12 bulan terakhir) ──────────────────────────────────
        $trend_labels  = [];
        $trend_masuk   = [];
        $trend_lulus   = [];
        $trend_ditolak = [];
        for ($i = 11; $i >= 0; $i--) {
            $ts = strtotime("-$i months");
            $m  = date('m', $ts);
            $y  = date('Y', $ts);
            $trend_labels[]  = date('M', $ts);
            $trend_masuk[]   = (int)$this->db->where('MONTH(tanggal_pengajuan)', $m)->where('YEAR(tanggal_pengajuan)', $y)->count_all_results('pengajuan_uji');
            $trend_lulus[]   = (int)$this->db->where('MONTH(tanggal_pengajuan)', $m)->where('YEAR(tanggal_pengajuan)', $y)->where('status', 'stiker_keluar')->count_all_results('pengajuan_uji');
            $trend_ditolak[] = (int)$this->db->where('MONTH(tanggal_pengajuan)', $m)->where('YEAR(tanggal_pengajuan)', $y)->where_in('status', $status_ditolak)->count_all_results('pengajuan_uji');
        }

        // ── Rekap Pie bulan ini ───────────────────────────────────────────────
        $rekap_lulus  = $this->db->where('MONTH(tanggal_pengajuan)', $bln)->where('YEAR(tanggal_pengajuan)', $thn)->where('status', 'stiker_keluar')->count_all_results('pengajuan_uji');
        $rekap_proses = $this->db->where('MONTH(tanggal_pengajuan)', $bln)->where('YEAR(tanggal_pengajuan)', $thn)->where_in('status', ['pengajuan_baru', 'pengajuan_ulang', 'diterima_manager'])->count_all_results('pengajuan_uji');
        $rekap_jadwal = $this->db->where('MONTH(tanggal_pengajuan)', $bln)->where('YEAR(tanggal_pengajuan)', $thn)->where_in('status', ['dijadwalkan', 'selesai_inspeksi', 'diterima_admin_ohs', 'diterima_ohs_supt', 'acc_ktt'])->count_all_results('pengajuan_uji');
        $rekap_tolak  = $this->db->where('MONTH(tanggal_pengajuan)', $bln)->where('YEAR(tanggal_pengajuan)', $thn)->where_in('status', $status_ditolak)->count_all_results('pengajuan_uji');

        // ── Pengajuan terbaru ─────────────────────────────────────────────────
        $pengajuan_terbaru = $this->db
            ->select('pu.id_pengajuan, pu.status, pu.tanggal_pengajuan, k.no_polisi, t.nama_tipe AS jenis_kendaraan, k.merk, k.tipe, u.nama AS nama_pemohon')
            ->from('pengajuan_uji pu')
            ->join('kendaraan k',      'k.id_kendaraan = pu.id_kendaraan', 'left')
            ->join('tipe_kendaraan t', 't.id_tipe_kendaraan = k.id_tipe_kendaraan', 'left')
            ->join('users u',          'u.id_user = pu.id_pemohon', 'left')
            ->order_by('pu.tanggal_pengajuan', 'DESC')
            ->limit(6)->get()->result();

        // ── Jadwal mendatang ──────────────────────────────────────────────────
        $jadwal_mendatang = $this->db
            ->select('j.*, k.no_polisi, t.nama_tipe AS jenis_kendaraan, k.merk, k.tipe, u.nama AS nama_mekanik')
            ->from('jadwal_uji j')
            ->join('pengajuan_uji pu', 'pu.id_pengajuan = j.id_pengajuan', 'left')
            ->join('kendaraan k',      'k.id_kendaraan = pu.id_kendaraan', 'left')
            ->join('tipe_kendaraan t', 't.id_tipe_kendaraan = k.id_tipe_kendaraan', 'left')
            ->join('users u',          'u.id_user = j.id_mekanik', 'left')
            ->where('j.status', 'scheduled')
            ->where('j.tanggal_uji >=', date('Y-m-d H:i:s'))
            ->order_by('j.tanggal_uji', 'ASC')
            ->limit(5)->get()->result();

        // ── Approval queue per role ───────────────────────────────────────────
        // Roles: 1=Super Admin, 2=KTT, 3=OHS Supt, 4=Mekanik, 5=Admin OHS, 6=Dept Manager, 7=Admin Dept
        $approval_status = [];

        if (in_array(6, $roles) || in_array(1, $roles)) {
            // Dept Manager: pengajuan masuk + yang dikembalikan dari Admin OHS
            $approval_status = array_merge($approval_status, ['pengajuan_baru', 'pengajuan_ulang', 'ditolak_admin_ohs']);
        }
        if (in_array(5, $roles) || in_array(1, $roles)) {
            // Admin OHS: review dokumen (diterima manager) + review hasil + release stiker
            $approval_status = array_merge($approval_status, ['diterima_manager', 'selesai_inspeksi', 'acc_ktt']);
        }
        if (in_array(3, $roles) || in_array(1, $roles)) {
            // OHS Superintendent: diterima admin ohs + yang dikembalikan dari OHS Supt
            $approval_status = array_merge($approval_status, ['diterima_admin_ohs', 'ditolak_ohs_supt']);
        }
        if (in_array(2, $roles) || in_array(1, $roles)) {
            // KTT: diterima ohs supt
            $approval_status = array_merge($approval_status, ['diterima_ohs_supt']);
        }
        if (in_array(4, $roles) || in_array(1, $roles)) {
            // Mekanik: dijadwalkan
            $approval_status = array_merge($approval_status, ['dijadwalkan']);
        }
        if (in_array(7, $roles) && !in_array(1, $roles)) {
            // Admin Dept: lihat status pengajuan miliknya yang ditolak
            $approval_status = array_merge($approval_status, ['ditolak_manager']);
        }

        $approval_queue = [];
        if (!empty($approval_status)) {
            $q = $this->db
                ->select('pu.id_pengajuan, pu.status, pu.tanggal_pengajuan, k.no_polisi, t.nama_tipe AS jenis_kendaraan, k.merk, k.tipe, u.nama AS nama_pemohon')
                ->from('pengajuan_uji pu')
                ->join('kendaraan k',      'k.id_kendaraan = pu.id_kendaraan', 'left')
                ->join('tipe_kendaraan t', 't.id_tipe_kendaraan = k.id_tipe_kendaraan', 'left')
                ->join('users u',          'u.id_user = pu.id_pemohon', 'left')
                ->where_in('pu.status', array_unique($approval_status))
                ->order_by('pu.tanggal_pengajuan', 'ASC')
                ->limit(5);

            // Admin Dept hanya lihat miliknya
            if (in_array(7, $roles) && !in_array(1, $roles)) {
                $q->where('pu.id_pemohon', $id_user);
            }
            $approval_queue = $q->get()->result();
        }

        // ── Stiker siap diterbitkan (untuk Admin OHS) ─────────────────────────
        $siap_stiker = [];
        if (in_array(5, $roles) || in_array(1, $roles)) {
            $siap_stiker = $this->db
                ->select('pu.id_pengajuan, k.no_polisi, t.nama_tipe AS jenis_kendaraan, k.merk, u.nama AS nama_pemohon, pu.tanggal_pengajuan')
                ->from('pengajuan_uji pu')
                ->join('kendaraan k',      'k.id_kendaraan = pu.id_kendaraan', 'left')
                ->join('tipe_kendaraan t', 't.id_tipe_kendaraan = k.id_tipe_kendaraan', 'left')
                ->join('users u',          'u.id_user = pu.id_pemohon', 'left')
                ->where('pu.status', 'acc_ktt')
                ->order_by('pu.tanggal_pengajuan', 'DESC')
                ->limit(5)->get()->result();
        }

        // ── Aktivitas terbaru ─────────────────────────────────────────────────
        $aktivitas = $this->db
            ->select('al.*, u.nama AS nama_user')
            ->from('audit_log al')
            ->join('users u', 'u.id_user = al.id_user', 'left')
            ->order_by('al.created_at', 'DESC')
            ->limit(8)->get()->result();

        $data = [
            'title'             => 'Dashboard',
            'user'              => $this->session->userdata(),
            'total_bulan'       => $total_bulan,
            'delta_pengajuan'   => $delta_pengajuan,
            'lulus_bulan'       => $lulus_bulan,
            'pass_rate'         => $pass_rate,
            'menunggu'          => $menunggu,
            'perlu_tindakan'    => $perlu_tindakan,
            'pipeline'          => $pipeline,
            'trend_labels'      => json_encode($trend_labels),
            'trend_masuk'       => json_encode($trend_masuk),
            'trend_lulus'       => json_encode($trend_lulus),
            'trend_ditolak'     => json_encode($trend_ditolak),
            'rekap_lulus'       => $rekap_lulus,
            'rekap_proses'      => $rekap_proses,
            'rekap_jadwal'      => $rekap_jadwal,
            'rekap_tolak'       => $rekap_tolak,
            'pengajuan_terbaru' => $pengajuan_terbaru,
            'jadwal_mendatang'  => $jadwal_mendatang,
            'approval_queue'    => $approval_queue,
            'siap_stiker'       => $siap_stiker,
            'aktivitas'         => $aktivitas,
        ];

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index',   $data);
        $this->load->view('templates/footer',  $data);
    }
    public function rekap_commissioning()
    {
        if (!$this->input->is_ajax_request()) show_404();
        if (!$this->session->userdata('id_user')) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        $mode   = $this->input->post('mode')   ?: 'bulan';
        $dari   = $this->input->post('dari')   ?: null;
        $sampai = $this->input->post('sampai') ?: null;

        // ── Tentukan GROUP BY dan label format berdasarkan mode ──────────
        switch ($mode) {
            case 'hari':
                $group_by     = "DATE(pu.tanggal_pengajuan)";
                $label_format = "DATE_FORMAT(pu.tanggal_pengajuan, '%d %b')";
                $order_by     = "DATE(pu.tanggal_pengajuan) ASC";
                // Default range: 14 hari terakhir
                if (!$dari) $dari   = date('Y-m-d', strtotime('-13 days'));
                if (!$sampai) $sampai = date('Y-m-d');
                $where_tgl = "DATE(pu.tanggal_pengajuan) BETWEEN '$dari' AND '$sampai'";
                break;

            case 'minggu':
                $group_by     = "YEARWEEK(pu.tanggal_pengajuan, 1)";
                $label_format = "CONCAT('Minggu ', WEEK(pu.tanggal_pengajuan, 1), ' - ', YEAR(pu.tanggal_pengajuan))";
                $order_by     = "YEARWEEK(pu.tanggal_pengajuan, 1) ASC";
                if (!$dari) $dari   = date('Y-m-d', strtotime('-83 days')); // 12 minggu
                if (!$sampai) $sampai = date('Y-m-d');
                $where_tgl = "DATE(pu.tanggal_pengajuan) BETWEEN '$dari' AND '$sampai'";
                break;

            case 'tahun':
                $group_by     = "YEAR(pu.tanggal_pengajuan)";
                $label_format = "YEAR(pu.tanggal_pengajuan)";
                $order_by     = "YEAR(pu.tanggal_pengajuan) ASC";
                $where_tgl    = "YEAR(pu.tanggal_pengajuan) >= YEAR(NOW()) - 4"; // 5 tahun
                break;

            default: // bulan
                $group_by     = "DATE_FORMAT(pu.tanggal_pengajuan, '%Y-%m')";
                $label_format = "DATE_FORMAT(pu.tanggal_pengajuan, '%b %Y')";
                $order_by     = "DATE_FORMAT(pu.tanggal_pengajuan, '%Y-%m') ASC";
                $where_tgl    = "pu.tanggal_pengajuan >= DATE_SUB(NOW(), INTERVAL 11 MONTH)";
                break;
        }

        // Escape manual — input sudah divalidasi, tapi sanitasi format tanggal
        $dari   = $dari   ? date('Y-m-d', strtotime($dari))   : null;
        $sampai = $sampai ? date('Y-m-d', strtotime($sampai)) : null;
        if ($mode === 'hari' || $mode === 'minggu') {
            $where_tgl = "DATE(pu.tanggal_pengajuan) BETWEEN '$dari' AND '$sampai'";
        }

        // ── Query chart (per periode) ─────────────────────────────────────
        $chart_rows = $this->db->query("
    SELECT
        {$label_format}  AS label,
        {$group_by}      AS group_key,
        COUNT(*)         AS masuk,
        SUM(CASE WHEN pu.status IN ('stiker_keluar','acc_ktt') THEN 1 ELSE 0 END)                                                                        AS lulus,
        SUM(CASE WHEN pu.status IN ('ditolak_manager','ditolak_admin_ohs','ditolak_ohs_supt','ditolak_ktt','rejected') THEN 1 ELSE 0 END) AS tidak_lulus
    FROM pengajuan_uji pu
    WHERE {$where_tgl}
    GROUP BY {$group_by}, {$label_format}
    ORDER BY {$order_by}
")->result();

        // ── Query summary total periode ───────────────────────────────────
        $summary = $this->db->query("
    SELECT
        COUNT(*) AS total,
        SUM(CASE WHEN pu.status IN ('stiker_keluar','acc_ktt') THEN 1 ELSE 0 END)                                                                        AS lulus,
        SUM(CASE WHEN pu.status IN ('ditolak_manager','ditolak_admin_ohs','ditolak_ohs_supt','ditolak_ktt','rejected') THEN 1 ELSE 0 END) AS tidak_lulus
    FROM pengajuan_uji pu
    WHERE {$where_tgl}
")->row();

        // ── Query per jenis kendaraan ─────────────────────────────────────
        $per_jenis = $this->db->query("
    SELECT
        COALESCE(t.nama_tipe, 'Tidak Diketahui') AS jenis,
        COUNT(*) AS total,
        SUM(CASE WHEN pu.status IN ('stiker_keluar','acc_ktt') THEN 1 ELSE 0 END) AS lulus,
        SUM(CASE WHEN pu.status IN ('ditolak_manager','ditolak_admin_ohs','ditolak_ohs_supt','ditolak_ktt','rejected') THEN 1 ELSE 0 END) AS tidak_lulus
    FROM pengajuan_uji pu
    LEFT JOIN kendaraan k ON k.id_kendaraan = pu.id_kendaraan
    LEFT JOIN tipe_kendaraan t ON t.id_tipe_kendaraan = k.id_tipe_kendaraan
    WHERE {$where_tgl}
    GROUP BY t.id_tipe_kendaraan, t.nama_tipe
    ORDER BY total DESC
")->result();

        echo json_encode([
            'status' => 'success',
            'data'   => [
                'summary'   => [
                    'total'       => (int) ($summary->total       ?? 0),
                    'lulus'       => (int) ($summary->lulus       ?? 0),
                    'tidak_lulus' => (int) ($summary->tidak_lulus ?? 0),
                ],
                'chart'    => $chart_rows,
                'per_jenis' => $per_jenis,
            ],
        ]);
    }
    private function _user_roles()
    {
        $raw = $this->session->userdata('roles');
        if (is_array($raw) && !empty($raw)) return array_map('intval', $raw);
        $r = (int) $this->session->userdata('role');
        return $r > 0 ? [$r] : [];
    }
}
