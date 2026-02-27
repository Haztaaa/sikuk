<?php
// Ambil data user dari session
$_user_id    = $this->session->userdata('id_user');
$_user_nama  = $this->session->userdata('nama');
$_user_role  = (int) $this->session->userdata('role'); // 1=Admin,2=User,3=Mekanik,4=OHS,5=KTT

$_role_label = [
    1 => 'Administrator',
    2 => 'User / Pemohon',
    3 => 'Mekanik Inspector',
    4 => 'OHS Superintendent',
    5 => 'KTT',
];
$_role_nama = isset($_role_label[$_user_role]) ? $_role_label[$_user_role] : 'User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= isset($title) ? html_escape($title) . ' — SIKUK' : 'SIKUK' ?></title>

    <!-- Favicons -->
    <link href="<?= base_url('assets/img/favicon.png') ?>" rel="icon">
    <link href="<?= base_url('assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/datatables.bootstrap5.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/flatpickr.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/nprogress.css') ?>">

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="<?= base_url('assets/js/select2.min.js') ?>"></script>
    <!-- 2. Bootstrap Bundle (includes Popper) -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= base_url('dashboard') ?>" class="logo d-flex align-items-center">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="SIKUK">
                <span class="d-none d-lg-block">SIKUK</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <!-- Notifikasi -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <!-- badge notif bisa diisi dinamis dari controller -->
                        <?php if (isset($notif_count) && $notif_count > 0): ?>
                            <span class="badge bg-primary badge-number"><?= $notif_count ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            Notifikasi
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat semua</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer"><a href="#">Lihat semua notifikasi</a></li>
                    </ul>
                </li>

                <!-- Profile -->
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width:36px;height:36px;font-size:1rem;font-weight:600;">
                            <?= strtoupper(substr($_user_nama, 0, 1)) ?>
                        </div>
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= html_escape($_user_nama) ?></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= html_escape($_user_nama) ?></h6>
                            <span><?= html_escape($_role_nama) ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('users/profile') ?>">
                                <i class="bi bi-person me-2"></i><span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('auth/logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i><span>Keluar</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

    </header><!-- End Header -->