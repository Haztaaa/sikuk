<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= isset($existing) && $existing->id_jadwal ? 'Edit' : 'Buat' ?> Jadwal Inspeksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('jadwal') ?>">Jadwal Uji</a></li>
                <li class="breadcrumb-item active"><?= isset($existing) && $existing->id_jadwal ? 'Edit' : 'Buat' ?> Jadwal</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-xl-8">

                <!-- INFO PENGAJUAN -->
                <div class="card mb-3 border-primary">
                    <div class="card-body py-3">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                    style="width:48px;height:48px;font-size:1.3rem;">
                                    <i class="bi bi-truck"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 fw-bold text-primary"><?= html_escape($pengajuan->no_polisi) ?></h6>
                                <small class="text-muted">
                                    <?= html_escape($pengajuan->jenis_kendaraan) ?> —
                                    <?= html_escape($pengajuan->merk) ?> <?= html_escape($pengajuan->tipe) ?>
                                    (<?= $pengajuan->tahun ?>)
                                </small>
                            </div>
                            <div class="col-auto text-end">
                                <small class="text-muted d-block">No. Pengajuan</small>
                                <strong class="text-primary">#PU-<?= str_pad($pengajuan->id_pengajuan, 4, '0', STR_PAD_LEFT) ?></strong>
                            </div>
                            <div class="col-auto text-end">
                                <small class="text-muted d-block">Pemohon</small>
                                <strong><?= html_escape($pengajuan->nama_pemohon) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM JADWAL -->
                <div class="card">
                    <div class="card-body pt-4">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-calendar-plus me-2 text-primary"></i>
                            <?= isset($existing) && $existing->id_jadwal ? 'Edit' : 'Isi' ?> Jadwal Inspeksi
                        </h5>

                        <div id="formJadwal">
                            <input type="hidden" id="hid_id_pengajuan" value="<?= $pengajuan->id_pengajuan ?>">
                            <input type="hidden" id="hid_id_jadwal" value="<?= isset($existing) ? $existing->id_jadwal : '' ?>">

                            <div class="row g-3">

                                <!-- Tanggal & Jam -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Tanggal & Jam Inspeksi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="tanggal_uji"
                                        placeholder="Pilih tanggal & jam..."
                                        value="<?= isset($existing) && $existing->tanggal_uji ? date('Y-m-d H:i', strtotime($existing->tanggal_uji)) : '' ?>"
                                        autocomplete="off" required>
                                    <small class="text-muted">Minimal hari ini</small>
                                </div>

                                <!-- Lokasi -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Lokasi Inspeksi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="lokasi"
                                        placeholder="misal: Workshop OHS, Pit Area..."
                                        value="<?= html_escape(isset($existing) ? $existing->lokasi : '') ?>"
                                        required>
                                </div>

                                <!-- Mekanik Inspector -->
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">
                                        Mekanik Inspector <span class="text-danger">*</span>
                                    </label>
                                    <?php if (empty($mekaniks)): ?>
                                        <div class="alert alert-warning py-2 mb-0">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Belum ada user dengan role Mekanik. Tambahkan dulu di
                                            <a href="<?= base_url('users') ?>">Manajemen User</a>.
                                        </div>
                                    <?php else: ?>
                                        <div class="row g-2">
                                            <?php foreach ($mekaniks as $m): ?>
                                                <?php $checked = isset($existing) && $existing->id_mekanik == $m->id_user ? 'checked' : ''; ?>
                                                <div class="col-md-4">
                                                    <label class="d-flex align-items-center gap-2 border rounded p-2 cursor-pointer mekanik-card <?= $checked ? 'border-primary bg-primary bg-opacity-5' : '' ?>"
                                                        style="cursor:pointer;" for="mekanik_<?= $m->id_user ?>">
                                                        <input type="radio" name="id_mekanik" id="mekanik_<?= $m->id_user ?>"
                                                            value="<?= $m->id_user ?>" class="mekanik-radio" <?= $checked ?>>
                                                        <div>
                                                            <div class="fw-semibold small"><?= html_escape($m->nama) ?></div>
                                                            <div class="text-muted" style="font-size:11px;"><?= html_escape($m->email) ?></div>
                                                        </div>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Keterangan -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Keterangan / Catatan</label>
                                    <textarea class="form-control" id="keterangan" rows="3"
                                        placeholder="Catatan tambahan untuk jadwal ini (opsional)..."
                                        maxlength="500"><?= html_escape(isset($existing) ? $existing->keterangan : '') ?></textarea>
                                </div>

                            </div><!-- end row -->

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="<?= base_url('jadwal') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Kembali
                                </a>
                                <button type="button" class="btn btn-primary" id="btnSimpanJadwal">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    <?= isset($existing) && $existing->id_jadwal ? 'Update Jadwal' : 'Simpan Jadwal' ?>
                                </button>
                            </div>

                        </div><!-- end formJadwal -->
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<!-- 2. Bootstrap Bundle (includes Popper) -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
    $(function() {

        var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        var csrfHash = '<?= $this->security->get_csrf_hash() ?>';

        // Flatpickr datetime
        flatpickr('#tanggal_uji', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            minDate: 'today',
            time_24hr: true,
            minuteIncrement: 15,
            locale: {
                firstDayOfWeek: 1
            },
        });

        // Highlight mekanik card saat dipilih
        $(document).on('change', '.mekanik-radio', function() {
            $('.mekanik-card').removeClass('border-primary bg-primary bg-opacity-5');
            $(this).closest('.mekanik-card').addClass('border-primary bg-primary bg-opacity-5');
        });

        // Submit
        $('#btnSimpanJadwal').on('click', function() {
            var tanggal = $('#tanggal_uji').val().trim();
            var lokasi = $('#lokasi').val().trim();
            var id_mekanik = $('input[name="id_mekanik"]:checked').val();

            if (!tanggal) {
                toastr.warning('Tanggal inspeksi wajib diisi.');
                return;
            }
            if (!lokasi) {
                toastr.warning('Lokasi inspeksi wajib diisi.');
                return;
            }
            if (!id_mekanik) {
                toastr.warning('Pilih mekanik inspector.');
                return;
            }

            Swal.fire({
                title: 'Simpan Jadwal?',
                html: '<strong>' + tanggal + '</strong><br>Lokasi: ' + lokasi,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4154f1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-calendar-check me-1"></i>Ya, Simpan',
                cancelButtonText: 'Batal',
            }).then(function(r) {
                if (!r.isConfirmed) return;

                NProgress.start();
                $('#btnSimpanJadwal').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

                var post = {
                    id_pengajuan: $('#hid_id_pengajuan').val(),
                    id_jadwal: $('#hid_id_jadwal').val(),
                    tanggal_uji: tanggal,
                    lokasi: lokasi,
                    id_mekanik: id_mekanik,
                    keterangan: $('#keterangan').val(),
                };
                post[csrfName] = csrfHash;

                $.ajax({
                    url: '<?= site_url('jadwal/store') ?>',
                    type: 'POST',
                    data: post,
                    dataType: 'json',
                    success: function(res) {
                        NProgress.done();
                        $('#btnSimpanJadwal').prop('disabled', false)
                            .html('<i class="bi bi-calendar-check me-1"></i>Simpan Jadwal');

                        if (res.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonColor: '#4154f1',
                            }).then(function() {
                                window.location.href = res.redirect;
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: res.message,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function() {
                        NProgress.done();
                        $('#btnSimpanJadwal').prop('disabled', false)
                            .html('<i class="bi bi-calendar-check me-1"></i>Simpan Jadwal');
                        toastr.error('Terjadi kesalahan server.');
                    }
                });
            });
        });

    });
</script>