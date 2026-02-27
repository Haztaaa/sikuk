<main id="main" class="main">

    <div class="pagetitle">
        <h1>Detail Pengajuan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('approval/' . $level) ?>"><?= html_escape($cfg['label']) ?></a></li>
                <li class="breadcrumb-item active">#PU-<?= str_pad($pengajuan->id_pengajuan, 4, '0', STR_PAD_LEFT) ?></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-xl-9">

                <?php
                $status_masuk = is_array($cfg['status_masuk']) ? $cfg['status_masuk'] : [$cfg['status_masuk']];
                $is_pending   = in_array($pengajuan->status, $status_masuk);
                $status_labels = [
                    'submitted'        => ['bg-secondary',         'Submitted'],
                    'review_manager'   => ['bg-warning text-dark', 'Review Manager'],
                    'approved_manager' => ['bg-info text-dark',    'Approved Manager'],
                    'review_admin'     => ['bg-warning text-dark', 'Review Admin'],
                    'approved_admin'   => ['bg-info text-dark',    'Approved Admin'],
                    'scheduled'        => ['bg-primary',           'Terjadwal'],
                    'review_ohs'       => ['bg-warning text-dark', 'Review OHS'],
                    'approved_ohs'     => ['bg-info text-dark',    'Approved OHS'],
                    'approved_ktt'     => ['bg-success',           'Approved KTT'],
                    'sticker_released' => ['bg-success',           'Sticker Released'],
                    'rejected'         => ['bg-danger',            'Ditolak'],
                ];
                $sl = isset($status_labels[$pengajuan->status]) ? $status_labels[$pengajuan->status] : ['bg-secondary', '—'];
                ?>

                <!-- HEADER CARD -->
                <div class="card mb-3 border-<?= $is_pending ? 'primary' : 'secondary' ?>">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                    style="width:50px;height:50px;font-size:1.4rem;">
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
                            <div class="text-end">
                                <div><span class="badge <?= $sl[0] ?> px-3 py-2"><?= $sl[1] ?></span></div>
                                <small class="text-muted">#PU-<?= str_pad($pengajuan->id_pengajuan, 4, '0', STR_PAD_LEFT) ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">

                    <!-- INFO PENGAJUAN -->
                    <div class="col-md-7">
                        <div class="card h-100">
                            <div class="card-body pt-4">
                                <h6 class="card-title mb-3">Informasi Pengajuan</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Pemohon</small>
                                        <strong><?= html_escape($pengajuan->nama_pemohon) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Email</small>
                                        <strong><?= html_escape($pengajuan->email_pemohon) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tipe Pengajuan</small>
                                        <strong><?= html_escape($pengajuan->tipe_pengajuan) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tipe Akses</small>
                                        <strong><?= html_escape($pengajuan->tipe_akses) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Nomor Mesin</small>
                                        <strong><?= html_escape($pengajuan->nomor_mesin) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Nomor Rangka</small>
                                        <strong><?= html_escape($pengajuan->nomor_rangka) ?></strong>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted d-block">Tujuan Penggunaan</small>
                                        <strong><?= html_escape($pengajuan->tujuan) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tanggal Pengajuan</small>
                                        <strong><?= date('d M Y H:i', strtotime($pengajuan->tanggal_pengajuan)) ?></strong>
                                    </div>
                                    <?php if ($pengajuan->is_unit_baru): ?>
                                        <div class="col-12">
                                            <span class="badge bg-warning text-dark">Unit Baru</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAMPIRAN -->
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-body pt-4">
                                <h6 class="card-title mb-3">Lampiran Dokumen</h6>
                                <?php if (empty($lampiran)): ?>
                                    <p class="text-muted small">Tidak ada lampiran (unit lama).</p>
                                <?php else: ?>
                                    <div class="row g-2">
                                        <?php
                                        $jenis_label = [
                                            'stnk'          => 'STNK',
                                            'unit_depan'    => 'Foto Depan',
                                            'unit_belakang' => 'Foto Belakang',
                                            'unit_kiri'     => 'Foto Kiri',
                                            'unit_kanan'    => 'Foto Kanan',
                                        ];
                                        foreach ($lampiran as $lamp):
                                            $label = isset($jenis_label[$lamp->jenis_lampiran]) ? $jenis_label[$lamp->jenis_lampiran] : $lamp->jenis_lampiran;
                                            $ext   = strtolower(pathinfo($lamp->file_path, PATHINFO_EXTENSION));
                                            $is_img = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                                        ?>
                                            <div class="col-6">
                                                <div class="border rounded p-1 text-center" style="font-size:11px;">
                                                    <?php if ($is_img): ?>
                                                        <a href="<?= base_url($lamp->file_path) ?>" target="_blank">
                                                            <img src="<?= base_url($lamp->file_path) ?>"
                                                                class="img-fluid rounded mb-1" style="max-height:80px;object-fit:cover;width:100%;"
                                                                alt="<?= $label ?>">
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?= base_url($lamp->file_path) ?>" target="_blank"
                                                            class="d-block py-2">
                                                            <i class="bi bi-file-earmark-pdf text-danger fs-3 d-block"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <span class="text-muted"><?= $label ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- RIWAYAT APPROVAL -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pt-4">
                                <h6 class="card-title mb-3">Riwayat Approval</h6>
                                <?php if (empty($riwayat)): ?>
                                    <p class="text-muted small">Belum ada riwayat.</p>
                                <?php else: ?>
                                    <div class="timeline-approval">
                                        <?php foreach ($riwayat as $r):
                                            $icon  = $r->status === 'approved' ? 'bi-check-circle-fill text-success'
                                                : ($r->status === 'rejected' ? 'bi-x-circle-fill text-danger'
                                                    : 'bi-clock-fill text-warning');
                                            $level_label = [
                                                'manager' => 'Manager',
                                                'admin'   => 'Admin OHS',
                                                'ohs'     => 'OHS Superintendent',
                                                'ktt'     => 'KTT',
                                            ];
                                        ?>
                                            <div class="d-flex gap-3 mb-3">
                                                <div class="pt-1"><i class="bi <?= $icon ?> fs-5"></i></div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold small">
                                                        <?= isset($level_label[$r->level_approval]) ? $level_label[$r->level_approval] : $r->level_approval ?>
                                                        — <?php
                                                            if ($r->status === 'approved')  echo '<span class="text-success">Disetujui</span>';
                                                            elseif ($r->status === 'rejected') echo '<span class="text-danger">Ditolak</span>';
                                                            else echo '<span class="text-warning">Menunggu</span>';
                                                            ?>
                                                    </div>
                                                    <?php if ($r->nama_approver): ?>
                                                        <small class="text-muted">oleh <?= html_escape($r->nama_approver) ?></small>
                                                    <?php endif; ?>
                                                    <?php if ($r->catatan): ?>
                                                        <div class="mt-1 p-2 bg-light rounded small"><?= html_escape($r->catatan) ?></div>
                                                    <?php endif; ?>
                                                    <?php if ($r->created_at): ?>
                                                        <small class="text-muted"><?= date('d M Y H:i', strtotime($r->created_at)) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div><!-- end row -->

                <!-- TOMBOL AKSI -->
                <?php if ($is_pending): ?>
                    <div class="card mt-3 border-primary">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <strong>Tindakan Anda:</strong>
                                    <span class="text-muted small ms-2">Setujui atau tolak pengajuan ini</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('approval/' . $level) ?>" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-arrow-left me-1"></i>Kembali
                                    </a>
                                    <button class="btn btn-danger btn-sm" id="btnRejectDetail"
                                        data-id="<?= $pengajuan->id_pengajuan ?>"
                                        data-polisi="<?= html_escape($pengajuan->no_polisi) ?>">
                                        <i class="bi bi-x-circle me-1"></i>Tolak
                                    </button>
                                    <button class="btn btn-success btn-sm" id="btnApproveDetail"
                                        data-id="<?= $pengajuan->id_pengajuan ?>"
                                        data-polisi="<?= html_escape($pengajuan->no_polisi) ?>">
                                        <i class="bi bi-check-circle me-1"></i>Setujui
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-3">
                        <a href="<?= base_url('approval/' . $level) ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
