<main id="main" class="main">

    <div class="pagetitle">
        <h1>Daftar Pengajuan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Daftar Pengajuan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pt-3 mb-3">
                            <h5 class="card-title mb-0">Daftar Pengajuan Uji Kelayakan</h5>
                            <?php if (in_array($user['role'], ['user_dept'])): ?>
                                <a href="<?= site_url('pengajuan/create') ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Buat Pengajuan
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- ===== FILTER SECTION ===== -->
                        <div class="row g-2 mb-3" id="filterSection">
                            <div class="col-sm-6 col-md-3">
                                <select class="form-select form-select-sm" id="filterStatus">
                                    <option value="">— Semua Status —</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="review_manager">Review Manager</option>
                                    <option value="approved_manager">Approved Manager</option>
                                    <option value="review_admin">Review Admin OHS</option>
                                    <option value="approved_admin">Approved Admin</option>
                                    <option value="scheduled">Terjadwal</option>
                                    <option value="inspected">Diinspeksi</option>
                                    <option value="review_ohs">Review OHS</option>
                                    <option value="approved_ohs">Approved OHS</option>
                                    <option value="approved_ktt">Approved KTT</option>
                                    <option value="sticker_released">Sticker Released</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <select class="form-select form-select-sm" id="filterJenis">
                                    <option value="">— Semua Jenis —</option>
                                    <option value="Excavator">Excavator</option>
                                    <option value="Dump Truck">Dump Truck</option>
                                    <option value="Bulldozer">Bulldozer</option>
                                    <option value="Motor Grader">Motor Grader</option>
                                    <option value="Wheel Loader">Wheel Loader</option>
                                    <option value="Forklift">Forklift</option>
                                    <option value="Crane">Crane</option>
                                    <option value="Compactor">Compactor</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <input type="text" class="form-control form-control-sm flatpickr-date" id="filterTglDari" placeholder="Dari Tanggal">
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <input type="text" class="form-control form-control-sm flatpickr-date" id="filterTglSampai" placeholder="Sampai Tanggal">
                            </div>
                            <div class="col-sm-12 col-md-2 d-flex gap-2">
                                <button class="btn btn-primary btn-sm flex-fill" id="btnFilter">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="btnReset" title="Reset Filter">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </div>
                        </div>

                        <!-- ===== TABEL ===== -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" id="tabelPengajuan" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40">No</th>
                                        <th>ID</th>
                                        <th>Pemohon</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Tgl Pengajuan</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->


<!-- =====================================================
     MODAL DETAIL PENGAJUAN
====================================================== -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">
                    <i class="bi bi-file-earmark-text me-2"></i>Detail Pengajuan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="modalDetailBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <div class="mt-2 text-muted small">Memuat data...</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>


<!-- =====================================================
     SCRIPT
