<main id="main" class="main">

    <div class="pagetitle">
        <h1>Jadwal Uji Kelayakan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Jadwal Uji</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <!-- STAT CARDS -->
        <div class="row g-3 mb-3">
            <?php
            $total     = count($jadwals);
            $scheduled = count(array_filter($jadwals, fn($j) => $j->status === 'scheduled'));
            $done      = count(array_filter($jadwals, fn($j) => $j->status === 'done'));
            $cancelled = count(array_filter($jadwals, fn($j) => $j->status === 'cancelled'));

            // Pengajuan approved_admin yang belum dijadwalkan
            $pending_jadwal = $this->db
                ->where('status', 'approved_admin')
                ->count_all_results('pengajuan_uji');
            ?>
            <div class="col-sm-3">
                <div class="card border-0 bg-primary bg-opacity-10 text-center py-3">
                    <div class="fs-2 fw-bold text-primary"><?= $total ?></div>
                    <div class="text-muted small">Total Jadwal</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 bg-info bg-opacity-10 text-center py-3">
                    <div class="fs-2 fw-bold text-info"><?= $scheduled ?></div>
                    <div class="text-muted small">Terjadwal</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 bg-success bg-opacity-10 text-center py-3">
                    <div class="fs-2 fw-bold text-success"><?= $done ?></div>
                    <div class="text-muted small">Selesai</div>
                </div>
            </div>
            <div class="col-sm-3">
                <a href="#antriJadwal" class="text-decoration-none">
                    <div class="card border-0 <?= $pending_jadwal > 0 ? 'bg-warning bg-opacity-25' : 'bg-secondary bg-opacity-10' ?> text-center py-3">
                        <div class="fs-2 fw-bold <?= $pending_jadwal > 0 ? 'text-warning' : 'text-secondary' ?>"><?= $pending_jadwal ?></div>
                        <div class="small <?= $pending_jadwal > 0 ? 'text-warning fw-semibold' : 'text-muted' ?>">
                            <?= $pending_jadwal > 0 ? '⚠ Menunggu Dijadwalkan' : 'Menunggu Jadwal' ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <?php if ($pending_jadwal > 0): ?>
            <!-- PENGAJUAN MENUNGGU JADWAL -->
            <div class="card mb-3 border-warning" id="antriJadwal">
                <div class="card-body pt-3 pb-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="card-title mb-0 text-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Pengajuan Menunggu Jadwal
                            <span class="badge bg-warning text-dark ms-1"><?= $pending_jadwal ?></span>
                        </h6>
                    </div>
                    <?php
                    $antri = $this->db
                        ->select('pu.id_pengajuan, pu.tanggal_pengajuan, k.no_polisi, k.jenis_kendaraan, k.merk, k.tipe, u.nama AS nama_pemohon')
                        ->from('pengajuan_uji pu')
                        ->join('kendaraan k', 'k.id_kendaraan = pu.id_kendaraan')
                        ->join('users u', 'u.id_user = pu.id_pemohon')
                        ->where('pu.status', 'approved_admin')
                        ->order_by('pu.tanggal_pengajuan', 'ASC')
                        ->get()->result();
                    ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>Kendaraan</th>
                                    <th>Pemohon</th>
                                    <th>Tgl Pengajuan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($antri as $a): ?>
                                    <tr>
                                        <td><strong class="text-primary"><?= html_escape($a->no_polisi) ?></strong></td>
                                        <td><small><?= html_escape($a->jenis_kendaraan) ?> — <?= html_escape($a->merk) ?> <?= html_escape($a->tipe) ?></small></td>
                                        <td><small><?= html_escape($a->nama_pemohon) ?></small></td>
                                        <td><small><?= date('d M Y', strtotime($a->tanggal_pengajuan)) ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('jadwal/create/' . $a->id_pengajuan) ?>"
                                                class="btn btn-sm btn-primary py-0 px-2">
                                                <i class="bi bi-calendar-plus me-1"></i>Jadwalkan
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-3">

            <!-- KALENDER -->
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-body pt-4">
                        <h5 class="card-title">Kalender Jadwal</h5>
                        <div id="kalender"></div>
                    </div>
                </div>
            </div>

            <!-- DAFTAR JADWAL -->
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Daftar Jadwal</h5>
                            <!-- Filter bulan -->
                            <select class="form-select form-select-sm w-auto" id="filterBulan">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= ($filter['bulan'] == $m || (!$filter['bulan'] && $m == date('n'))) ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div id="listJadwal" style="max-height:520px;overflow-y:auto;">
                            <?php if (empty($jadwals)): ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                    Belum ada jadwal.
                                </div>
                            <?php else: ?>
                                <?php foreach ($jadwals as $j): ?>
                                    <div class="border rounded p-2 mb-2 jadwal-item" data-id="<?= $j->id_jadwal ?>">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="fw-bold text-primary small"><?= html_escape($j->no_polisi) ?></span>
                                                <span class="ms-1 text-muted small"><?= html_escape($j->jenis_kendaraan) ?></span>
                                            </div>
                                            <?php
                                            $badge = $j->status === 'scheduled' ? 'bg-primary'
                                                : ($j->status === 'done'     ? 'bg-success' : 'bg-danger');
                                            $label = $j->status === 'scheduled' ? 'Terjadwal'
                                                : ($j->status === 'done'     ? 'Selesai'    : 'Dibatalkan');
                                            ?>
                                            <span class="badge <?= $badge ?> small"><?= $label ?></span>
                                        </div>
                                        <div class="text-muted small mt-1">
                                            <i class="bi bi-calendar3 me-1"></i><?= date('d M Y H:i', strtotime($j->tanggal_uji)) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i><?= html_escape($j->lokasi ?: '—') ?>
                                        </div>
                                        <?php if ($j->status === 'scheduled'): ?>
                                            <div class="d-flex gap-1 mt-2">
                                                <a href="<?= site_url('jadwal/edit/' . $j->id_jadwal) ?>"
                                                    class="btn btn-xs btn-outline-secondary py-0 px-2" style="font-size:11px;">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button class="btn btn-xs btn-outline-danger py-0 px-2 btn-cancel"
                                                    data-id="<?= $j->id_jadwal ?>"
                                                    data-polisi="<?= html_escape($j->no_polisi) ?>"
                                                    style="font-size:11px;">
                                                    <i class="bi bi-x-circle"></i> Batal
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</main>


