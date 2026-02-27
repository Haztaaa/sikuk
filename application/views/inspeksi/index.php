<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Inspeksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Form Inspeksi</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <h5 class="card-title">Daftar Kendaraan Siap Diinspeksi</h5>

                        <?php if (empty($list_inspeksi)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada kendaraan yang dijadwalkan untuk inspeksi.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>No. Polisi</th>
                                            <th>Jenis / Merk</th>
                                            <th>Pemohon</th>
                                            <th>Jadwal Inspeksi</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_inspeksi as $i => $row): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td>
                                                    <strong class="text-primary"><?= html_escape($row->no_polisi) ?></strong>
                                                    <br><small class="text-muted">#PU-<?= str_pad($row->id_pengajuan, 4, '0', STR_PAD_LEFT) ?></small>
                                                </td>
                                                <td>
                                                    <?= html_escape($row->jenis_kendaraan) ?>
                                                    <br><small class="text-muted"><?= html_escape($row->merk) ?> <?= html_escape($row->tipe) ?> (<?= $row->tahun ?>)</small>
                                                </td>
                                                <td><?= html_escape($row->nama_pemohon) ?></td>
                                                <td>
                                                    <?php if ($row->tanggal_uji): ?>
                                                        <strong><?= date('d M Y', strtotime($row->tanggal_uji)) ?></strong>
                                                        <br><small class="text-muted"><?= date('H:i', strtotime($row->tanggal_uji)) ?> WIB</small>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= html_escape($row->lokasi ?: '—') ?></td>
                                                <td>
                                                    <?php if ($row->id_uji): ?>
                                                        <span class="badge bg-warning text-dark">Draft Tersimpan</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-info text-dark">Belum Diisi</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('checklist/form/' . $row->id_pengajuan) ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-clipboard2-check me-1"></i>
                                                        <?= $row->id_uji ? 'Lanjutkan' : 'Mulai Inspeksi' ?>
                                                    </a>
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