====================================================== -->
<script>
    $(function() {

        // ------------------------------------------------
        // Init Flatpickr tanggal
        // ------------------------------------------------
        if (typeof flatpickr !== 'undefined') {
            flatpickr('.flatpickr-date', {
                dateFormat: 'Y-m-d',
                allowInput: true,
            });
        }

        // ------------------------------------------------
        // Init DataTable
        // ------------------------------------------------
        var table = $('#tabelPengajuan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('pengajuan/get_data') ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_status = $('#filterStatus').val();
                    d.filter_jenis = $('#filterJenis').val();
                    d.filter_tgl_dari = $('#filterTglDari').val();
                    d.filter_tgl_sampai = $('#filterTglSampai').val();
                },
                error: function() {
                    toastr.error('Gagal memuat data. Silakan refresh halaman.');
                }
            },
            columns: [{
                    data: 'no',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'id_display',
                    orderable: false
                },
                {
                    data: 'pemohon'
                },
                {
                    data: 'no_polisi',
                    className: 'text-center'
                },
                {
                    data: 'jenis_kendaraan'
                },
                {
                    data: 'unit_baru',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'status',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'tgl_pengajuan',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                },
            ],
            order: [
                [7, 'desc']
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                url: '<?= base_url('assets/vendor/datatables/id.json') ?>',
                processing: '<div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>Memuat...',
            },
            drawCallback: function() {
                // Re-init tooltip setiap kali tabel di-render ulang
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        // ------------------------------------------------
        // Tombol Filter
        // ------------------------------------------------
        $('#btnFilter').on('click', function() {
            table.ajax.reload();
        });

        // ------------------------------------------------
        // Tombol Reset Filter
        // ------------------------------------------------
        $('#btnReset').on('click', function() {
            $('#filterStatus').val('');
            $('#filterJenis').val('');
            $('#filterTglDari').val('');
            $('#filterTglSampai').val('');
            table.ajax.reload();
        });

        // ------------------------------------------------
        // Tekan Enter di kolom filter tanggal
        // ------------------------------------------------
        $('#filterTglDari, #filterTglSampai').on('change', function() {
            table.ajax.reload();
        });

        // ------------------------------------------------
        // Klik tombol Detail
        // ------------------------------------------------
        $(document).on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            loadDetail(id);
        });

        // ------------------------------------------------
        // Klik tombol Approve
        // ------------------------------------------------
        $(document).on('click', '.btn-approve', function() {
            var id = $(this).data('id');
            var level = $(this).data('level');
            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: 'Apakah Anda yakin ingin menyetujui pengajuan #PU-' + String(id).padStart(4, '0') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Ya, Setujui',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) {
                    doApproval(id, level, 'approve', '');
                }
            });
        });

        // ------------------------------------------------
        // Klik tombol Reject
        // ------------------------------------------------
        $(document).on('click', '.btn-reject', function() {
            var id = $(this).data('id');
            var level = $(this).data('level');
            Swal.fire({
                title: 'Konfirmasi Penolakan',
                html: '<p class="text-muted">Masukkan alasan penolakan pengajuan <strong>#PU-' + String(id).padStart(4, '0') + '</strong>:</p>' +
                    '<textarea id="catatanTolak" class="form-control mt-2" rows="3" placeholder="Alasan penolakan..."></textarea>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-x-lg me-1"></i>Tolak Pengajuan',
                cancelButtonText: 'Batal',
                preConfirm: function() {
                    var catatan = document.getElementById('catatanTolak').value.trim();
                    if (!catatan) {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                        return false;
                    }
                    return catatan;
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    doApproval(id, level, 'reject', result.value);
                }
            });
        });

        // ------------------------------------------------
        // Klik tombol Jadwalkan
        // ------------------------------------------------
        $(document).on('click', '.btn-jadwal', function() {
            var id = $(this).data('id');
            // Redirect ke halaman jadwal atau buka modal jadwal
            window.location.href = '<?= site_url('jadwal/create') ?>/' + id;
        });

        // ------------------------------------------------
        // Klik tombol Terbitkan Sticker
        // ------------------------------------------------
        $(document).on('click', '.btn-sticker', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Terbitkan Sticker?',
                html: '<p>Masukkan nomor sticker untuk pengajuan <strong>#PU-' + String(id).padStart(4, '0') + '</strong>:</p>' +
                    '<input type="text" id="nomorSticker" class="form-control mt-2" placeholder="Contoh: STK-2026-0001">',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-patch-check me-1"></i>Terbitkan',
                cancelButtonText: 'Batal',
                preConfirm: function() {
                    var nomor = document.getElementById('nomorSticker').value.trim();
                    if (!nomor) {
                        Swal.showValidationMessage('Nomor sticker wajib diisi!');
                        return false;
                    }
                    return nomor;
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    releaseSticker(id, result.value);
                }
            });
        });


        // ================================================
        // FUNGSI: Load Detail Modal
        // ================================================
        function loadDetail(id) {
            $('#modalDetailBody').html(
                '<div class="text-center py-5">' +
                '<div class="spinner-border text-primary" role="status"></div>' +
                '<div class="mt-2 text-muted small">Memuat data...</div>' +
                '</div>'
            );
            $('#modalDetailLabel').html('<i class="bi bi-file-earmark-text me-2"></i>Detail Pengajuan #PU-' + String(id).padStart(4, '0'));
            $('#modalDetail').modal('show');

            $.ajax({
                url: '<?= site_url('pengajuan/detail') ?>/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        renderDetail(res.data);
                    } else {
                        $('#modalDetailBody').html('<div class="alert alert-danger">' + res.message + '</div>');
                    }
                },
                error: function() {
                    $('#modalDetailBody').html('<div class="alert alert-danger">Gagal memuat data.</div>');
                }
            });
        }


        // ================================================
        // FUNGSI: Render konten Modal Detail
        // ================================================
        function renderDetail(d) {
            var unitBadge = d.is_unit_baru == 1 ?
                '<span class="badge bg-warning text-dark">Unit Baru</span>' :
                '<span class="badge bg-secondary">Unit Lama</span>';

            var statusLabel = {
                draft: 'Draft',
                submitted: 'Submitted',
                review_manager: 'Review Manager',
                approved_manager: 'Approved Manager',
                review_admin: 'Review Admin OHS',
                approved_admin: 'Approved Admin',
                scheduled: 'Terjadwal',
                inspected: 'Diinspeksi',
                review_ohs: 'Review OHS',
                approved_ohs: 'Approved OHS',
                approved_ktt: 'Approved KTT',
                sticker_released: 'Sticker Released',
                rejected: 'Ditolak'
            };
            var statusClass = {
                draft: 'secondary',
                submitted: 'primary',
                review_manager: 'warning',
                approved_manager: 'info',
                review_admin: 'warning',
                approved_admin: 'info',
                scheduled: 'primary',
                inspected: 'info',
                review_ohs: 'warning',
                approved_ohs: 'info',
                approved_ktt: 'success',
                sticker_released: 'success',
                rejected: 'danger'
            };
            var sc = statusClass[d.status] || 'secondary';
            var sl = statusLabel[d.status] || d.status;

            // ---- Lampiran ----
            var lampiranHtml = '';
            if (d.lampiran && d.lampiran.length > 0) {
                var jenisLabel = {
                    stnk: 'STNK',
                    unit_depan: 'Unit Depan',
                    unit_belakang: 'Unit Belakang',
                    unit_kiri: 'Unit Kiri',
                    unit_kanan: 'Unit Kanan'
                };
                $.each(d.lampiran, function(i, l) {
                    lampiranHtml +=
                        '<div class="col-6 col-md-4 col-lg-3">' +
                        '<div class="border rounded p-2 text-center">' +
                        '<a href="<?= base_url() ?>' + l.file_path + '" target="_blank">' +
                        '<img src="<?= base_url() ?>' + l.file_path + '" class="img-fluid rounded mb-1" style="max-height:100px;object-fit:cover;" onerror="this.src=\'<?= base_url('assets/img/placeholder.png') ?>\'">' +
                        '</a>' +
                        '<div class="small fw-bold text-muted">' + (jenisLabel[l.jenis_lampiran] || l.jenis_lampiran) + '</div>' +
                        '</div></div>';
                });
            } else {
                lampiranHtml = '<div class="col-12"><p class="text-muted small mb-0">Tidak ada lampiran.</p></div>';
            }

            // ---- Riwayat Approval ----
            var approvalHtml = '';
            if (d.approval && d.approval.length > 0) {
                var levelLabel = {
                    manager: 'Manager',
                    admin_ohs: 'Admin OHS',
                    ohs_superintendent: 'OHS Superintendent',
                    ktt: 'KTT'
                };
                $.each(d.approval, function(i, a) {
                    var aClass = a.status === 'approved' ? 'success' : (a.status === 'rejected' ? 'danger' : 'secondary');
                    var aIcon = a.status === 'approved' ? 'check-circle-fill' : (a.status === 'rejected' ? 'x-circle-fill' : 'clock');
                    var aLabel = a.status === 'approved' ? 'Disetujui' : (a.status === 'rejected' ? 'Ditolak' : 'Pending');
                    approvalHtml +=
                        '<tr>' +
                        '<td>' + (levelLabel[a.level_approval] || a.level_approval) + '</td>' +
                        '<td>' + (a.nama_approver || '<em class="text-muted">Belum ditentukan</em>') + '</td>' +
                        '<td><span class="badge bg-' + aClass + '"><i class="bi bi-' + aIcon + ' me-1"></i>' + aLabel + '</span></td>' +
                        '<td>' + (a.approved_at ? a.approved_at : '-') + '</td>' +
                        '<td>' + (a.catatan || '-') + '</td>' +
                        '</tr>';
                });
            } else {
                approvalHtml = '<tr><td colspan="5" class="text-center text-muted">Belum ada data approval.</td></tr>';
            }

            // ---- Jadwal ----
            var jadwalHtml = '';
            if (d.jadwal) {
                jadwalHtml =
                    '<div class="row g-2">' +
                    '<div class="col-md-4"><small class="text-muted d-block">Tanggal Uji</small><strong>' + (d.jadwal.tanggal_uji || '-') + '</strong></div>' +
                    '<div class="col-md-4"><small class="text-muted d-block">Lokasi</small><strong>' + (d.jadwal.lokasi || '-') + '</strong></div>' +
                    '<div class="col-md-4"><small class="text-muted d-block">Dijadwalkan oleh</small><strong>' + (d.jadwal.dibuat_oleh_nama || '-') + '</strong></div>' +
                    '</div>';
            } else {
                jadwalHtml = '<p class="text-muted small mb-0">Belum dijadwalkan.</p>';
            }

            // ---- Hasil Uji ----
            var ujiHtml = '';
            if (d.uji) {
                var hasilClass = d.uji.hasil === 'lulus' ? 'success' : 'danger';
                var hasilLabel = d.uji.hasil === 'lulus' ? 'LULUS' : 'TIDAK LULUS';
                ujiHtml =
                    '<div class="row g-2">' +
                    '<div class="col-md-3"><small class="text-muted d-block">Mekanik</small><strong>' + (d.uji.nama_mekanik || '-') + '</strong></div>' +
                    '<div class="col-md-3"><small class="text-muted d-block">Tanggal Uji</small><strong>' + (d.uji.tanggal_uji || '-') + '</strong></div>' +
                    '<div class="col-md-2"><small class="text-muted d-block">Hasil</small>' +
                    '<span class="badge bg-' + hasilClass + ' fs-6">' + hasilLabel + '</span></div>' +
                    '<div class="col-md-4"><small class="text-muted d-block">Catatan</small>' + (d.uji.catatan_umum || '-') + '</div>' +
                    '</div>';
            } else {
                ujiHtml = '<p class="text-muted small mb-0">Belum ada hasil uji.</p>';
            }

            // ---- Render semua ----
            var html =
                // Info Kendaraan + Pemohon
                '<div class="row g-3 mb-3">' +
                '<div class="col-md-6">' +
                '<div class="card border h-100">' +
                '<div class="card-body">' +
                '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-truck me-2"></i>Informasi Kendaraan</h6>' +
                '<table class="table table-sm table-borderless mb-0">' +
                '<tr><td class="text-muted" width="140">No. Polisi</td><td><span class="badge bg-secondary font-monospace fs-6">' + d.no_polisi + '</span></td></tr>' +
                '<tr><td class="text-muted">Jenis</td><td>' + d.jenis_kendaraan + '</td></tr>' +
                '<tr><td class="text-muted">Merk / Tipe</td><td>' + d.merk + ' ' + d.tipe + '</td></tr>' +
                '<tr><td class="text-muted">Tahun</td><td>' + d.tahun + '</td></tr>' +
                '<tr><td class="text-muted">Tipe Unit</td><td>' + unitBadge + '</td></tr>' +
                '</table>' +
                '</div></div></div>' +

                '<div class="col-md-6">' +
                '<div class="card border h-100">' +
                '<div class="card-body">' +
                '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-person me-2"></i>Informasi Pemohon</h6>' +
                '<table class="table table-sm table-borderless mb-0">' +
                '<tr><td class="text-muted" width="140">Nama</td><td>' + d.nama_pemohon + '</td></tr>' +
                '<tr><td class="text-muted">Email</td><td>' + (d.email_pemohon || d.email_pemohon_user) + '</td></tr>' +
                '<tr><td class="text-muted">Tgl Pengajuan</td><td>' + d.tanggal_pengajuan + '</td></tr>' +
                '<tr><td class="text-muted">Status</td><td><span class="badge bg-' + sc + '">' + sl + '</span></td></tr>' +
                '</table>' +
                '</div></div></div>' +
                '</div>' +

                // Lampiran
                '<div class="card border mb-3">' +
                '<div class="card-body">' +
                '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-paperclip me-2"></i>Lampiran Dokumen</h6>' +
                '<div class="row g-2">' + lampiranHtml + '</div>' +
                '</div></div>' +

                // Jadwal Uji
                '<div class="card border mb-3">' +
                '<div class="card-body">' +
                '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-calendar3 me-2"></i>Jadwal Uji Kelayakan</h6>' +
                jadwalHtml +
                '</div></div>' +

                // Hasil Uji
                '<div class="card border mb-3">' +
                '<div class="card-body">' +
                '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-tools me-2"></i>Hasil Uji Kelayakan</h6>' +
                ujiHtml +
                '</div></div>' +

                // Riwayat Approval
                '<div class="card border mb-0">' +
                '<div class="card-body">' +
                '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-check2-circle me-2"></i>Riwayat Approval</h6>' +
                '<div class="table-responsive">' +
                '<table class="table table-sm table-bordered mb-0">' +
                '<thead class="table-light"><tr><th>Level</th><th>Approver</th><th>Status</th><th>Tanggal</th><th>Catatan</th></tr></thead>' +
                '<tbody>' + approvalHtml + '</tbody>' +
                '</table></div>' +
                '</div></div>';

            $('#modalDetailBody').html(html);
        }


        // ================================================
        // FUNGSI: Approval AJAX
        // ================================================
        function doApproval(id, level, aksi, catatan) {
            NProgress.start();
            $.ajax({
                url: '<?= site_url('approval/proses') ?>',
                type: 'POST',
                data: {
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>',
                    id_pengajuan: id,
                    level: level,
                    aksi: aksi,
                    catatan: catatan,
                },
                dataType: 'json',
                success: function(res) {
                    NProgress.done();
                    if (res.status === 'success') {
                        // Admin OHS approve → redirect ke form jadwal
                        if (res.redirect_jadwal) {
                            Swal.fire({
                                title: 'Disetujui!',
                                html: res.message + '<br><small class="text-muted">Silakan buat jadwal uji.</small>',
                                icon: 'success',
                                confirmButtonColor: '#4154f1',
                                confirmButtonText: 'Buat Jadwal',
                            }).then(function() {
                                window.location.href = res.redirect_jadwal;
                            });
                            return;
                        }
                        var icon = aksi === 'approve' ? 'success' : 'warning';
                        Swal.fire({
                            icon: icon,
                            title: aksi === 'approve' ? 'Disetujui!' : 'Ditolak',
                            html: res.message,
                            timer: 1800,
                            showConfirmButton: false,
                        });
                        setTimeout(function() {
                            table.ajax.reload(null, false);
                        }, 1900);
                    } else {
                        toastr.error(res.message || 'Gagal memproses approval.');
                    }
                },
                error: function() {
                    NProgress.done();
                    toastr.error('Terjadi kesalahan server. Silakan coba lagi.');
                }
            });
        }


        // ================================================
        // FUNGSI: Release Sticker AJAX
        // ================================================
        function releaseSticker(id, nomor) {
            NProgress.start();
            $.ajax({
                url: '<?= site_url('sticker/release') ?>',
                type: 'POST',
                data: {
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>',
                    id_pengajuan: id,
                    nomor_sticker: nomor,
                },
                dataType: 'json',
                success: function(res) {
                    NProgress.done();
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message || 'Gagal menerbitkan sticker.');
                    }
                },
                error: function() {
                    NProgress.done();
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }

    });
</script>