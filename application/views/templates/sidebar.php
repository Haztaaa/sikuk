<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Pengajuan</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('pengajuan/create') ?>">
                <i class="bi bi-file-earmark-plus"></i>
                <span>Buat Pengajuan</span>
            </a>
        </li><!-- End Buat Pengajuan Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('pengajuan') ?>">
                <i class="bi bi-clipboard-check"></i>
                <span>Daftar Pengajuan</span>
            </a>
        </li><!-- End Daftar Pengajuan Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#approval-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-check2-circle"></i><span>Approval</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="approval-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= base_url('approval/manager') ?>">
                        <i class="bi bi-circle"></i><span>Review Manager</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('approval/admin_ohs') ?>">
                        <i class="bi bi-circle"></i><span>Review Admin OHS</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('approval/ohs_supt') ?>">
                        <i class="bi bi-circle"></i><span>OHS Superintendent</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('approval/ktt') ?>">
                        <i class="bi bi-circle"></i><span>Approval KTT</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Approval Nav -->

        <li class="nav-heading">Uji Kelayakan</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('jadwal') ?>">
                <i class="bi bi-calendar3"></i>
                <span>Jadwal Uji</span>
            </a>
        </li><!-- End Jadwal Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('inspeksi') ?>">
                <i class="bi bi-tools"></i>
                <span>Form Inspeksi</span>
            </a>
        </li><!-- End Inspeksi Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('checklist') ?>">
                <i class="bi bi-list-check"></i>
                <span>Checklist Template</span>
            </a>
        </li><!-- End Checklist Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('sticker') ?>">
                <i class="bi bi-patch-check"></i>
                <span>Sticker Release</span>
            </a>
        </li><!-- End Sticker Nav -->

        <li class="nav-heading">Data Master</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kendaraan') ?>">
                <i class="bi bi-truck"></i>
                <span>Data Kendaraan</span>
            </a>
        </li><!-- End Kendaraan Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('users') ?>">
                <i class="bi bi-people"></i>
                <span>Manajemen User</span>
            </a>
        </li><!-- End Users Nav -->

        <li class="nav-heading">Laporan & Sistem</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('laporan') ?>">
                <i class="bi bi-bar-chart-line"></i>
                <span>Laporan</span>
            </a>
        </li><!-- End Laporan Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('audit_log') ?>">
                <i class="bi bi-clock-history"></i>
                <span>Audit Log</span>
            </a>
        </li><!-- End Audit Log Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('pengaturan') ?>">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </li><!-- End Pengaturan Nav -->

    </ul>

</aside><!-- End Sidebar -->