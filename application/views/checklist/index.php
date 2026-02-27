<main id="main" class="main">

    <div class="pagetitle">
        <h1>Checklist Template</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Checklist Template</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <?php foreach ($templates as $tmpl): ?>
                <div class="col-xl-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body pt-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-secondary"><?= html_escape($tmpl->kode) ?></span>
                                <span class="badge <?= $tmpl->is_active ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $tmpl->is_active ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </div>
                            <h6 class="fw-bold mb-1"><?= html_escape($tmpl->jenis_unit) ?></h6>
                            <p class="text-muted small mb-3"><?= html_escape($tmpl->nama_template) ?></p>
                            <a href="<?= site_url('checklist/template/' . $tmpl->id_template) ?>"
                                class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-list-check me-1"></i>Lihat & Kelola Items
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</main>