<!-- Modal Detail Jadwal (dari klik kalender) -->
<div class="modal fade" id="modalDetailJadwal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-calendar-check me-2"></i>Detail Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailJadwalBody">
                <div class="text-center py-3"><span class="spinner-border text-primary"></span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-outline-secondary btn-sm" id="btnEditJadwal">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <button type="button" class="btn btn-danger btn-sm" id="btnCancelJadwal">
                    <i class="bi bi-x-circle me-1"></i>Batalkan
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Load FullCalendar dari CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    $(function() {

        var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        var modalDetail = new bootstrap.Modal(document.getElementById('modalDetailJadwal'));
        var activeJadwalId = null;

        // -----------------------------------------------
        // FULLCALENDAR
        // -----------------------------------------------
        var calendarEl = document.getElementById('kalender');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            height: 500,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: <?= $events_json ?>,
            eventClick: function(info) {
                var id = info.event.extendedProps.id_jadwal;
                bukaDetailJadwal(id);
            },
            eventDidMount: function(info) {
                // Tooltip Bootstrap
                new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.pemohon + ' | ' + (info.event.extendedProps.lokasi || '-'),
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                });
            },
        });
        calendar.render();

        // -----------------------------------------------
        // Klik jadwal di list → buka detail
        // -----------------------------------------------
        $(document).on('click', '.jadwal-item', function() {
            var id = $(this).data('id');
            bukaDetailJadwal(id);
        });

        function bukaDetailJadwal(id) {
            activeJadwalId = id;
            $('#detailJadwalBody').html('<div class="text-center py-3"><span class="spinner-border text-primary"></span></div>');
            $('#btnEditJadwal').attr('href', '<?= site_url('jadwal/edit') ?>/' + id);
            modalDetail.show();

            var post = {
                id_jadwal: id
            };
            post[csrfName] = csrfHash;

            $.post('<?= site_url('jadwal/detail') ?>', post, function(res) {
                if (res.status === 'success' && res.data) {
                    var d = res.data;
                    var statusBadge = d.status === 'scheduled' ?
                        '<span class="badge bg-primary">Terjadwal</span>' :
                        (d.status === 'done' ?
                            '<span class="badge bg-success">Selesai</span>' :
                            '<span class="badge bg-danger">Dibatalkan</span>');

                    var html = '<div class="row g-2">' +
                        '<div class="col-6"><small class="text-muted d-block">No. Polisi</small><strong class="text-primary">' + d.no_polisi + '</strong></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Jenis</small><strong>' + d.jenis_kendaraan + '</strong></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Merk / Tipe</small><strong>' + d.merk + ' ' + d.tipe_kendaraan + '</strong></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Pemohon</small><strong>' + d.nama_pemohon + '</strong></div>' +
                        '<div class="col-12"><hr class="my-2"></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Tanggal & Jam</small><strong>' + formatTanggal(d.tanggal_uji) + '</strong></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Lokasi</small><strong>' + (d.lokasi || '—') + '</strong></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Dijadwalkan oleh</small><strong>' + (d.dibuat_oleh_nama || '—') + '</strong></div>' +
                        '<div class="col-6"><small class="text-muted d-block">Status</small>' + statusBadge + '</div>' +
                        (d.keterangan ? '<div class="col-12"><small class="text-muted d-block">Keterangan</small><p class="mb-0 small">' + d.keterangan + '</p></div>' : '') +
                        '</div>';

                    $('#detailJadwalBody').html(html);

                    // Sembunyikan tombol edit/cancel jika bukan scheduled
                    if (d.status !== 'scheduled') {
                        $('#btnEditJadwal, #btnCancelJadwal').hide();
                    } else {
                        $('#btnEditJadwal, #btnCancelJadwal').show();
                    }
                }
            }, 'json');
        }

        // -----------------------------------------------
        // Cancel dari modal
        // -----------------------------------------------
        $('#btnCancelJadwal').on('click', function() {
            cancelJadwal(activeJadwalId);
        });

        $(document).on('click', '.btn-cancel', function(e) {
            e.stopPropagation();
            var id = $(this).data('id');
            var polisi = $(this).data('polisi');
            cancelJadwal(id, polisi);
        });

        function cancelJadwal(id, polisi) {
            Swal.fire({
                title: 'Batalkan Jadwal?',
                html: polisi ? 'Jadwal untuk <strong>' + polisi + '</strong> akan dibatalkan.' : 'Jadwal ini akan dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak',
            }).then(function(r) {
                if (!r.isConfirmed) return;

                var post = {
                    id_jadwal: id
                };
                post[csrfName] = csrfHash;

                $.post('<?= site_url('jadwal/cancel') ?>', post, function(res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        modalDetail.hide();
                        setTimeout(function() {
                            location.reload();
                        }, 800);
                    } else {
                        toastr.error(res.message);
                    }
                }, 'json');
            });
        }

        // -----------------------------------------------
        // Filter bulan
        // -----------------------------------------------
        $('#filterBulan').on('change', function() {
            window.location.href = '<?= site_url('jadwal') ?>?bulan=' + $(this).val() + '&tahun=<?= $filter['tahun'] ?>';
        });

        // -----------------------------------------------
        // Helper format tanggal
        // -----------------------------------------------
        function formatTanggal(str) {
            if (!str) return '—';
            var d = new Date(str);
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() +
                ' ' + String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
        }

    });
</script>