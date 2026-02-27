<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Inspeksi Kelayakan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('pengajuan') ?>">Pengajuan</a></li>
                <li class="breadcrumb-item active">Form Inspeksi</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-xl-10">

                <!-- HEADER INFO -->
                <div class="card mb-3 border-primary">
                    <div class="card-body py-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                        style="width:50px;height:50px;font-size:1.3rem;">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold"><?= html_escape($pengajuan->no_polisi) ?></h5>
                                        <small class="text-muted">
                                            <?= html_escape($pengajuan->jenis_kendaraan) ?> —
                                            <?= html_escape($pengajuan->merk) ?> <?= html_escape($pengajuan->tipe) ?>
                                            (<?= $pengajuan->tahun ?>)
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2 text-sm">
                                    <div class="col-6">
                                        <small class="text-muted d-block">No. Pengajuan</small>
                                        <strong class="text-primary">#PU-<?= str_pad($pengajuan->id_pengajuan, 4, '0', STR_PAD_LEFT) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Pemohon</small>
                                        <strong><?= html_escape($pengajuan->nama_pemohon) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Template</small>
                                        <strong><?= html_escape($template->kode) ?> — <?= html_escape($template->jenis_unit) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tanggal Inspeksi</small>
                                        <strong><?= date('d M Y') ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROGRESS BAR -->
                <div class="card mb-3">
                    <div class="card-body py-2 px-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-semibold">Progress Pengisian</small>
                            <small class="text-primary fw-bold" id="progressLabel">0 / <?= array_sum(array_map('count', $grouped)) ?> item</small>
                        </div>
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar bg-primary" id="progressBar" style="width:0%;transition:width .3s;"></div>
                        </div>
                    </div>
                </div>

                <!-- Gunakan div bukan form agar tidak ada accidental submit saat klik radio -->
                <div id="formInspeksi">
                    <input type="hidden" id="hid_id_pengajuan" value="<?= $pengajuan->id_pengajuan ?>">
                    <input type="hidden" id="hid_id_template" value="<?= $template->id_template ?>">

                    <!-- ===== CRITICAL ITEMS ===== -->
                    <?php if (!empty($grouped['CRITICAL'])): ?>
                        <div class="card mb-3">
                            <div class="card-body pt-4">
                                <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-danger rounded-pill px-3 py-1">
                                        <i class="bi bi-exclamation-triangle me-1"></i>CRITICAL ITEMS
                                    </span>
                                    <span class="text-muted small fw-normal">
                                        — Semua item ini WAJIB YES untuk lulus inspeksi
                                    </span>
                                </h6>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="table-danger">
                                            <tr>
                                                <th style="width:50px;" class="text-center">No.</th>
                                                <th>Kriteria / Criteria</th>
                                                <th style="width:90px;" class="text-center">YES</th>
                                                <th style="width:90px;" class="text-center">NO</th>
                                                <th style="width:90px;" class="text-center">N/A</th>
                                                <th style="width:220px;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grouped['CRITICAL'] as $item): ?>
                                                <?php $existing_val = isset($existing[$item->id_item]) ? $existing[$item->id_item] : null; ?>
                                                <tr class="checklist-row" data-id="<?= $item->id_item ?>" data-kategori="CRITICAL" id="row_<?= $item->id_item ?>">
                                                    <td class="text-center fw-bold text-danger"><?= html_escape($item->no_urut) ?></td>
                                                    <td><?= html_escape($item->kriteria) ?></td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input check-radio" type="radio"
                                                                name="items[<?= $item->id_item ?>][hasil]"
                                                                value="yes"
                                                                <?= ($existing_val && $existing_val['hasil'] === 'yes') ? 'checked' : '' ?>
                                                                required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input check-radio" type="radio"
                                                                name="items[<?= $item->id_item ?>][hasil]"
                                                                value="no"
                                                                <?= ($existing_val && $existing_val['hasil'] === 'no') ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input check-radio" type="radio"
                                                                name="items[<?= $item->id_item ?>][hasil]"
                                                                value="na"
                                                                <?= ($existing_val && $existing_val['hasil'] === 'na') ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="items[<?= $item->id_item ?>][keterangan]"
                                                            value="<?= html_escape($existing_val ? $existing_val['keterangan'] : '') ?>"
                                                            placeholder="Catatan...">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ===== GENERAL ITEMS ===== -->
                    <?php if (!empty($grouped['GENERAL'])): ?>
                        <div class="card mb-3">
                            <div class="card-body pt-4">
                                <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-1">
                                        <i class="bi bi-list-check me-1"></i>GENERAL REQUIREMENTS
                                    </span>
                                </h6>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="width:50px;" class="text-center">No.</th>
                                                <th>Kriteria / Criteria</th>
                                                <th style="width:90px;" class="text-center">YES</th>
                                                <th style="width:90px;" class="text-center">NO</th>
                                                <th style="width:90px;" class="text-center">N/A</th>
                                                <th style="width:220px;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grouped['GENERAL'] as $item): ?>
                                                <?php $existing_val = isset($existing[$item->id_item]) ? $existing[$item->id_item] : null; ?>
                                                <tr class="checklist-row" data-id="<?= $item->id_item ?>" data-kategori="GENERAL" id="row_<?= $item->id_item ?>">
                                                    <td class="text-center fw-bold text-primary"><?= html_escape($item->no_urut) ?></td>
                                                    <td><?= html_escape($item->kriteria) ?></td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input check-radio" type="radio"
                                                                name="items[<?= $item->id_item ?>][hasil]"
                                                                value="yes"
                                                                <?= ($existing_val && $existing_val['hasil'] === 'yes') ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input check-radio" type="radio"
                                                                name="items[<?= $item->id_item ?>][hasil]"
                                                                value="no"
                                                                <?= ($existing_val && $existing_val['hasil'] === 'no') ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input check-radio" type="radio"
                                                                name="items[<?= $item->id_item ?>][hasil]"
                                                                value="na"
                                                                <?= ($existing_val && $existing_val['hasil'] === 'na') ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="items[<?= $item->id_item ?>][keterangan]"
                                                            value="<?= html_escape($existing_val ? $existing_val['keterangan'] : '') ?>"
                                                            placeholder="Catatan...">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- CATATAN UMUM & HASIL SEMENTARA -->
                    <div class="card mb-3">
                        <div class="card-body pt-4">
                            <h6 class="card-title mb-3">Catatan Umum & Hasil Sementara</h6>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Catatan Umum / Notes</label>
                                    <textarea class="form-control" name="catatan_umum" id="catatan_umum" rows="3"
                                        placeholder="Catatan tambahan dari mekanik inspector..."
                                        maxlength="1000"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Estimasi Hasil</label>
                                    <div id="estimasiHasil" class="rounded border p-3 text-center" style="min-height:90px;">
                                        <div class="text-muted small">Isi semua item untuk melihat estimasi hasil</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="card mb-4">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="text-muted small">
                                    <i class="bi bi-info-circle me-1 text-primary"></i>
                                    Inspector: <strong><?= html_escape($user['nama']) ?></strong> —
                                    Tanggal: <strong><?= date('d M Y') ?></strong>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="<?= site_url('pengajuan') ?>" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>Kembali
                                    </a>
                                    <button type="button" class="btn btn-warning" id="btnSimpanDraft">
                                        <i class="bi bi-floppy me-1"></i>Simpan Draft
                                    </button>
                                    <button type="button" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-send-check me-1"></i>Submit Hasil Inspeksi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- end #formInspeksi -->

            </div>
        </div>
    </section>
