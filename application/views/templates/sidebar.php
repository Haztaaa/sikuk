<?php
// Deteksi halaman aktif dari URI
$_uri     = $this->uri->uri_string(); // misal: "pengajuan", "checklist/form/3"
$_seg1    = $this->uri->segment(1);   // controller
$_seg2    = $this->uri->segment(2);   // method

// Helper: cek apakah link ini aktif
function _nav_active($seg1, $match_seg1, $match_seg2 = null)
{
    if ($match_seg2) return ($seg1 === $match_seg1 . '/' . $match_seg2) ? '' : 'collapsed';
    return ($seg1 === $match_seg1) ? '' : 'collapsed';
}
function _is_active($seg1, ...$keys)
{
    foreach ($keys as $k) if (strpos($seg1, $k) === 0) return true;
    return false;
}

$_user_role = (int) $this->session->userdata('role');
// 1=Admin, 2=User/Pemohon, 3=Mekanik, 4=OHS, 5=KTT

// Hak akses per menu
$_can_buat_pengajuan  = in_array($_user_role, [1, 2]);
$_can_daftar_pengajuan = true; // semua role
$_can_approval        = in_array($_user_role, [1, 2, 4, 5]); // manager di user dept
$_can_jadwal          = in_array($_user_role, [1, 4]);
$_can_inspeksi        = in_array($_user_role, [1, 3]);
$_can_checklist_tmpl  = in_array($_user_role, [1]);
$_can_sticker         = in_array($_user_role, [1, 4]);
$_can_kendaraan       = in_array($_user_role, [1, 2]);
$_can_users           = in_array($_user_role, [1]);
$_can_laporan         = in_array($_user_role, [1, 4, 5]);
$_can_audit           = in_array($_user_role, [1]);
$_can_pengaturan      = in_array($_user_role, [1]);
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard — semua role -->
        <li class="nav-item">
            <a class="nav-link <?= _is_active($_seg1, 'dashboard') ? '' : 'collapsed' ?>"
                href="<?= base_url('dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- ===== PENGAJUAN ===== -->
        <?php if ($_can_buat_pengajuan || $_can_daftar_pengajuan): ?>
            <li class="nav-heading">Pengajuan</li>
        <?php endif; ?>

        <?php if ($_can_buat_pengajuan): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'pengajuan/create') ? '' : 'collapsed' ?>"
                    href="<?= base_url('pengajuan/create') ?>">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span>Buat Pengajuan</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_daftar_pengajuan): ?>
            <li class="nav-item">
                <a class="nav-link <?= (_is_active($_seg1, 'pengajuan') && $_seg1 !== 'pengajuan/create') ? '' : 'collapsed' ?>"
                    href="<?= base_url('pengajuan') ?>">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Daftar Pengajuan</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- ===== APPROVAL ===== -->
        <?php if ($_can_approval):
            // Cek sub-menu mana yang relevan per role
            $approval_open = _is_active($_seg1, 'approval');
            $_show_mgr   = in_array($_user_role, [1, 2]); // manager di dept user
            $_show_admin = in_array($_user_role, [1, 4]);
            $_show_ohs   = in_array($_user_role, [1, 4]);
            $_show_ktt   = in_array($_user_role, [1, 5]);
        ?>
            <li class="nav-item">
                <a class="nav-link <?= $approval_open ? '' : 'collapsed' ?>"
                    data-bs-target="#approval-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-check2-circle"></i>
                    <span>Approval</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="approval-nav" class="nav-content collapse <?= $approval_open ? 'show' : '' ?>"
                    data-bs-parent="#sidebar-nav">
                    <?php if ($_show_mgr): ?>
                        <li>
                            <a class="<?= _is_active($_uri, 'approval/manager') ? 'active' : '' ?>"
                                href="<?= base_url('approval/manager') ?>">
                                <i class="bi bi-circle"></i><span>Review Manager</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($_show_admin): ?>
                        <li>
                            <a class="<?= _is_active($_uri, 'approval/admin') ? 'active' : '' ?>"
                                href="<?= base_url('approval/admin_ohs') ?>">
                                <i class="bi bi-circle"></i><span>Review Admin OHS</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($_show_ohs): ?>
                        <li>
                            <a class="<?= _is_active($_uri, 'approval/ohs') ? 'active' : '' ?>"
                                href="<?= base_url('approval/ohs_supt') ?>">
                                <i class="bi bi-circle"></i><span>OHS Superintendent</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($_show_ktt): ?>
                        <li>
                            <a class="<?= _is_active($_uri, 'approval/ktt') ? 'active' : '' ?>"
                                href="<?= base_url('approval/ktt') ?>">
                                <i class="bi bi-circle"></i><span>Approval KTT</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <!-- ===== UJI KELAYAKAN ===== -->
        <?php if ($_can_jadwal || $_can_inspeksi || $_can_checklist_tmpl || $_can_sticker): ?>
            <li class="nav-heading">Uji Kelayakan</li>
        <?php endif; ?>

        <?php if ($_can_jadwal): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'jadwal') ? '' : 'collapsed' ?>"
                    href="<?= base_url('jadwal') ?>">
                    <i class="bi bi-calendar3"></i>
                    <span>Jadwal Uji</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_inspeksi): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'inspeksi') ? '' : 'collapsed' ?>"
                    href="<?= base_url('inspeksi') ?>">
                    <i class="bi bi-tools"></i>
                    <span>Form Inspeksi</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_checklist_tmpl): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'checklist') ? '' : 'collapsed' ?>"
                    href="<?= base_url('checklist') ?>">
                    <i class="bi bi-list-check"></i>
                    <span>Checklist Template</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_sticker): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'sticker') ? '' : 'collapsed' ?>"
                    href="<?= base_url('sticker') ?>">
                    <i class="bi bi-patch-check"></i>
                    <span>Sticker Release</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- ===== DATA MASTER ===== -->
        <?php if ($_can_kendaraan || $_can_users): ?>
            <li class="nav-heading">Data Master</li>
        <?php endif; ?>

        <?php if ($_can_kendaraan): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'kendaraan') ? '' : 'collapsed' ?>"
                    href="<?= base_url('kendaraan') ?>">
                    <i class="bi bi-truck"></i>
                    <span>Data Kendaraan</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_users): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'users') ? '' : 'collapsed' ?>"
                    href="<?= base_url('users') ?>">
                    <i class="bi bi-people"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- ===== LAPORAN & SISTEM ===== -->
        <?php if ($_can_laporan || $_can_audit || $_can_pengaturan): ?>
            <li class="nav-heading">Laporan & Sistem</li>
        <?php endif; ?>

        <?php if ($_can_laporan): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'laporan') ? '' : 'collapsed' ?>"
                    href="<?= base_url('laporan') ?>">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Laporan</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_audit): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'audit_log') ? '' : 'collapsed' ?>"
                    href="<?= base_url('audit_log') ?>">
                    <i class="bi bi-clock-history"></i>
                    <span>Audit Log</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_can_pengaturan): ?>
            <li class="nav-item">
                <a class="nav-link <?= _is_active($_seg1, 'pengaturan') ? '' : 'collapsed' ?>"
                    href="<?= base_url('pengaturan') ?>">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</aside><!-- End Sidebar -->
<div id="main-wrapper">