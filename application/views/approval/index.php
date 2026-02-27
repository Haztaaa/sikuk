<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= html_escape($cfg['label']) ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= html_escape($cfg['label']) ?></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-4">

                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h5 class="card-title mb-0">
                                <?= html_escape($cfg['label']) ?>
                                <?php if ($pending_count > 0): ?>
                                    <span class="badge bg-danger ms-2"><?= $pending_count ?> menunggu</span>
                                <?php endif; ?>
                            </h5>
                            <!-- Search -->
                            <form method="get" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Cari no. polisi / pemohon..."
                                    value="<?= html_escape($this->input->get('search')) ?>"
                                    style="width:220px;">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show py-2">
                                <?= $this->session->flashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Label & warna badge status
                        $status_labels = [
                            'submitted'       => ['bg-secondary',          'Submitted'],
                            'review_manager'  => ['bg-warning text-dark',  'Review Manager'],
                            'approved_manager' => ['bg-info text-dark',     'Approved Manager'],
                            'review_admin'    => ['bg-warning text-dark',  'Review Admin'],
                            'approved_admin'  => ['bg-info text-dark',     'Approved Admin'],
                            'scheduled'       => ['bg-primary',            'Terjadwal'],
                            'review_ohs'      => ['bg-warning text-dark',  'Review OHS'],
                            'approved_ohs'    => ['bg-info text-dark',     'Approved OHS'],
                            'approved_ktt'    => ['bg-success',            'Approved KTT'],
                            'sticker_released' => ['bg-success',            'Sticker Released'],
                            'rejected'        => ['bg-danger',             'Ditolak'],
                        ];
                        ?>

                        <?php if (empty($list)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada pengajuan untuk direview.
                            </div>
                        <?php else: ?>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>No. Pengajuan</th>
                                            <th>Kendaraan</th>
                                            <th>Pemohon</th>
                                            <th>Tgl Pengajuan</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list as $i => $row):
                                            $sl     = isset($status_labels[$row->status]) ? $status_labels[$row->status] : ['bg-secondary', '—'];
                                            $is_pending = in_array($row->status, $status_masuk);
                                        ?>
                                            <tr class="<?= $is_pending ? '' : 'opacity-75' ?>">
                                                <td><?= $i + 1 ?></td>
                                                <td>
                                                    <strong class="text-primary">#PU-<?= str_pad($row->id_pengajuan, 4, '0', STR_PAD_LEFT) ?></strong>
                                                    <?php if ($row->is_unit_baru): ?>
                                                        <span class="badge bg-warning text-dark ms-1" style="font-size:10px;">Unit Baru</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold"><?= html_escape($row->no_polisi) ?></span>
                                                    <br><small class="text-muted"><?= html_escape($row->jenis_kendaraan) ?> — <?= html_escape($row->merk) ?> <?= html_escape($row->tipe) ?></small>
                                                </td>
                                                <td>
                                                    <?= html_escape($row->nama_pemohon) ?>
                                                    <br><small class="text-muted"><?= html_escape($row->email_pemohon) ?></small>
                                                </td>
                                                <td>
                                                    <small><?= date('d M Y H:i', strtotime($row->tanggal_pengajuan)) ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $sl[0] ?>"><?= $sl[1] ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('approval/detail/' . $level . '/' . $row->id_pengajuan) ?>"
                                                        class="btn btn-sm btn-outline-primary py-0">
                                                        <i class="bi bi-eye me-1"></i>Detail
                                                    </a>
                                                    <?php if ($is_pending): ?>
                                                        <button class="btn btn-sm btn-success py-0 btn-approve"
                                                            data-id="<?= $row->id_pengajuan ?>"
                                                            data-polisi="<?= html_escape($row->no_polisi) ?>">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger py-0 btn-reject"
                                                            data-id="<?= $row->id_pengajuan ?>"
                                                            data-polisi="<?= html_escape($row->no_polisi) ?>">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<!-- Modal Reject (dengan catatan wajib) -->
<div class="modal fade" id="modalReject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Tolak Pengajuan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Pengajuan: <strong id="rejectPolisi"></strong></p>
                <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="rejectCatatan" rows="3"
                    placeholder="Tuliskan alasan penolakan secara jelas..."
                    maxlength="500"></textarea>
                <small class="text-muted">Catatan ini akan terlihat oleh pemohon.</small>
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
        var activeId = null;

        // -----------------------------------------------
        // APPROVE langsung dari tabel
        // -----------------------------------------------
        $(document).on('click', '.btn-approve', function() {
            var id = $(this).data('id');
            var polisi = $(this).data('polisi');

            Swal.fire({
                title: 'Setujui Pengajuan?',
                html: 'Kendaraan <strong>' + polisi + '</strong> akan disetujui dan diteruskan ke tahap berikutnya.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2eca6a',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Ya, Setujui',
                cancelButtonText: 'Batal',
            }).then(function(r) {
                if (r.isConfirmed) prosesApproval(id, 'approve', '');
            });
        });

        // -----------------------------------------------
        // REJECT — buka modal catatan
        // -----------------------------------------------
        $(document).on('click', '.btn-reject', function() {
            activeId = $(this).data('id');
            $('#rejectPolisi').text($(this).data('polisi'));
            $('#rejectCatatan').val('');
            modalReject.show();
        });

        $('#btnKonfirmasiReject').on('click', function() {
            var catatan = $('#rejectCatatan').val().trim();
            if (!catatan) {
                toastr.warning('Alasan penolakan wajib diisi.');
                $('#rejectCatatan').focus();
                return;
            }
            modalReject.hide();
            prosesApproval(activeId, 'reject', catatan);
        });

        // -----------------------------------------------
        // Kirim ke server
        // -----------------------------------------------
        function prosesApproval(id_pengajuan, aksi, catatan) {
            NProgress.start();

            var post = {
                level: level,
                id_pengajuan: id_pengajuan,
                aksi: aksi,
                catatan: catatan,
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
                        // Admin OHS approve → langsung redirect ke form jadwal
                        if (res.redirect_jadwal) {
                            Swal.fire({
                                title: 'Disetujui!',
                                html: res.message + '<br><small class="text-muted">Mengarahkan ke form jadwal uji...</small>',
                                icon: 'success',
                                confirmButtonColor: '#4154f1',
                                confirmButtonText: 'Buat Jadwal Sekarang',
                                showConfirmButton: true,
                            }).then(function() {
                                window.location.href = res.redirect_jadwal;
                            });
                            return;
                        }
                        var icon = aksi === 'approve' ? 'success' : 'warning';
                        Swal.fire({
                            title: aksi === 'approve' ? 'Disetujui!' : 'Ditolak',
                            html: res.message,
                            icon: icon,
                            confirmButtonColor: '#4154f1',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2100);
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
                }
            });
        }

    });
</script>