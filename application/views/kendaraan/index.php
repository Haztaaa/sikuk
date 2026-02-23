<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Kendaraan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Data Kendaraan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center pt-3 mb-3">
                            <h5 class="card-title mb-0">Daftar Kendaraan Terdaftar</h5>
                            <button class="btn btn-primary btn-sm" id="btnTambah">
                                <i class="bi bi-plus-circle me-1"></i>Tambah Kendaraan
                            </button>
                        </div>

                        <!-- ===== FILTER ===== -->
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6 col-md-4">
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
                                    <option value="Articulated Truck">Articulated Truck</option>
                                    <option value="Water Truck">Water Truck</option>
                                    <option value="Fuel Truck">Fuel Truck</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <select class="form-select form-select-sm" id="filterUnit">
                                    <option value="">— Semua Tipe Unit —</option>
                                    <option value="1">Unit Baru</option>
                                    <option value="0">Unit Lama</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-2 d-flex gap-2">
                                <button class="btn btn-primary btn-sm flex-fill" id="btnFilter">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="btnReset" title="Reset">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </div>
                        </div>

                        <!-- ===== TABEL ===== -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" id="tabelKendaraan" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="45" class="text-center">No</th>
                                        <th>No. Polisi</th>
                                        <th>Jenis</th>
                                        <th>Merk / Tipe</th>
                                        <th width="60" class="text-center">Tahun</th>
                                        <th width="110" class="text-center">Tipe Unit</th>
                                        <th width="90" class="text-center">Pengajuan</th>
                                        <th width="110" class="text-center">Tgl Daftar</th>
                                        <th width="110" class="text-center">Aksi</th>
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
     MODAL TAMBAH / EDIT KENDARAAN
====================================================== -->
<div class="modal fade" id="modalKendaraan" tabindex="-1" aria-labelledby="modalKendaraanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalKendaraanLabel">
                    <i class="bi bi-truck me-2"></i><span id="modalKendaraanTitle">Tambah Kendaraan</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formKendaraan" novalidate>
                    <input type="hidden" id="id_kendaraan" name="id_kendaraan" value="">

                    <div class="row g-3">

                        <!-- No. Polisi -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">No. Polisi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="no_polisi" name="no_polisi"
                                placeholder="Contoh: KT 1234 AB" maxlength="20" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Jenis Kendaraan -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" id="jenis_kendaraan" name="jenis_kendaraan" required>
                                <option value="">— Pilih Jenis —</option>
                                <option value="Excavator">Excavator</option>
                                <option value="Dump Truck">Dump Truck</option>
                                <option value="Bulldozer">Bulldozer</option>
                                <option value="Motor Grader">Motor Grader</option>
                                <option value="Wheel Loader">Wheel Loader</option>
                                <option value="Forklift">Forklift</option>
                                <option value="Crane">Crane</option>
                                <option value="Compactor">Compactor</option>
                                <option value="Articulated Truck">Articulated Truck</option>
                                <option value="Water Truck">Water Truck</option>
                                <option value="Fuel Truck">Fuel Truck</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Tahun -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" id="tahun" name="tahun"
                                placeholder="Contoh: 2020" min="1990" max="<?= date('Y') ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Merk -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Merk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="merk" name="merk"
                                placeholder="Contoh: Komatsu, Volvo, CAT" maxlength="50" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Tipe -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tipe / Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="tipe" name="tipe"
                                placeholder="Contoh: PC200, A40G, D6T" maxlength="50" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Unit Baru -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_unit_baru" name="is_unit_baru" value="1">
                                <label class="form-check-label fw-semibold" for="is_unit_baru">
                                    Unit Baru
                                    <small class="text-muted fw-normal ms-1">(aktifkan jika kendaraan baru pertama kali didaftarkan)</small>
                                </label>
                            </div>
                        </div>

                        <!-- Info unit baru -->
                        <div class="col-12" id="infoUnitBaru" style="display:none;">
                            <div class="alert alert-warning py-2 mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>Kendaraan unit baru <strong>wajib melampirkan foto STNK dan foto unit dari 4 sisi</strong> pada saat pengajuan uji kelayakan.</small>
                            </div>
                        </div>

                    </div>
                </form>
            </div><!-- End modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSimpan">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>

        </div>
    </div>
</div>


<!-- =====================================================
     MODAL DETAIL KENDARAAN
====================================================== -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">
                    <i class="bi bi-truck me-2"></i>Detail Kendaraan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="modalDetailBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" id="btnEditFromDetail">
                    <i class="bi bi-pencil me-1"></i>Edit
                </button>
            </div>

        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<!-- 2. Bootstrap Bundle (includes Popper) -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- =====================================================
     SCRIPT
