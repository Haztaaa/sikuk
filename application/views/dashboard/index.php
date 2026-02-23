<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Card: Total Pengajuan -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Total Pengajuan <span>| Bulan Ini</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>142</h6>
                                        <span class="text-success small pt-1 fw-bold">+12</span>
                                        <span class="text-muted small pt-2 ps-1">dari bulan lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Total Pengajuan Card -->

                    <!-- Card: Lulus Uji -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Lulus Uji <span>| Bulan Ini</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-patch-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>98</h6>
                                        <span class="text-success small pt-1 fw-bold">69%</span>
                                        <span class="text-muted small pt-2 ps-1">pass rate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Lulus Uji Card -->

                    <!-- Card: Menunggu Review -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Menunggu Review <span>| Sekarang</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hourglass-split"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>17</h6>
                                        <span class="text-danger small pt-1 fw-bold">5</span>
                                        <span class="text-muted small pt-2 ps-1">perlu tindakan segera</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Menunggu Review Card -->

                    <!-- Pipeline Status Chart -->
                    <div class="col-12">
                        <div class="card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Tren Pengajuan <span>/ Bulanan</span></h5>

                                <div id="trendChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#trendChart"), {
                                            series: [{
                                                name: 'Pengajuan Masuk',
                                                data: [18, 22, 15, 28, 24, 30, 26, 35, 28, 32, 24, 19],
                                            }, {
                                                name: 'Lulus Uji',
                                                data: [12, 16, 10, 20, 18, 22, 19, 27, 21, 25, 17, 14]
                                            }, {
                                                name: 'Ditolak',
                                                data: [2, 3, 2, 4, 3, 4, 3, 4, 3, 4, 3, 2]
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'area',
                                                toolbar: {
                                                    show: false
                                                },
                                            },
                                            markers: {
                                                size: 4
                                            },
                                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.3,
                                                    opacityTo: 0.4,
                                                    stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth',
                                                width: 2
                                            },
                                            xaxis: {
                                                categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
                                            },
                                            tooltip: {
                                                x: {
                                                    format: 'MMM'
                                                }
                                            }
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div><!-- End Tren Chart -->

                    <!-- Pipeline Status Bar -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Status Pipeline <span>| Pengajuan Aktif</span></h5>
                                <div class="row g-3 text-center">
                                    <div class="col">
                                        <div class="border rounded p-2">
                                            <div class="fs-4 fw-bold text-primary">8</div>
                                            <div class="small text-muted">Review<br>Manager</div>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-center text-muted px-0">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                    <div class="col">
                                        <div class="border rounded p-2">
                                            <div class="fs-4 fw-bold text-primary">5</div>
                                            <div class="small text-muted">Review<br>Admin OHS</div>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-center text-muted px-0">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                    <div class="col">
                                        <div class="border rounded p-2">
                                            <div class="fs-4 fw-bold" style="color:#2eca6a;">6</div>
                                            <div class="small text-muted">Terjadwal /<br>Uji</div>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-center text-muted px-0">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                    <div class="col">
                                        <div class="border rounded p-2">
                                            <div class="fs-4 fw-bold text-warning">4</div>
                                            <div class="small text-muted">Review<br>OHS/KTT</div>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-center text-muted px-0">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                    <div class="col">
                                        <div class="border rounded p-2">
                                            <div class="fs-4 fw-bold" style="color:#2eca6a;">2</div>
                                            <div class="small text-muted">Sticker<br>Release</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Pipeline -->

                    <!-- Pengajuan Terbaru -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Pengajuan Terbaru <span>| Hari Ini</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Pemohon</th>
                                            <th scope="col">No. Polisi</th>
                                            <th scope="col">Jenis</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#" class="fw-bold text-primary">#PU-0142</a></td>
                                            <td>Rudi Santoso</td>
                                            <td><span class="badge bg-secondary">KT 1234 AB</span></td>
                                            <td>Excavator</td>
                                            <td><span class="badge bg-warning text-dark">Review OHS</span></td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary py-0">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="fw-bold text-primary">#PU-0141</a></td>
                                            <td>Budi Hartono</td>
                                            <td><span class="badge bg-secondary">KT 5678 CD</span></td>
                                            <td>Dump Truck</td>
                                            <td><span class="badge bg-primary">Terjadwal</span></td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary py-0">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="fw-bold text-primary">#PU-0140</a></td>
                                            <td>Siti Aminah</td>
                                            <td><span class="badge bg-secondary">KT 9012 EF</span></td>
                                            <td>Motor Grader</td>
                                            <td><span class="badge bg-info text-dark">Diinspeksi</span></td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary py-0">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="fw-bold text-primary">#PU-0139</a></td>
                                            <td>Hendra Wijaya</td>
                                            <td><span class="badge bg-secondary">KT 3456 GH</span></td>
                                            <td>Bulldozer</td>
                                            <td><span class="badge bg-success">Approved KTT</span></td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary py-0">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="fw-bold text-primary">#PU-0138</a></td>
                                            <td>Dewi Kurnia</td>
                                            <td><span class="badge bg-secondary">KT 7890 IJ</span></td>
                                            <td>Wheel Loader</td>
                                            <td><span class="badge bg-success">Sticker Released</span></td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary py-0">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="fw-bold text-primary">#PU-0137</a></td>
                                            <td>Andi Prasetyo</td>
                                            <td><span class="badge bg-secondary">KT 2468 KL</span></td>
                                            <td>Forklift</td>
                                            <td><span class="badge bg-danger">Ditolak</span></td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary py-0">Detail</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Pengajuan Terbaru -->

                    <!-- Jadwal Uji Mendatang -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                </ul>
                            </div>
                            <div class="card-body pb-0">
                                <h5 class="card-title">Jadwal Uji Mendatang <span>| Minggu Ini</span></h5>
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Kendaraan</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Mekanik</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="fw-bold text-primary">24 Feb 2026</span><br><small class="text-muted">09:00 WIB</small></td>
                                            <td><span class="fw-bold">KT 5678 CD</span><br><small class="text-muted">Dump Truck Volvo</small></td>
                                            <td>Workshop A</td>
                                            <td>Mekno Subianto</td>
                                            <td><span class="badge bg-primary">Terjadwal</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold text-primary">25 Feb 2026</span><br><small class="text-muted">13:00 WIB</small></td>
                                            <td><span class="fw-bold">KT 9012 EF</span><br><small class="text-muted">Motor Grader CAT</small></td>
                                            <td>Workshop B</td>
                                            <td>Mekno Subianto</td>
                                            <td><span class="badge bg-primary">Terjadwal</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold text-primary">27 Feb 2026</span><br><small class="text-muted">10:30 WIB</small></td>
                                            <td><span class="fw-bold">KT 3456 GH</span><br><small class="text-muted">Bulldozer Komatsu</small></td>
                                            <td>Workshop A</td>
                                            <td>Haris Munandar</td>
                                            <td><span class="badge bg-primary">Terjadwal</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Jadwal Uji -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Approval Queue -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Semua Level</a></li>
                            <li><a class="dropdown-item" href="#">Manager</a></li>
                            <li><a class="dropdown-item" href="#">OHS</a></li>
                            <li><a class="dropdown-item" href="#">KTT</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Approval Queue <span>| Menunggu Tindakan</span></h5>

                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-primary small">#PU-0143</span>
                                <span class="badge bg-warning text-dark" style="font-size:10px;">Review Admin OHS</span>
                            </div>
                            <div class="fw-bold text-dark mb-1" style="font-size:14px;">Excavator Komatsu PC200</div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-tag me-1"></i>KT 1111 MN
                                &nbsp;·&nbsp;
                                <i class="bi bi-person me-1"></i>Fajar Nugroho
                                &nbsp;·&nbsp;
                                <i class="bi bi-clock me-1"></i>2 jam lalu
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-success flex-fill py-1">
                                    <i class="bi bi-check-lg me-1"></i>Setujui
                                </button>
                                <button class="btn btn-sm btn-danger flex-fill py-1">
                                    <i class="bi bi-x-lg me-1"></i>Tolak
                                </button>
                            </div>
                        </div>

                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-primary small">#PU-0140</span>
                                <span class="badge bg-info text-dark" style="font-size:10px;">OHS Superintendent</span>
                            </div>
                            <div class="fw-bold text-dark mb-1" style="font-size:14px;">Dump Truck Volvo A40G</div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-tag me-1"></i>KT 2222 OP
                                &nbsp;·&nbsp;
                                <i class="bi bi-person me-1"></i>Surya Darmawan
                                &nbsp;·&nbsp;
                                <i class="bi bi-clock me-1"></i>1 hari lalu
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-success flex-fill py-1">
                                    <i class="bi bi-check-lg me-1"></i>Setujui
                                </button>
                                <button class="btn btn-sm btn-danger flex-fill py-1">
                                    <i class="bi bi-x-lg me-1"></i>Tolak
                                </button>
                            </div>
                        </div>

                        <div class="border rounded p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-primary small">#PU-0136</span>
                                <span class="badge bg-dark" style="font-size:10px;">KTT</span>
                            </div>
                            <div class="fw-bold text-dark mb-1" style="font-size:14px;">Wheel Loader CAT 950</div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-tag me-1"></i>KT 3333 QR
                                &nbsp;·&nbsp;
                                <i class="bi bi-person me-1"></i>Rendy Kusuma
                                &nbsp;·&nbsp;
                                <i class="bi bi-clock me-1"></i>2 hari lalu
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-success flex-fill py-1">
                                    <i class="bi bi-check-lg me-1"></i>Setujui
                                </button>
                                <button class="btn btn-sm btn-danger flex-fill py-1">
                                    <i class="bi bi-x-lg me-1"></i>Tolak
                                </button>
                            </div>
                        </div>

                    </div>
                </div><!-- End Approval Queue -->

                <!-- Sticker Release -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Sticker Siap Diterbitkan <span>| 2 Item</span></h5>

                        <div class="border border-success rounded p-3 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-patch-check-fill text-success fs-5"></i>
                                <span class="fw-bold text-dark" style="font-size:14px;">KT 7890 IJ — Wheel Loader</span>
                            </div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-person me-1"></i>Dewi Kurnia
                                &nbsp;·&nbsp;
                                <i class="bi bi-check-circle me-1 text-success"></i>Lulus Uji
                            </div>
                            <button class="btn btn-sm btn-success w-100 py-1">
                                <i class="bi bi-patch-check me-1"></i>Terbitkan Sticker
                            </button>
                        </div>

                        <div class="border border-success rounded p-3 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-patch-check-fill text-success fs-5"></i>
                                <span class="fw-bold text-dark" style="font-size:14px;">KT 3456 GH — Bulldozer</span>
                            </div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-person me-1"></i>Hendra Wijaya
                                &nbsp;·&nbsp;
                                <i class="bi bi-check-circle me-1 text-success"></i>Lulus Uji
                            </div>
                            <button class="btn btn-sm btn-success w-100 py-1">
                                <i class="bi bi-patch-check me-1"></i>Terbitkan Sticker
                            </button>
                        </div>

                    </div>
                </div><!-- End Sticker Release -->

                <!-- Recent Activity -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                            <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                            <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Aktivitas Terbaru <span>| Hari Ini</span></h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                                <div class="activite-label">5 mnt</div>
                                <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                                <div class="activity-content">
                                    <strong>Ahmad Hidayat</strong> menerbitkan sticker lulus uji untuk
                                    <a href="#" class="fw-bold text-dark">#PU-0138</a>
                                </div>
                            </div>

                            <div class="activity-item d-flex">
                                <div class="activite-label">32 mnt</div>
                                <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>
                                <div class="activity-content">
                                    <strong>Mekno Subianto</strong> mengunggah hasil inspeksi
                                    <a href="#" class="fw-bold text-dark">KT 9012 EF</a>
                                </div>
                            </div>

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 jam</div>
                                <i class="bi bi-circle-fill activity-badge text-warning align-self-start"></i>
                                <div class="activity-content">
                                    <strong>Fajar Nugroho</strong> mengajukan uji kelayakan baru —
                                    <a href="#" class="fw-bold text-dark">KT 1111 MN</a> (Unit Baru)
                                </div>
                            </div>

                            <div class="activity-item d-flex">
                                <div class="activite-label">3 jam</div>
                                <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>
                                <div class="activity-content">
                                    <strong>Manager Dept.</strong> menyetujui
                                    <a href="#" class="fw-bold text-dark">#PU-0141</a> — diteruskan ke OHS
                                </div>
                            </div>

                            <div class="activity-item d-flex">
                                <div class="activite-label">1 hari</div>
                                <i class="bi bi-circle-fill activity-badge text-danger align-self-start"></i>
                                <div class="activity-content">
                                    <strong>OHS Supt.</strong> menolak
                                    <a href="#" class="fw-bold text-dark">#PU-0137</a> — dokumen tidak lengkap
                                </div>
                            </div>

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 hari</div>
                                <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                                <div class="activity-content">
                                    <strong>KTT</strong> memberikan approval final untuk
                                    <a href="#" class="fw-bold text-dark">#PU-0139</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- End Recent Activity -->

                <!-- Rekap Status Chart -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                            <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                        </ul>
                    </div>
                    <div class="card-body pb-0">
                        <h5 class="card-title">Rekap Status <span>| Bulan Ini</span></h5>

                        <div id="rekapChart" style="min-height: 300px;" class="echart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("#rekapChart")).setOption({
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        top: '5%',
                                        left: 'center'
                                    },
                                    series: [{
                                        name: 'Status Pengajuan',
                                        type: 'pie',
                                        radius: ['40%', '70%'],
                                        avoidLabelOverlap: false,
                                        label: {
                                            show: false,
                                            position: 'center'
                                        },
                                        emphasis: {
                                            label: {
                                                show: true,
                                                fontSize: '16',
                                                fontWeight: 'bold'
                                            }
                                        },
                                        labelLine: {
                                            show: false
                                        },
                                        data: [{
                                                value: 98,
                                                name: 'Lulus Uji',
                                                itemStyle: {
                                                    color: '#2eca6a'
                                                }
                                            },
                                            {
                                                value: 17,
                                                name: 'Dalam Proses',
                                                itemStyle: {
                                                    color: '#4154f1'
                                                }
                                            },
                                            {
                                                value: 16,
                                                name: 'Terjadwal',
                                                itemStyle: {
                                                    color: '#0dcaf0'
                                                }
                                            },
                                            {
                                                value: 11,
                                                name: 'Ditolak',
                                                itemStyle: {
                                                    color: '#ff771d'
                                                }
                                            },
                                        ]
                                    }]
                                });
                            });
                        </script>
                    </div>
                </div><!-- End Rekap Status Chart -->

            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->