</main>


<style>
    .checklist-row.answered-yes {
        background-color: #f0fff5 !important;
    }

    .checklist-row.answered-no {
        background-color: #fff5f5 !important;
    }

    .checklist-row.answered-na {
        background-color: #f8f9fa !important;
    }

    .checklist-row.unanswered {
        background-color: #fffbe6 !important;
    }

    .form-check-input[value="yes"]:checked {
        background-color: #2eca6a;
        border-color: #2eca6a;
    }

    .form-check-input[value="no"]:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .form-check-input[value="na"]:checked {
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>


<script>
    $(function() {

        var totalItems = <?= array_sum(array_map('count', $grouped)) ?>;
        var criticalIds = [<?= implode(',', array_map(function ($i) {
                                return $i->id_item;
                            }, $grouped['CRITICAL'])) ?>];

        // ------------------------------------------------
        // Update row style & progress saat radio diubah
        // ------------------------------------------------
        $(document).on('change', '.check-radio', function() {
            var row = $(this).closest('tr');
            var val = $(this).val();

            row.removeClass('answered-yes answered-no answered-na unanswered');
            row.addClass('answered-' + val);

            updateProgress();
            updateEstimasi();
        });

        // Init style dari existing data
        $('.checklist-row').each(function() {
            var checked = $(this).find('.check-radio:checked');
            if (checked.length) {
                $(this).addClass('answered-' + checked.val());
            }
        });

        updateProgress();
        updateEstimasi();

        // ------------------------------------------------
        // Update progress bar
        // ------------------------------------------------
        function updateProgress() {
            var answered = $('.checklist-row').filter(function() {
                return $(this).find('.check-radio:checked').length > 0;
            }).length;

            var pct = totalItems > 0 ? Math.round(answered / totalItems * 100) : 0;
            $('#progressBar').css('width', pct + '%');
            $('#progressLabel').text(answered + ' / ' + totalItems + ' item');
        }

        // ------------------------------------------------
        // Estimasi hasil
        // ------------------------------------------------
        function updateEstimasi() {
            var criticalNo = 0;
            var answered = 0;

            $('.checklist-row').each(function() {
                var checked = $(this).find('.check-radio:checked');
                if (!checked.length) return;
                answered++;

                var id = parseInt($(this).data('id'));
                var val = checked.val();
                if (val === 'no' && criticalIds.indexOf(id) >= 0) {
                    criticalNo++;
                }
            });

            var box = $('#estimasiHasil');
            box.html('');

            if (answered < totalItems) {
                box.html('<div class="text-muted small"><i class="bi bi-hourglass me-1"></i>' + (totalItems - answered) + ' item belum diisi</div>');
                return;
            }

            if (criticalNo === 0) {
                box.html('<div class="text-success"><i class="bi bi-patch-check-fill fs-2 d-block mb-1"></i><strong>LULUS</strong><br><small>Semua Critical Item terpenuhi</small></div>');
            } else {
                box.html('<div class="text-danger"><i class="bi bi-x-circle-fill fs-2 d-block mb-1"></i><strong>TIDAK LULUS</strong><br><small>' + criticalNo + ' Critical Item tidak terpenuhi</small></div>');
            }
        }

        // ------------------------------------------------
        // Submit
        // ------------------------------------------------
        $('#btnSubmit').on('click', function() {
            // Validasi: semua item harus dijawab
            var unanswered = [];
            $('.checklist-row').each(function() {
                if (!$(this).find('.check-radio:checked').length) {
                    unanswered.push($(this).find('td:first').text().trim());
                    $(this).addClass('unanswered');
                } else {
                    $(this).removeClass('unanswered');
                }
            });

            if (unanswered.length) {
                Swal.fire({
                    title: 'Belum Lengkap',
                    html: 'Item <strong>no. ' + unanswered.join(', ') + '</strong> belum dijawab.',
                    icon: 'warning',
                    confirmButtonColor: '#4154f1',
                });
                // Scroll ke item pertama yang belum dijawab
                var firstRow = $('.checklist-row.unanswered').first();
                if (firstRow.length) {
                    $('html,body').animate({
                        scrollTop: firstRow.offset().top - 120
                    }, 400);
                }
                return;
            }

            // Hitung critical no
            var criticalNo = 0;
            criticalIds.forEach(function(id) {
                var val = $('input[name="items[' + id + '][hasil]"]:checked').val();
                if (val === 'no') criticalNo++;
            });

            var hasilText = criticalNo === 0 ?
                '<span class="text-success fw-bold">LULUS</span>' :
                '<span class="text-danger fw-bold">TIDAK LULUS</span> (' + criticalNo + ' critical item NO)';

            Swal.fire({
                title: 'Submit Hasil Inspeksi?',
                html: 'Estimasi hasil: ' + hasilText + '<br><small class="text-muted">Data tidak dapat diubah setelah disubmit.</small>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4154f1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-send-check me-1"></i>Ya, Submit',
                cancelButtonText: 'Periksa Kembali',
            }).then(function(r) {
                if (r.isConfirmed) doSubmit();
            });
        });

        function doSubmit() {
            NProgress.start();
            $('#btnSubmit').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

            // Kumpulkan data manual (karena pakai div bukan form)
            var postData = {
                id_pengajuan: $('#hid_id_pengajuan').val(),
                id_template: $('#hid_id_template').val(),
                catatan_umum: $('#catatan_umum').val(),
                items: {},
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>',
            };

            // Kumpulkan semua jawaban radio
            $('.check-radio:checked').each(function() {
                // name format: items[123][hasil]
                var match = $(this).attr('name').match(/items\[(\d+)\]\[hasil\]/);
                if (match) {
                    var id_item = match[1];
                    if (!postData.items[id_item]) postData.items[id_item] = {};
                    postData.items[id_item]['hasil'] = $(this).val();
                }
            });

            // Kumpulkan semua keterangan
            $('input[name^="items["]').filter('[name$="[keterangan]"]').each(function() {
                var match = $(this).attr('name').match(/items\[(\d+)\]\[keterangan\]/);
                if (match) {
                    var id_item = match[1];
                    if (!postData.items[id_item]) postData.items[id_item] = {};
                    postData.items[id_item]['keterangan'] = $(this).val();
                }
            });

            $.ajax({
                url: '<?= site_url('checklist/submit') ?>',
                type: 'POST',
                data: postData,
                dataType: 'json',
                traditional: false,
                success: function(res) {
                    NProgress.done();
                    $('#btnSubmit').prop('disabled', false).html('<i class="bi bi-send-check me-1"></i>Submit Hasil Inspeksi');

                    if (res.status === 'success') {
                        var icon = res.hasil === 'lulus' ? 'success' : 'error';
                        Swal.fire({
                            title: res.hasil === 'lulus' ? 'Lulus!' : 'Tidak Lulus',
                            html: res.message,
                            icon: icon,
                            confirmButtonColor: '#4154f1',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(function() {
                            window.location.href = res.redirect;
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            html: res.message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function() {
                    NProgress.done();
                    toastr.error('Terjadi kesalahan server.');
                    $('#btnSubmit').prop('disabled', false).html('<i class="bi bi-send-check me-1"></i>Submit Hasil Inspeksi');
                }
            });
        }

        // ------------------------------------------------
        // Simpan Draft (localStorage)
        // ------------------------------------------------
        $('#btnSimpanDraft').on('click', function() {
            var answers = {};
            $('.check-radio:checked').each(function() {
                var name = $(this).attr('name'); // items[id][hasil]
                answers[name] = $(this).val();
            });
            localStorage.setItem('draft_checklist_<?= $pengajuan->id_pengajuan ?>', JSON.stringify(answers));
            toastr.success('Draft tersimpan di browser.');
        });

        // Load draft jika belum ada data existing
        <?php if (empty($existing)): ?>
            var draft = localStorage.getItem('draft_checklist_<?= $pengajuan->id_pengajuan ?>');
            if (draft) {
                var saved = JSON.parse(draft);
                $.each(saved, function(name, val) {
                    $('input[name="' + name + '"][value="' + val + '"]').prop('checked', true).trigger('change');
                });
                toastr.info('Draft sebelumnya dimuat.');
            }
        <?php endif; ?>

    });
</script>