====================================================== -->
<script>
    $(function() {

        var currentDetailId = null;

        // ------------------------------------------------
        // Init DataTable
        // ------------------------------------------------
        var table = $('#tabelKendaraan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('kendaraan/get_data') ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_jenis = $('#filterJenis').val();
                    d.filter_unit = $('#filterUnit').val();
                },
                error: function() {
                    toastr.error('Gagal memuat data kendaraan.');
                }
            },
            columns: [{
                    data: 'no',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_polisi'
                },
                {
                    data: 'jenis_kendaraan'
                },
                {
                    data: 'merk_tipe'
                },
                {
                    data: 'tahun',
                    className: 'text-center'
                },
                {
                    data: 'unit',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'total_pengajuan',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'created_at',
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
                processing: '<div class="spinner-border spinner-border-sm text-primary me-2"></div>Memuat...',
            }
        });

        // ------------------------------------------------
        // Filter
        // ------------------------------------------------
        $('#btnFilter').on('click', function() {
            table.ajax.reload();
        });
        $('#btnReset').on('click', function() {
            $('#filterJenis, #filterUnit').val('');
            table.ajax.reload();
        });

        // ------------------------------------------------
        // Toggle info unit baru
        // ------------------------------------------------
        $('#is_unit_baru').on('change', function() {
            $('#infoUnitBaru').toggle(this.checked);
        });

        // ------------------------------------------------
        // Tombol Tambah — buka modal kosong
        // ------------------------------------------------
        $(document).on('click', '#btnTambah', function() {
            console.log('Klik Tambah terdeteksi');

            resetForm();
            $('#modalKendaraanTitle').text('Tambah Kendaraan');

            var el = document.getElementById('modalKendaraan');
            var modal = bootstrap.Modal.getOrCreateInstance(el);
            modal.show();
        });

        // ------------------------------------------------
        // Tombol Detail
        // ------------------------------------------------
        $(document).on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            currentDetailId = id;
            loadDetail(id);
        });

        // ------------------------------------------------
        // Tombol Edit dari tabel
        // ------------------------------------------------
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            loadEdit(id);
        });

        // ------------------------------------------------
        // Tombol Edit dari modal detail
        // ------------------------------------------------
        $('#btnEditFromDetail').on('click', function() {
            $('#modalDetail').modal('hide');
            loadEdit(currentDetailId);
        });

        // ------------------------------------------------
        // Tombol Hapus
        // ------------------------------------------------
        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var nopol = $(this).data('nopol');

            Swal.fire({
                title: 'Hapus Kendaraan?',
                html: 'Anda akan menghapus kendaraan <strong>' + nopol + '</strong>.<br><small class="text-danger">Kendaraan yang memiliki riwayat pengajuan tidak dapat dihapus.</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash me-1"></i>Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) doDelete(id);
            });
        });

        // ------------------------------------------------
        // Tombol Simpan
        // ------------------------------------------------
        $('#btnSimpan').on('click', function() {
            doSave();
        });

        // Enter di input = submit
        $('#formKendaraan input, #formKendaraan select').on('keypress', function(e) {
            if (e.which === 13) doSave();
        });

        // Auto uppercase No. Polisi
        $('#no_polisi').on('input', function() {
            this.value = this.value.toUpperCase();
        });


        // ================================================
        // FUNGSI: Reset Form
        // ================================================
        function resetForm() {
            $('#formKendaraan')[0].reset();
            $('#id_kendaraan').val('');
            $('#infoUnitBaru').hide();
            $('#formKendaraan .is-invalid').removeClass('is-invalid');
            $('#formKendaraan .invalid-feedback').text('');
        }

        // ================================================
        // FUNGSI: Load data untuk Edit
        // ================================================
        function loadEdit(id) {
            NProgress.start();
            $.ajax({
                url: '<?= site_url('kendaraan/get_by_id') ?>',
                type: 'POST',
                data: {
                    <?= $this->security->get_csrf_token_name() ?>: getCsrf(),
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    NProgress.done();
                    if (res.status === 'success') {
                        var d = res.data;
                        resetForm();
                        $('#id_kendaraan').val(d.id_kendaraan);
                        $('#no_polisi').val(d.no_polisi);
                        $('#jenis_kendaraan').val(d.jenis_kendaraan);
                        $('#merk').val(d.merk);
                        $('#tipe').val(d.tipe);
                        $('#tahun').val(d.tahun);
                        $('#is_unit_baru').prop('checked', d.is_unit_baru == 1);
                        $('#infoUnitBaru').toggle(d.is_unit_baru == 1);
                        $('#modalKendaraanTitle').text('Edit Kendaraan — ' + d.no_polisi);
                        $('#modalKendaraan').modal('show');
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function() {
                    NProgress.done();
                    toastr.error('Gagal memuat data.');
                }
            });
        }

        // ================================================
        // FUNGSI: Load Detail Modal
        // ================================================
        function loadDetail(id) {
            $('#modalDetailBody').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
            $('#modalDetail').modal('show');

            $.ajax({
                url: '<?= site_url('kendaraan/get_by_id') ?>',
                type: 'POST',
                data: {
                    <?= $this->security->get_csrf_token_name() ?>: getCsrf(),
                    id: id
                },
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
        // FUNGSI: Render konten Detail
        // ================================================
        function renderDetail(d) {
            var badgeUnit = d.is_unit_baru == 1 ?
                '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Unit Baru</span>' :
                '<span class="badge bg-secondary">Unit Lama</span>';

            var html =
                '<table class="table table-sm table-borderless mb-0">' +
                '<tr><td class="text-muted fw-semibold" width="140">No. Polisi</td>' +
                '<td><span class="badge bg-dark font-monospace fs-6">' + d.no_polisi + '</span></td></tr>' +
                '<tr><td class="text-muted fw-semibold">Jenis</td><td>' + d.jenis_kendaraan + '</td></tr>' +
                '<tr><td class="text-muted fw-semibold">Merk</td><td>' + d.merk + '</td></tr>' +
                '<tr><td class="text-muted fw-semibold">Tipe / Model</td><td>' + d.tipe + '</td></tr>' +
                '<tr><td class="text-muted fw-semibold">Tahun</td><td>' + d.tahun + '</td></tr>' +
                '<tr><td class="text-muted fw-semibold">Tipe Unit</td><td>' + badgeUnit + '</td></tr>' +
                '<tr><td class="text-muted fw-semibold">Tgl Didaftarkan</td><td>' + d.created_at + '</td></tr>' +
                '</table>';

            $('#modalDetailLabel').html('<i class="bi bi-truck me-2"></i>' + d.no_polisi);
            $('#modalDetailBody').html(html);
        }

        // ================================================
        // FUNGSI: Simpan (Insert / Update)
        // ================================================
        function doSave() {
            // Clear validasi sebelumnya
            $('#formKendaraan .is-invalid').removeClass('is-invalid');
            $('#formKendaraan .invalid-feedback').text('');

            // Validasi sisi client sederhana
            var valid = true;

            function showErr(id, msg) {
                $('#' + id).addClass('is-invalid');
                $('#' + id).siblings('.invalid-feedback').text(msg);
                valid = false;
            }

            var nopol = $.trim($('#no_polisi').val());
            var jenis = $('#jenis_kendaraan').val();
            var merk = $.trim($('#merk').val());
            var tipe = $.trim($('#tipe').val());
            var tahun = $.trim($('#tahun').val());

            if (!nopol) showErr('no_polisi', 'No. Polisi wajib diisi.');
            if (!jenis) showErr('jenis_kendaraan', 'Jenis kendaraan wajib dipilih.');
            if (!merk) showErr('merk', 'Merk wajib diisi.');
            if (!tipe) showErr('tipe', 'Tipe/Model wajib diisi.');
            if (!tahun || tahun < 1990 || tahun > <?= date('Y') ?>) {
                showErr('tahun', 'Tahun tidak valid (1990–<?= date('Y') ?>).');
            }

            if (!valid) return;

            var formData = $('#formKendaraan').serialize();
            formData += '&<?= $this->security->get_csrf_token_name() ?>=' + getCsrf();

            NProgress.start();
            $('#btnSimpan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

            $.ajax({
                url: '<?= site_url('kendaraan/save') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    NProgress.done();
                    $('#btnSimpan').prop('disabled', false).html('<i class="bi bi-save me-1"></i>Simpan');

                    if (res.status === 'success') {
                        $('#modalKendaraan').modal('hide');
                        toastr.success(res.message);
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function() {
                    NProgress.done();
                    $('#btnSimpan').prop('disabled', false).html('<i class="bi bi-save me-1"></i>Simpan');
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }

        // ================================================
        // FUNGSI: Hapus
        // ================================================
        function doDelete(id) {
            NProgress.start();
            $.ajax({
                url: '<?= site_url('kendaraan/delete') ?>',
                type: 'POST',
                data: {
                    <?= $this->security->get_csrf_token_name() ?>: getCsrf(),
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    NProgress.done();
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function() {
                    NProgress.done();
                    toastr.error('Terjadi kesalahan.');
                }
            });
        }

        // ================================================
        // FUNGSI: Get CSRF token terbaru dari meta tag
        // atau langsung dari CI (refresh setiap request)
        // ================================================
        function getCsrf() {
            return $('meta[name="csrf-token"]').attr('content') || '<?= $this->security->get_csrf_hash() ?>';
        }

    });
</script>