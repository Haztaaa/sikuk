<main id="main" class="main">

    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <div class="pagetitle">
        <h1>Buat Pengajuan Uji Kelayakan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('pengajuan') ?>">Daftar Pengajuan</a></li>
                <li class="breadcrumb-item active">Buat Pengajuan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-xl-10">

                <form id="formPengajuan" enctype="multipart/form-data" novalidate>
                    <?= $this->security->get_csrf_token_name() ?>

                    <!-- =============================================
               SECTION 1 — Tipe Pengajuan
          ============================================== -->
                    <div class="card mb-3">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:26px;height:26px;font-size:13px;">1</span>
                                Tipe Pengajuan / <em class="fw-normal text-muted">Commissioning Type</em>
                            </h6>

                            <div class="row g-3">
                                <!-- Tipe Commissioning -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipe Commissioning <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3 flex-wrap mt-1">
                                        <div class="form-check form-check-inline border rounded px-3 py-2 flex-fill tipe-card" style="cursor:pointer;">
                                            <input class="form-check-input" type="radio" name="tipe_pengajuan" id="tipeNew" value="new_commissioning" required>
                                            <label class="form-check-label w-100" for="tipeNew" style="cursor:pointer;">
                                                <div class="fw-bold text-primary"><i class="bi bi-plus-circle me-1"></i>Pengajuan Kelayakan</div>
                                                <small class="text-muted">New Commissioning</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline border rounded px-3 py-2 flex-fill tipe-card" style="cursor:pointer;">
                                            <input class="form-check-input" type="radio" name="tipe_pengajuan" id="tipeRecomm" value="recommissioning" required>
                                            <label class="form-check-label w-100" for="tipeRecomm" style="cursor:pointer;">
                                                <div class="fw-bold text-primary"><i class="bi bi-arrow-repeat me-1"></i>Pengajuan Kembali</div>
                                                <small class="text-muted">Recommissioning</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" id="err_tipe_pengajuan"></div>
                                </div>

                                <!-- Tipe Akses -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipe Akses / <em class="fw-normal">Access Type</em> <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3 flex-wrap mt-1">
                                        <div class="form-check form-check-inline border rounded px-3 py-2 flex-fill tipe-card" style="cursor:pointer;">
                                            <input class="form-check-input" type="radio" name="tipe_akses" id="aksesMinig" value="mining" required>
                                            <label class="form-check-label w-100" for="aksesMinig" style="cursor:pointer;">
                                                <div class="fw-bold"><i class="bi bi-minecart-loaded me-1"></i>Mining Access</div>
                                                <small class="text-muted">Area tambang</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline border rounded px-3 py-2 flex-fill tipe-card" style="cursor:pointer;">
                                            <input class="form-check-input" type="radio" name="tipe_akses" id="aksesNonMining" value="non_mining" required>
                                            <label class="form-check-label w-100" for="aksesNonMining" style="cursor:pointer;">
                                                <div class="fw-bold"><i class="bi bi-building me-1"></i>Non Mining Access</div>
                                                <small class="text-muted">Area non-tambang</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" id="err_tipe_akses"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- =============================================
               SECTION 2 — Detail Unit / Kendaraan
          ============================================== -->
                    <div class="card mb-3">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:26px;height:26px;font-size:13px;">2</span>
                                Detail Unit / <em class="fw-normal text-muted">Unit Details</em>
                            </h6>

                            <!-- Pilih Kendaraan -->
                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Pilih Kendaraan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="id_kendaraan" name="id_kendaraan" required>
                                        <option value="">— Pilih No. Polisi / Kendaraan —</option>
                                        <?php foreach ($kendaraan as $k): ?>
                                            <option value="<?= $k->id_kendaraan ?>"
                                                data-nopol="<?= html_escape($k->no_polisi) ?>"
                                                data-jenis="<?= html_escape($k->jenis_kendaraan) ?>"
                                                data-merk="<?= html_escape($k->merk) ?>"
                                                data-tipe="<?= html_escape($k->tipe) ?>"
                                                data-tahun="<?= $k->tahun ?>"
                                                data-unitbaru="<?= $k->is_unit_baru ?>">
                                                <?= html_escape($k->no_polisi) ?> — <?= html_escape($k->merk) ?> <?= html_escape($k->tipe) ?> (<?= html_escape($k->jenis_kendaraan) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback" id="err_id_kendaraan"></div>
                                </div>
                            </div>

                            <!-- Info Kendaraan (auto-fill setelah pilih) -->
                            <div id="infoKendaraan" style="display:none;">
                                <div class="alert alert-light border mb-3 p-3">
                                    <div class="row g-2">
                                        <div class="col-6 col-md-3">
                                            <small class="text-muted d-block">No. Polisi</small>
                                            <strong id="info_nopol">-</strong>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <small class="text-muted d-block">Jenis Unit</small>
                                            <strong id="info_jenis">-</strong>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <small class="text-muted d-block">Merk / Tipe</small>
                                            <strong id="info_merk_tipe">-</strong>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <small class="text-muted d-block">Tahun</small>
                                            <strong id="info_tahun">-</strong>
                                        </div>
                                        <div class="col-6 col-md-1">
                                            <small class="text-muted d-block">Tipe</small>
                                            <span id="info_unit_badge">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail tambahan kendaraan -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nomor Rangka / <em class="fw-normal">Chassis No.</em></label>
                                        <input type="text" class="form-control" name="nomor_rangka" id="nomor_rangka"
                                            placeholder="Masukkan nomor rangka" maxlength="100">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nomor Mesin / <em class="fw-normal">Machine No.</em></label>
                                        <input type="text" class="form-control" name="nomor_mesin" id="nomor_mesin"
                                            placeholder="Masukkan nomor mesin" maxlength="100">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- =============================================
               SECTION 3 — Tujuan Penggunaan
          ============================================== -->
                    <div class="card mb-3">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:26px;height:26px;font-size:13px;">3</span>
                                Tujuan Penggunaan / <em class="fw-normal text-muted">Purpose of Access (Justification)</em>
                            </h6>

                            <textarea class="form-control" name="tujuan" id="tujuan" rows="4"
                                placeholder="Jelaskan tujuan penggunaan kendaraan dan area operasi..."
                                maxlength="1000" required></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <div class="invalid-feedback d-block" id="err_tujuan"></div>
                                <small class="text-muted ms-auto"><span id="charCount">0</span>/1000</small>
                            </div>
                        </div>
                    </div>

                    <!-- =============================================
               SECTION 4 — Informasi Pemohon
          ============================================== -->
                    <div class="card mb-3">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:26px;height:26px;font-size:13px;">4</span>
                                Informasi Pemohon / <em class="fw-normal text-muted">Requester Information</em>
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Diajukan Oleh / <em class="fw-normal">Requested by</em></label>
                                    <input type="text" class="form-control" value="<?= html_escape($user['nama']) ?>" readonly disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Email Pemohon <span class="text-danger">*</span>
                                        <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                                            title="Email notifikasi perkembangan pengajuan akan dikirim ke alamat ini"></i>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" name="email_pemohon" id="email_pemohon"
                                            value="<?= html_escape($user['email'] ?? '') ?>"
                                            placeholder="nama@perusahaan.com" required>
                                    </div>
                                    <div class="form-text text-muted">
                                        <i class="bi bi-info-circle me-1"></i>Notifikasi status pengajuan akan dikirim ke email ini.
                                    </div>
                                    <div class="invalid-feedback d-block" id="err_email_pemohon"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Pengajuan / <em class="fw-normal">Date</em></label>
                                    <input type="text" class="form-control" value="<?= date('d F Y') ?>" readonly disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-primary">Akan disubmit ke Review Manager</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- =============================================
               SECTION 5 — Lampiran (hanya unit baru)
          ============================================== -->
                    <div class="card mb-3" id="sectionLampiran" style="display:none;">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:26px;height:26px;font-size:13px;">5</span>
                                Lampiran Foto / <em class="fw-normal text-muted">Attachments</em>
                                <span class="badge bg-warning text-dark ms-2">Unit Baru Wajib</span>
                            </h6>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Catatan: Kendaraan unit baru wajib melampirkan foto STNK dan foto unit dari 4 sisi.
                                <em>(Note: New unit must enclose copy of STNK and unit photos from 4 sides.)</em>
                            </p>

                            <div class="row g-3">

                                <!-- STNK -->
                                <div class="col-md-4">
                                    <div class="upload-box border rounded p-3 text-center h-100 dropzone" id="box_stnk">
                                        <div class="dz-message needsclick">
                                            <div class="upload-icon mb-2"><i class="bi bi-card-text text-primary" style="font-size:2rem;"></i></div>
                                            <div class="fw-semibold mb-1">Foto STNK <span class="text-danger">*</span></div>
                                            <small class="text-muted d-block mb-2">Surat Tanda Nomor Kendaraan</small>
                                            <div class="btn btn-sm btn-primary">Pilih File</div>
                                        </div>
                                        <div class="invalid-feedback d-block" id="err_stnk"></div>
                                    </div>
                                </div>

                                <!-- Unit Depan -->
                                <div class="col-md-4">
                                    <div class="upload-box border rounded p-3 text-center h-100" id="box_unit_depan">
                                        <div class="upload-icon mb-2"><i class="bi bi-truck text-primary" style="font-size:2rem;"></i></div>
                                        <div class="fw-semibold mb-1">Foto Unit Depan <span class="text-danger">*</span></div>
                                        <small class="text-muted d-block mb-2">Front view</small>
                                        <input type="file" class="form-control form-control-sm" name="lampiran_unit_depan" id="lampiran_unit_depan"
                                            accept=".jpg,.jpeg,.png" onchange="previewFile(this, 'prev_depan', 'box_unit_depan')">
                                        <div id="prev_depan" class="mt-2"></div>
                                        <div class="invalid-feedback d-block" id="err_unit_depan"></div>
                                    </div>
                                </div>

                                <!-- Unit Belakang -->
                                <div class="col-md-4">
                                    <div class="upload-box border rounded p-3 text-center h-100" id="box_unit_belakang">
                                        <div class="upload-icon mb-2"><i class="bi bi-truck text-secondary" style="font-size:2rem;transform:scaleX(-1);"></i></div>
                                        <div class="fw-semibold mb-1">Foto Unit Belakang <span class="text-danger">*</span></div>
                                        <small class="text-muted d-block mb-2">Rear view</small>
                                        <input type="file" class="form-control form-control-sm" name="lampiran_unit_belakang" id="lampiran_unit_belakang"
                                            accept=".jpg,.jpeg,.png" onchange="previewFile(this, 'prev_belakang', 'box_unit_belakang')">
                                        <div id="prev_belakang" class="mt-2"></div>
                                        <div class="invalid-feedback d-block" id="err_unit_belakang"></div>
                                    </div>
                                </div>

                                <!-- Unit Kiri -->
                                <div class="col-md-4 offset-md-2">
                                    <div class="upload-box border rounded p-3 text-center h-100" id="box_unit_kiri">
                                        <div class="upload-icon mb-2"><i class="bi bi-layout-sidebar text-info" style="font-size:2rem;"></i></div>
                                        <div class="fw-semibold mb-1">Foto Unit Kiri <span class="text-danger">*</span></div>
                                        <small class="text-muted d-block mb-2">Left side view</small>
                                        <input type="file" class="form-control form-control-sm" name="lampiran_unit_kiri" id="lampiran_unit_kiri"
                                            accept=".jpg,.jpeg,.png" onchange="previewFile(this, 'prev_kiri', 'box_unit_kiri')">
                                        <div id="prev_kiri" class="mt-2"></div>
                                        <div class="invalid-feedback d-block" id="err_unit_kiri"></div>
                                    </div>
                                </div>

                                <!-- Unit Kanan -->
                                <div class="col-md-4">
                                    <div class="upload-box border rounded p-3 text-center h-100" id="box_unit_kanan">
                                        <div class="upload-icon mb-2"><i class="bi bi-layout-sidebar-reverse text-info" style="font-size:2rem;"></i></div>
                                        <div class="fw-semibold mb-1">Foto Unit Kanan <span class="text-danger">*</span></div>
                                        <small class="text-muted d-block mb-2">Right side view</small>
                                        <input type="file" class="form-control form-control-sm" name="lampiran_unit_kanan" id="lampiran_unit_kanan"
                                            accept=".jpg,.jpeg,.png" onchange="previewFile(this, 'prev_kanan', 'box_unit_kanan')">
                                        <div id="prev_kanan" class="mt-2"></div>
                                        <div class="invalid-feedback d-block" id="err_unit_kanan"></div>
                                    </div>
                                </div>

                            </div><!-- end row lampiran -->
                        </div>
                    </div>

                    <!-- =============================================
               TOMBOL SUBMIT
          ============================================== -->
                    <div class="card mb-4">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="text-muted small">
                                    <i class="bi bi-info-circle me-1 text-primary"></i>
                                    Setelah disubmit, pengajuan akan diteruskan ke <strong>User Dept. Manager</strong> untuk review.
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="<?= site_url('pengajuan') ?>" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>Kembali
                                    </a>
                                    <button type="button" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-send me-1"></i>Submit Pengajuan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form><!-- end #formPengajuan -->

            </div>
        </div>
    </section>

</main>


<!-- =====================================================
     STYLE
====================================================== -->
<style>
    .tipe-card {
        transition: border-color .2s, background .2s;
    }

    .tipe-card:has(input:checked) {
        border-color: #4154f1 !important;
        background: #f0f2ff;
    }

    .tipe-card:hover {
        border-color: #4154f1;
    }

    .upload-box {
        transition: border-color .2s, background .2s;
        min-height: 170px;
    }

    .upload-box.has-file {
        border-color: #2eca6a !important;
        background: #f0fff5;
    }

    .upload-box.has-error {
        border-color: #dc3545 !important;
        background: #fff5f5;
    }

    .upload-box img.preview-img {
        max-height: 80px;
        max-width: 100%;
        object-fit: contain;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    /* Dropzone Customization */
    #box_stnk.dropzone {
        border: 2px dashed #dee2e6;
        background: #fdfdfd;
        min-height: 170px;
        padding: 10px !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    #box_stnk.dropzone.dz-drag-hover {
        border-color: #4154f1;
        background: #f0f2ff;
    }

    #box_stnk.dropzone .dz-preview {
        margin: 0;
        min-height: 100px;
        z-index: 10;
    }

    #box_stnk.dropzone .dz-preview .dz-image {
        border-radius: 8px;
        width: 80px;
        height: 80px;
    }

    #box_stnk.dropzone.has-file {
        border-style: solid;
        border-color: #2eca6a !important;
        background: #f0fff5;
    }

    #box_stnk.dropzone.has-error {
        border-style: solid;
        border-color: #dc3545 !important;
        background: #fff5f5;
    }