</main>


<!-- Modal Reject -->
<div class="modal fade" id="modalReject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Tolak Pengajuan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Pengajuan <strong><?= html_escape($pengajuan->no_polisi) ?></strong> akan ditolak.</p>
                <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="rejectCatatan" rows="4"
                    placeholder="Tuliskan alasan penolakan secara jelas..."
                    maxlength="500"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger btn-sm" id="btnKonfirmasiReject">
                    <i class="bi bi-x-circle me-1"></i>Tolak Pengajuan
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        var level = '<?= $level ?>';
        var modalReject = new bootstrap.Modal(document.getElementById('modalReject'));
        var id_pengajuan = <?= $pengajuan->id_pengajuan ?>;

        // Approve
        $('#btnApproveDetail').on('click', function() {
            Swal.fire({
                title: 'Setujui Pengajuan?',
                html: 'Kendaraan <strong><?= html_escape($pengajuan->no_polisi) ?></strong> akan diteruskan ke tahap berikutnya.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2eca6a',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Ya, Setujui',
            }).then(function(r) {
                if (r.isConfirmed) proses('approve', '');
            });
        });

        // Reject
        $('#btnRejectDetail').on('click', function() {
            $('#rejectCatatan').val('');
            modalReject.show();
        });

        $('#btnKonfirmasiReject').on('click', function() {
            var catatan = $('#rejectCatatan').val().trim();
            if (!catatan) {
                toastr.warning('Alasan penolakan wajib diisi.');
                return;
            }
            modalReject.hide();
            proses('reject', catatan);
        });

        function proses(aksi, catatan) {
            NProgress.start();
            var post = {
                level: level,
                id_pengajuan: id_pengajuan,
                aksi: aksi,
                catatan: catatan
            };
            post[csrfName] = csrfHash;

            $.ajax({
                url: '<?= site_url('approval/proses') ?>',
                type: 'POST',
                data: post,
                dataType: 'json',
                success: function(res) {
                    NProgress.done();
                    if (res.status === 'success') {
                        if (res.redirect_jadwal) {
                            Swal.fire({
                                title: 'Disetujui!',
                                html: res.message + '<br><small class="text-muted">Anda akan diarahkan ke form jadwal uji.</small>',
                                icon: 'success',
                                confirmButtonColor: '#4154f1',
                                confirmButtonText: 'Buat Jadwal',
                            }).then(function() {
                                window.location.href = res.redirect_jadwal;
                            });
                            return;
                        }
                        Swal.fire({
                            title: aksi === 'approve' ? 'Disetujui!' : 'Ditolak',
                            html: res.message,
                            icon: aksi === 'approve' ? 'success' : 'warning',
                            confirmButtonColor: '#4154f1',
                        }).then(function() {
                            window.location.href = res.redirect;
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            html: res.message,
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    NProgress.done();
                    toastr.error('Terjadi kesalahan server.');
                }
            });
        }
    });
</script>