</style>


<!-- Dropzone JS -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<!-- =====================================================
     SCRIPT
====================================================== -->
<script>
    Dropzone.autoDiscover = false;

    $(function() {

        // ------------------------------------------------
        // Dropzone STNK Config
        // ------------------------------------------------
        var stnkDropzone = new Dropzone("#box_stnk", {
            url: "/",
            autoProcessQueue: false,
            maxFiles: 1,
            acceptedFiles: "image/*,application/pdf",
            addRemoveLinks: true,
            dictRemoveFile: "Hapus File",
            init: function() {
                this.on("addedfile", function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    $('#box_stnk').addClass('has-file').removeClass('has-error');
                    $('#err_stnk').text('');
                });
                this.on("removedfile", function(file) {
                    if (this.files.length === 0) {
                        $('#box_stnk').removeClass('has-file');
                    }
                });
            }
        });

        // ------------------------------------------------
        // Init Select2
        // ------------------------------------------------
        $('#id_kendaraan').select2({
            placeholder: "— Pilih No. Polisi / Kendaraan —",
            allowClear: true,
            width: '100%'
        });

        // ------------------------------------------------
        // Init tooltip
        // ------------------------------------------------
        $('[data-bs-toggle="tooltip"]').tooltip();

        // ------------------------------------------------
        // Pilih kendaraan → auto-fill info
        // ------------------------------------------------
        $('#id_kendaraan').on('change', function() {
            var opt = $(this).find('option:selected');
            var id = $(this).val();

            if (!id) {
                $('#infoKendaraan').slideUp(200);
                $('#sectionLampiran').slideUp(200);
                return;
            }

            var nopol = opt.data('nopol');
            var jenis = opt.data('jenis');
            var merk = opt.data('merk');
            var tipe = opt.data('tipe');
            var tahun = opt.data('tahun');
            var unitBaru = parseInt(opt.data('unitbaru'));

            $('#info_nopol').text(nopol);
            $('#info_jenis').text(jenis);
            $('#info_merk_tipe').text(merk + ' ' + tipe);
            $('#info_tahun').text(tahun);
            $('#info_unit_badge').html(
                unitBaru ?
                '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Unit Baru</span>' :
                '<span class="badge bg-secondary">Unit Lama</span>'
            );

            $('#infoKendaraan').slideDown(200);

            // Tampilkan/sembunyikan section lampiran
            if (unitBaru) {
                $('#sectionLampiran').slideDown(300);
            } else {
                $('#sectionLampiran').slideUp(200);
                // Reset file input lampiran
                $('input[name^="lampiran_"]').val('');
                stnkDropzone.removeAllFiles(true);
                $('.upload-box').removeClass('has-file has-error');
                $('[id^="prev_"]').html('');
            }

            // Clear error
            $('#err_id_kendaraan').text('');
            $('#id_kendaraan').removeClass('is-invalid');
        });

        // ------------------------------------------------
        // Counter karakter textarea tujuan
        // ------------------------------------------------
        $('#tujuan').on('input', function() {
            $('#charCount').text($(this).val().length);
        });

        // ------------------------------------------------
        // Submit
        // ------------------------------------------------
        $('#btnSubmit').on('click', function() {
            if (!validateForm()) return;

            Swal.fire({
                title: 'Submit Pengajuan?',
                html: 'Pengajuan akan dikirim ke <strong>User Dept. Manager</strong> untuk direview.<br><small class="text-muted">Pastikan semua data sudah benar.</small>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4154f1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-send me-1"></i>Ya, Submit',
                cancelButtonText: 'Periksa Kembali',
            }).then(function(result) {
                if (result.isConfirmed) doSubmit();
            });
        });


        // ================================================
        // FUNGSI: Validasi form sisi client
        // ================================================
        function validateForm() {
            var valid = true;

            // Reset semua error
            $('.invalid-feedback').text('');
            $('.is-invalid').removeClass('is-invalid');

            function err(id, msg) {
                $('#err_' + id).text(msg);
                $('#' + id).addClass('is-invalid');
                valid = false;
            }

            // Tipe pengajuan
            if (!$('input[name="tipe_pengajuan"]:checked').val()) {
                $('#err_tipe_pengajuan').text('Pilih tipe pengajuan.');
                valid = false;
            }

            // Tipe akses
            if (!$('input[name="tipe_akses"]:checked').val()) {
                $('#err_tipe_akses').text('Pilih tipe akses.');
                valid = false;
            }

            // Kendaraan
            if (!$('#id_kendaraan').val()) {
                err('id_kendaraan', 'Pilih kendaraan terlebih dahulu.');
            }

            // Tujuan
            if (!$.trim($('#tujuan').val())) {
                err('tujuan', 'Tujuan penggunaan wajib diisi.');
            }

            // Email
            var email = $.trim($('#email_pemohon').val());
            if (!email) {
                err('email_pemohon', 'Email pemohon wajib diisi.');
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                err('email_pemohon', 'Format email tidak valid.');
            }

            // Lampiran jika unit baru
            var isUnitBaru = parseInt($('#id_kendaraan').find('option:selected').data('unitbaru'));
            if (isUnitBaru && $('#sectionLampiran').is(':visible')) {
                var lampiranList = {
                    'stnk': 'Foto STNK',
                    'unit_depan': 'Foto Unit Depan',
                    'unit_belakang': 'Foto Unit Belakang',
                    'unit_kiri': 'Foto Unit Kiri',
                    'unit_kanan': 'Foto Unit Kanan',
                };
                $.each(lampiranList, function(key, label) {
                    var hasFile = false;
                    if (key === 'stnk') {
                        hasFile = stnkDropzone.files.length > 0;
                    } else {
                        hasFile = $('#lampiran_' + key)[0].files.length > 0;
                    }

                    if (!hasFile) {
                        $('#err_' + key).text(label + ' wajib diupload untuk unit baru.');
                        $('#box_' + key).addClass('has-error');
                        valid = false;
                    }
                });
            }

            if (!valid) {
                // Scroll ke error pertama
                var firstErr = $('.invalid-feedback:not(:empty)').first();
                if (firstErr.length) {
                    $('html, body').animate({
                        scrollTop: firstErr.offset().top - 120
                    }, 400);
                }
            }

            return valid;
        }


        // ================================================
        // FUNGSI: Kirim form via AJAX
        // ================================================
        function doSubmit() {
            NProgress.start();
            $('#btnSubmit').prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

            var formData = new FormData($('#formPengajuan')[0]);

            // Append Dropzone file for STNK
            if (stnkDropzone.files.length > 0) {
                formData.append('lampiran_stnk', stnkDropzone.files[0]);
            }

            formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

            $.ajax({
                url: '<?= site_url('pengajuan/store') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(res) {
                    NProgress.done();
                    $('#btnSubmit').prop('disabled', false).html('<i class="bi bi-send me-1"></i>Submit Pengajuan');

                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            html: res.message,
                            icon: 'success',
                            confirmButtonColor: '#4154f1',
                            confirmButtonText: 'Lihat Daftar Pengajuan',
                            allowOutsideClick: false,
                        }).then(function() {
                            window.location.href = res.redirect;
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal Menyimpan',
                            html: '<ul class="text-start">' + res.message + '</ul>',
                            icon: 'error',
                            confirmButtonColor: '#dc3545',
                        });
                    }
                },
                error: function() {
                    NProgress.done();
                    $('#btnSubmit').prop('disabled', false).html('<i class="bi bi-send me-1"></i>Submit Pengajuan');
                    toastr.error('Terjadi kesalahan server. Silakan coba lagi.');
                }
            });
        }

    });


    // ================================================
    // FUNGSI: Preview file upload (global, dipanggil dari onchange)
    // ================================================
    function previewFile(input, previewId, boxId) {
        var preview = document.getElementById(previewId);
        var box = document.getElementById(boxId);
        preview.innerHTML = '';
        box.classList.remove('has-file', 'has-error');

        var jenis = input.name.replace('lampiran_', '');
        document.getElementById('err_' + jenis).textContent = '';

        if (!input.files || !input.files[0]) return;

        var file = input.files[0];

        // Validasi ukuran (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            box.classList.add('has-error');
            document.getElementById('err_' + jenis).textContent = 'Ukuran file max 5MB.';
            input.value = '';
            return;
        }

        box.classList.add('has-file');

        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" class="preview-img">' +
                    '<div class="small text-success mt-1"><i class="bi bi-check-circle me-1"></i>' + file.name + '</div>';
            };
            reader.readAsDataURL(file);
        } else {
            // PDF
            preview.innerHTML = '<div class="text-success small mt-1">' +
                '<i class="bi bi-file-earmark-pdf me-1 text-danger"></i>' + file.name + '</div>';
        }
    }
</script>