<main id="main" class="main">

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
                <div id="formPengajuan">

                    <!-- =============================================
               SECTION 1 — Tipe Pengajuan
               Pilihan ini LANGSUNG menentukan mode unit:
               new_commissioning  → sectionUnitBaru (modeUnit='baru')
               recommissioning    → sectionUnitLama (modeUnit='lama')
          ============================================== -->
                    <div class="card mb-3">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="step-badge">1</span>
                                Tipe Pengajuan / <em class="fw-normal text-muted">Commissioning Type</em>
                            </h6>
                            <div class="row g-3">

                                <!-- Tipe Commissioning -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipe Commissioning <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3 mt-1">

                                        <label class="tipe-card flex-fill p-3 border rounded" for="tipeNew" style="cursor:pointer;">
                                            <input type="radio" class="d-none" name="tipe_pengajuan" id="tipeNew" value="new_commissioning">
                                            <div class="fw-bold text-primary mb-1">
                                                <i class="bi bi-plus-circle me-1"></i>Pengajuan Kelayakan
                                            </div>
                                            <small class="text-muted d-block">New Commissioning</small>
                                            <small class="text-success d-block mt-1">
                                                <i class="bi bi-star-fill me-1"></i>Unit / kendaraan baru
                                            </small>
                                        </label>

                                        <label class="tipe-card flex-fill p-3 border rounded" for="tipeRecomm" style="cursor:pointer;">
                                            <input type="radio" class="d-none" name="tipe_pengajuan" id="tipeRecomm" value="recommissioning">
                                            <div class="fw-bold text-primary mb-1">
                                                <i class="bi bi-arrow-repeat me-1"></i>Pengajuan Kembali
                                            </div>
                                            <small class="text-muted d-block">Recommissioning</small>
                                            <small class="text-info d-block mt-1">
                                                <i class="bi bi-clock-history me-1"></i>Unit sudah pernah lulus (berkala 6 bulan)
                                            </small>
                                        </label>

                                    </div>
                                    <div class="text-danger small mt-1" id="err_tipe_pengajuan"></div>
                                </div>

                                <!-- Tipe Akses -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipe Akses / <em class="fw-normal">Access Type</em> <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3 mt-1">
                                        <label class="tipe-card flex-fill p-3 border rounded" for="aksesMining" style="cursor:pointer;">
                                            <input type="radio" class="d-none" name="tipe_akses" id="aksesMining" value="mining">
                                            <div class="fw-bold mb-1"><i class="bi bi-minecart-loaded me-1"></i>Mining Access</div>
                                            <small class="text-muted">Area tambang</small>
                                        </label>
                                        <label class="tipe-card flex-fill p-3 border rounded" for="aksesNonMining" style="cursor:pointer;">
                                            <input type="radio" class="d-none" name="tipe_akses" id="aksesNonMining" value="non_mining">
                                            <div class="fw-bold mb-1"><i class="bi bi-building me-1"></i>Non Mining</div>
                                            <small class="text-muted">Area non-tambang</small>
                                        </label>
                                    </div>
                                    <div class="text-danger small mt-1" id="err_tipe_akses"></div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- =============================================
               SECTION 2 — Detail Unit
               Muncul otomatis setelah pilih tipe commissioning
          ============================================== -->
                    <div class="card mb-3" id="sectionDetailUnit" style="display:none;">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="step-badge">2</span>
                                Detail Unit / <em class="fw-normal text-muted">Unit Details</em>
                                <span id="badgeModeUnit"></span>
                            </h6>

                            <!-- ===== UNIT BARU — new_commissioning ===== -->
                            <div id="sectionUnitBaru" style="display:none;">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tipe Unit / <em class="fw-normal">Unit Type</em> <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_kendaraan" name="jenis_kendaraan">
                                            <option value="">— Pilih Tipe Unit —</option>
                                            <?php foreach ($tipe_kendaraan as $tk): ?>
                                                <option value="<?= html_escape($tk->nama_tipe) ?>"><?= html_escape($tk->nama_tipe) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="text-danger small mt-1" id="err_jenis_kendaraan"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nomor Unit / <em class="fw-normal">Unit No.</em> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nomor_unit" id="nomor_unit" placeholder="misal: DT-001">
                                        <div class="text-danger small mt-1" id="err_nomor_unit"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Merk Unit / <em class="fw-normal">Unit Brand</em> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="merk" id="merk" placeholder="misal: Volvo, Komatsu">
                                        <div class="text-danger small mt-1" id="err_merk"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Model Unit / <em class="fw-normal">Unit Model</em> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="model_unit" id="model_unit" placeholder="misal: D375A-6">
                                        <div class="text-danger small mt-1" id="err_model_unit"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nomor Rangka / <em class="fw-normal">Chassis No.</em> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nomor_rangka" id="nomor_rangka_baru" placeholder="Nomor rangka">
                                        <div class="text-danger small mt-1" id="err_nomor_rangka"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nomor Mesin / <em class="fw-normal">Machine No.</em> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nomor_mesin" id="nomor_mesin_baru" placeholder="Nomor mesin">
                                        <div class="text-danger small mt-1" id="err_nomor_mesin"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nomor Polisi / <em class="fw-normal">Police No.</em> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_polisi" id="no_polisi"
                                            placeholder="misal: DB 1234 GT" style="text-transform:uppercase;">
                                        <div class="text-danger small mt-1" id="err_no_polisi"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Perusahaan / <em class="fw-normal">Company</em> <span class="text-danger">*</span></label>
                                        <select class="form-select" id="perusahaan" name="perusahaan" style="width:100%;">
                                            <option value="">— Pilih Perusahaan —</option>
                                            <?php foreach ($perusahaan as $p): ?>
                                                <option value="<?= html_escape($p->nama_perusahaan) ?>"><?= html_escape($p->nama_perusahaan) ?><?= $p->singkatan ? ' (' . html_escape($p->singkatan) . ')' : '' ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="text-danger small mt-1" id="err_perusahaan"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tahun / <em class="fw-normal">Year</em> <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="tahun" id="tahun"
                                            placeholder="misal: 2022" min="1990" max="<?= date('Y') + 1 ?>">
                                        <div class="text-danger small mt-1" id="err_tahun"></div>
                                    </div>

                                    <!-- ========== STNK ========== -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            Foto STNK <span class="text-danger">*</span>
                                            <span class="badge bg-warning text-dark ms-1">Wajib Unit Baru</span>
                                        </label>
                                        <div class="border rounded p-3 d-flex align-items-center gap-3 flex-wrap upload-row" id="box_stnk">
                                            <i class="bi bi-card-text text-primary flex-shrink-0" style="font-size:2rem;"></i>
                                            <div class="flex-grow-1">
                                                <input type="file" class="form-control form-control-sm" id="lampiran_stnk" name="lampiran_stnk" accept=".jpg,.jpeg,.png,.pdf">
                                                <small class="text-muted">JPG, PNG, atau PDF. Maks 2MB.</small>
                                                <div class="text-danger small" id="err_stnk"></div>
                                            </div>
                                            <!-- Thumbnail preview STNK -->
                                            <div id="thumb_stnk" class="thumb-wrap d-none">
                                                <div class="position-relative">
                                                    <img id="thumb_stnk_img" src="" alt="STNK"
                                                        class="rounded border" style="height:52px;width:72px;object-fit:cover;">
                                                    <button type="button" class="btn-clear-file btn btn-danger rounded-circle p-0"
                                                        style="width:18px;height:18px;font-size:9px;position:absolute;top:-7px;right:-7px;"
                                                        data-input="lampiran_stnk" data-thumb="thumb_stnk" data-box="box_stnk">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="thumb_stnk_pdf" class="d-none d-flex align-items-center gap-1">
                                                <span class="badge bg-danger px-2 py-2"><i class="bi bi-file-earmark-pdf me-1"></i><span id="stnk_pdf_name"></span></span>
                                                <button type="button" class="btn-clear-file btn btn-sm btn-outline-danger py-0 px-1 ms-1"
                                                    data-input="lampiran_stnk" data-thumb="thumb_stnk_pdf" data-box="box_stnk">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ========== FOTO 4 SISI ========== -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            Foto Unit 4 Sisi <span class="text-danger">*</span>
                                            <small class="text-muted fw-normal ms-1">Depan, Belakang, Kiri, Kanan</small>
                                        </label>
                                        <div class="row g-2">
                                            <?php
                                            $foto_list = [
                                                'unit_depan'    => ['Depan',    'bi-truck'],
                                                'unit_belakang' => ['Belakang', 'bi-truck'],
                                                'unit_kiri'     => ['Kiri',     'bi-layout-sidebar'],
                                                'unit_kanan'    => ['Kanan',    'bi-layout-sidebar-reverse'],
                                            ];
                                            foreach ($foto_list as $fkey => [$flabel, $ficon]):
                                            ?>
                                                <div class="col-6 col-md-3">
                                                    <div class="foto-box border rounded text-center p-2" id="fbox_<?= $fkey ?>">

                                                        <!-- Default: ikon + input -->
                                                        <div id="fdefault_<?= $fkey ?>">
                                                            <i class="bi <?= $ficon ?> text-primary d-block mb-1" style="font-size:1.5rem;"></i>
                                                            <div class="small fw-semibold mb-1">
                                                                <?= $flabel ?> <span class="text-danger">*</span>
                                                            </div>
                                                            <input type="file" class="form-control form-control-sm"
                                                                id="lampiran_<?= $fkey ?>" name="lampiran_<?= $fkey ?>"
                                                                accept=".jpg,.jpeg,.png"
                                                                data-fkey="<?= $fkey ?>" data-label="<?= $flabel ?>">
                                                        </div>

                                                        <!-- Preview: thumbnail + tombol hapus -->
                                                        <div id="fpreview_<?= $fkey ?>" class="d-none">
                                                            <div class="position-relative d-inline-block">
                                                                <img id="fimg_<?= $fkey ?>" src="" alt="<?= $flabel ?>"
                                                                    class="rounded border"
                                                                    style="width:100%;height:80px;object-fit:cover;max-width:130px;">
                                                                <button type="button"
                                                                    class="btn-clear-foto btn btn-danger rounded-circle p-0"
                                                                    style="width:20px;height:20px;font-size:10px;position:absolute;top:-8px;right:-8px;"
                                                                    data-fkey="<?= $fkey ?>">
                                                                    <i class="bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="small text-success mt-1" id="fname_<?= $fkey ?>"></div>
                                                        </div>

                                                        <div class="text-danger mt-1" id="err_<?= $fkey ?>" style="font-size:11px;"></div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                </div><!-- end row unit baru -->
                            </div><!-- end sectionUnitBaru -->


                            <!-- ===== UNIT LAMA — recommissioning ===== -->
                            <div id="sectionUnitLama" style="display:none;">
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            Cari Kendaraan / <em class="fw-normal">Search Unit</em>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="alert alert-info py-2 mb-2" style="font-size:13px;">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Hanya kendaraan yang pernah lulus uji kelayakan yang dapat diajukan kembali (Recommissioning).
                                        </div>
                                        <select class="form-select" id="id_kendaraan" name="id_kendaraan" style="width:100%;">
                                            <option value="">— Ketik nomor polisi atau jenis kendaraan... —</option>
                                            <?php foreach ($kendaraan as $k): ?>
                                                <option value="<?= $k->id_kendaraan ?>"
                                                    data-json='<?= json_encode([
                                                                    'no_polisi'       => $k->no_polisi,
                                                                    'jenis_kendaraan' => $k->jenis_kendaraan,
                                                                    'merk'            => $k->merk,
                                                                    'tipe'            => $k->tipe,
                                                                    'tahun'           => $k->tahun,
                                                                    'nomor_unit'      => $k->nomor_unit ?? '',
                                                                    'model_unit'      => $k->model_unit ?? '',
                                                                    'perusahaan'      => $k->perusahaan ?? '',
                                                                ], JSON_HEX_QUOT | JSON_HEX_APOS) ?>'>
                                                    <?= html_escape($k->no_polisi) ?> — <?= html_escape($k->jenis_kendaraan) ?> <?= html_escape($k->merk) ?> <?= html_escape($k->tipe) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="text-danger small mt-1" id="err_id_kendaraan"></div>
                                    </div>

                                    <!-- Tabel detail unit (sesuai layout screenshot) -->
                                    <div class="col-12" id="infoKendaraanLama" style="display:none;">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th colspan="4" class="text-center py-2">
                                                        Detail Unit / <em class="fw-light">Unit Details</em>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-semibold bg-light" style="width:25%">Tipe Unit / <em class="fw-light text-muted">Unit Type</em></td>
                                                    <td id="lama_jenis" style="width:25%">—</td>
                                                    <td class="fw-semibold bg-light" style="width:25%">Nomor Rangka / <em class="fw-light text-muted">Chassis No.</em></td>
                                                    <td><input type="text" class="form-control form-control-sm" name="nomor_rangka" id="nomor_rangka_lama" placeholder="Isi nomor rangka"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold bg-light">Nomor Unit / <em class="fw-light text-muted">Unit No.</em></td>
                                                    <td id="lama_nomor_unit">—</td>
                                                    <td class="fw-semibold bg-light">Nomor Mesin / <em class="fw-light text-muted">Machine No.</em></td>
                                                    <td><input type="text" class="form-control form-control-sm" name="nomor_mesin" id="nomor_mesin_lama" placeholder="Isi nomor mesin"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold bg-light">Merk Unit / <em class="fw-light text-muted">Unit Brand</em></td>
                                                    <td id="lama_merk">—</td>
                                                    <td class="fw-semibold bg-light">Nomor Polisi / <em class="fw-light text-muted">Police No.</em></td>
                                                    <td id="lama_nopol">—</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold bg-light">Model Unit / <em class="fw-light text-muted">Unit Model</em></td>
                                                    <td id="lama_model">—</td>
                                                    <td class="fw-semibold bg-light">Perusahaan / <em class="fw-light text-muted">Company</em></td>
                                                    <td id="lama_perusahaan">—</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div><!-- end sectionUnitLama -->

                        </div>
                    </div><!-- end sectionDetailUnit -->


                    <!-- =============================================
               SECTION 3 — Tujuan Penggunaan
          ============================================== -->
                    <div class="card mb-3" id="sectionTujuan" style="display:none;">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="step-badge">3</span>
                                Tujuan Penggunaan / <em class="fw-normal text-muted">Purpose of Access</em>
                            </h6>
                            <textarea class="form-control" name="tujuan" id="tujuan" rows="4"
                                placeholder="Jelaskan tujuan penggunaan kendaraan dan area operasi..."
                                maxlength="1000"></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <div class="text-danger small" id="err_tujuan"></div>
                                <small class="text-muted ms-auto"><span id="charCount">0</span>/1000</small>
                            </div>
                        </div>
                    </div>


                    <!-- =============================================
               SECTION 4 — Informasi Pemohon
          ============================================== -->
                    <div class="card mb-3" id="sectionPemohon" style="display:none;">
                        <div class="card-body pt-4">
                            <h6 class="card-title d-flex align-items-center gap-2 mb-3">
                                <span class="step-badge">4</span>
                                Informasi Pemohon / <em class="fw-normal text-muted">Requester Information</em>
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Diajukan Oleh</label>
                                    <input type="text" class="form-control" value="<?= html_escape($user['nama']) ?>" readonly disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Pemohon <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" name="email_pemohon" id="email_pemohon"
                                            value="<?= html_escape($user['email'] ?? '') ?>" placeholder="nama@perusahaan.com">
                                    </div>
                                    <div class="text-danger small mt-1" id="err_email_pemohon"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Pengajuan</label>
                                    <input type="text" class="form-control" value="<?= date('d F Y') ?>" readonly disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Diteruskan ke</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-primary px-3">Manager Dept → Review & Approval</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- SUBMIT -->
                    <div class="card mb-4" id="sectionSubmit" style="display:none;">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1 text-primary"></i>
                                    Setelah disubmit, pengajuan diteruskan ke <strong>Manager</strong> untuk review.
                                </small>
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

                </div><!-- end #formPengajuan -->
            </div>
        </div>
    </section>
</main>


<!-- =====================================================
     STYLES
====================================================== -->
<style>
    /* Step badge */
    .step-badge {
        width: 26px;
        height: 26px;
        font-size: 13px;
        border-radius: 50%;
        background: #4154f1;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Tipe card — klik seluruh area */
    .tipe-card {
        transition: border-color .18s, background .18s;
        user-select: none;
    }

    .tipe-card:has(input:checked) {
        border-color: #4154f1 !important;
        background: #f0f2ff;
    }

    .tipe-card:hover {
        border-color: #adb5bd;
    }

    /* Foto box */
    .foto-box {
        transition: border-color .18s, background .18s;
        min-height: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .foto-box.has-file {
        border-color: #2eca6a !important;
        background: #f0fff5;
    }

    .foto-box.has-error {
        border-color: #dc3545 !important;
    }

    /* Upload row (STNK) */
    .upload-row.has-file {
        background: #f0fff5;
    }
</style>


<!-- =====================================================
     SCRIPT
====================================================== -->
<script>
    $(function() {

        var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        var modeUnit = null; // 'baru' | 'lama' — di-set otomatis dari tipe_pengajuan

        // ------------------------------------------------
        // Init Select2
        // ------------------------------------------------
        $('#id_kendaraan').select2({
            placeholder: 'Ketik nomor polisi atau jenis kendaraan...',
            allowClear: true,
            width: '100%',
        });

        // Select2 untuk tipe kendaraan (unit baru)
        $('#jenis_kendaraan').select2({
            placeholder: '— Pilih Tipe Unit —',
            allowClear: true,
            width: '100%',
        });

        // Select2 untuk perusahaan (unit baru)
        $('#perusahaan').select2({
            placeholder: '— Pilih atau Ketik Perusahaan —',
            allowClear: true,
            width: '100%',
            tags: true, // boleh ketik manual jika tidak ada di list
        });

        // ------------------------------------------------
        // SECTION 1: Pilih tipe_pengajuan
        // → otomatis tentukan mode unit + tampilkan section berikutnya
        // ------------------------------------------------
        $('input[name="tipe_pengajuan"]').on('change', function() {
            var tipe = $(this).val();
            modeUnit = (tipe === 'new_commissioning') ? 'baru' : 'lama';

            // Tampilkan section 2
            $('#sectionDetailUnit').slideDown(250);
            $('#sectionTujuan, #sectionPemohon, #sectionSubmit').slideDown(250);

            if (modeUnit === 'baru') {
                $('#badgeModeUnit').removeClass('bg-info').addClass('bg-warning text-dark')
                    .html('<i class="bi bi-star me-1"></i>Unit Baru');
                $('#sectionUnitBaru').slideDown(200);
                $('#sectionUnitLama').slideUp(200);
            } else {
                $('#badgeModeUnit').removeClass('bg-warning text-dark').addClass('bg-info text-white')
                    .html('<i class="bi bi-clock-history me-1"></i>Recommissioning');
                $('#sectionUnitLama').slideDown(200);
                $('#sectionUnitBaru').slideUp(200);
            }

            $('#err_tipe_pengajuan').text('');
        });

        // ------------------------------------------------
        // Auto-fill tabel info kendaraan lama
        // ------------------------------------------------
        $('#id_kendaraan').on('change', function() {
            var opt = $(this).find('option:selected');
            if (!opt.val()) {
                $('#infoKendaraanLama').slideUp(200);
                return;
            }

            var d = opt.data('json');
            if (typeof d === 'string') {
                try {
                    d = JSON.parse(d);
                } catch (e) {
                    return;
                }
            }

            $('#lama_jenis').text(d.jenis_kendaraan || '—');
            $('#lama_nomor_unit').text(d.nomor_unit || '—');
            $('#lama_merk').text(d.merk || '—');
            $('#lama_model').text(d.model_unit || d.tipe || '—');
            $('#lama_nopol').text(d.no_polisi || '—');
            $('#lama_perusahaan').text(d.perusahaan || '—');
            $('#infoKendaraanLama').slideDown(200);
            $('#err_id_kendaraan').text('');
        });

        // ------------------------------------------------
        // Char counter tujuan
        // ------------------------------------------------
        $('#tujuan').on('input', function() {
            $('#charCount').text($(this).val().length);
        });

        // ------------------------------------------------
        // UPLOAD FOTO 4 SISI — preview thumbnail + hapus
        // ------------------------------------------------
        $(document).on('change', 'input[data-fkey]', function() {
            var fkey = $(this).data('fkey');
            var file = this.files[0];
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function(e) {
                $('#fimg_' + fkey).attr('src', e.target.result);
                // nama file dipotong max 14 karakter
                var name = file.name.length > 14 ? file.name.substring(0, 12) + '…' : file.name;
                $('#fname_' + fkey).text(name);
                $('#fdefault_' + fkey).addClass('d-none');
                $('#fpreview_' + fkey).removeClass('d-none');
                $('#fbox_' + fkey).addClass('has-file').removeClass('has-error');
                $('#err_' + fkey).text('');
            };
            reader.readAsDataURL(file);
        });

        // Hapus foto — reset input + kembali ke default state
        $(document).on('click', '.btn-clear-foto', function() {
            var fkey = $(this).data('fkey');
            // Reset file input dengan kloning
            var oldInput = document.getElementById('lampiran_' + fkey);
            var newInput = oldInput.cloneNode(true);
            oldInput.parentNode.replaceChild(newInput, oldInput);

            $('#fpreview_' + fkey).addClass('d-none');
            $('#fdefault_' + fkey).removeClass('d-none');
            $('#fbox_' + fkey).removeClass('has-file');
            $('#fimg_' + fkey).attr('src', '');
        });

        // ------------------------------------------------
        // UPLOAD STNK — preview + hapus
        // ------------------------------------------------
        $('#lampiran_stnk').on('change', function() {
            var file = this.files[0];
            if (!file) return;
            $('#box_stnk').addClass('has-file');
            $('#err_stnk').text('');

            if (file.type === 'application/pdf') {
                var name = file.name.length > 20 ? file.name.substring(0, 18) + '…' : file.name;
                $('#stnk_pdf_name').text(name);
                $('#thumb_stnk').addClass('d-none');
                $('#thumb_stnk_pdf').removeClass('d-none');
            } else {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumb_stnk_img').attr('src', e.target.result);
                    $('#thumb_stnk').removeClass('d-none');
                    $('#thumb_stnk_pdf').addClass('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        // Hapus STNK
        $(document).on('click', '.btn-clear-file', function() {
            var inputId = $(this).data('input');
            var thumbId = $(this).data('thumb');
            var boxId = $(this).data('box');

            var oldInput = document.getElementById(inputId);
            var newInput = oldInput.cloneNode(true);
            oldInput.parentNode.replaceChild(newInput, oldInput);

            // Re-bind setelah clone
            $(newInput).on('change', function() {
                $('#' + inputId).trigger('change');
            });

            $('#' + thumbId).addClass('d-none');
            $('#' + boxId).removeClass('has-file');
            $('#thumb_stnk_img').attr('src', '');
        });

        // ------------------------------------------------
        // VALIDASI & SUBMIT
        // ------------------------------------------------
        $('#btnSubmit').on('click', function() {
            var errors = false;
            $('.text-danger[id^="err_"]').text('');
            $('.foto-box').removeClass('has-error');

            if (!$('input[name="tipe_pengajuan"]:checked').val()) {
                $('#err_tipe_pengajuan').text('Pilih tipe commissioning terlebih dahulu.');
                errors = true;
            }
            if (!$('input[name="tipe_akses"]:checked').val()) {
                $('#err_tipe_akses').text('Pilih tipe akses.');
                errors = true;
            }

            if (modeUnit === 'baru') {
                // Validasi select2 fields
                if (!$('#jenis_kendaraan').val()) {
                    $('#err_jenis_kendaraan').text('Tipe unit wajib dipilih.');
                    errors = true;
                }
                if (!$('#perusahaan').val()) {
                    $('#err_perusahaan').text('Perusahaan wajib dipilih.');
                    errors = true;
                }

                // Validasi text fields
                var required = {
                    nomor_unit: 'Nomor unit wajib diisi.',
                    merk: 'Merk unit wajib diisi.',
                    model_unit: 'Model unit wajib diisi.',
                    nomor_rangka_baru: 'Nomor rangka wajib diisi.',
                    nomor_mesin_baru: 'Nomor mesin wajib diisi.',
                    no_polisi: 'Nomor polisi wajib diisi.',
                    tahun: 'Tahun wajib diisi.',
                };
                $.each(required, function(id, msg) {
                    var el = document.getElementById(id);
                    if (!el) return;
                    if (!el.value.trim()) {
                        var errId = id.replace('_baru', '');
                        $('#err_' + errId).text(msg);
                        errors = true;
                    }
                });
                if (!document.getElementById('lampiran_stnk').files.length) {
                    $('#err_stnk').text('Foto STNK wajib diupload.');
                    errors = true;
                }
                ['unit_depan', 'unit_belakang', 'unit_kiri', 'unit_kanan'].forEach(function(fkey) {
                    if (!document.getElementById('lampiran_' + fkey).files.length) {
                        $('#err_' + fkey).text('Foto wajib diupload.');
                        $('#fbox_' + fkey).addClass('has-error');
                        errors = true;
                    }
                });
            } else if (modeUnit === 'lama') {
                if (!$('#id_kendaraan').val()) {
                    $('#err_id_kendaraan').text('Pilih kendaraan terlebih dahulu.');
                    errors = true;
                }
            } else {
                $('#err_tipe_pengajuan').text('Pilih tipe commissioning terlebih dahulu.');
                errors = true;
            }

            if (!$('#tujuan').val().trim()) {
                $('#err_tujuan').text('Tujuan penggunaan wajib diisi.');
                errors = true;
            }
            if (!$('#email_pemohon').val().trim()) {
                $('#err_email_pemohon').text('Email pemohon wajib diisi.');
                errors = true;
            }

            if (errors) {
                toastr.warning('Lengkapi semua field yang wajib diisi.');
                var firstErr = $('.text-danger[id^="err_"]').filter(function() {
                    return $(this).text().trim() !== '';
                }).first();
                if (firstErr.length) $('html,body').animate({
                    scrollTop: firstErr.offset().top - 130
                }, 300);
                return;
            }

            Swal.fire({
                title: 'Submit Pengajuan?',
                html: 'Pengajuan akan diteruskan ke <strong>Manager Dept</strong> untuk review dan persetujuan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4154f1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-send me-1"></i>Ya, Submit',
                cancelButtonText: 'Batal',
            }).then(function(r) {
                if (!r.isConfirmed) return;

                NProgress.start();
                $('#btnSubmit').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

                var fd = new FormData();
                fd.append(csrfName, csrfHash);
                fd.append('mode_unit', modeUnit);
                fd.append('tipe_pengajuan', $('input[name="tipe_pengajuan"]:checked').val());
                fd.append('tipe_akses', $('input[name="tipe_akses"]:checked').val());
                fd.append('tujuan', $('#tujuan').val());
                fd.append('email_pemohon', $('#email_pemohon').val());

                if (modeUnit === 'baru') {
                    fd.append('jenis_kendaraan', $('#jenis_kendaraan').val());
                    fd.append('nomor_unit', $('#nomor_unit').val());
                    fd.append('merk', $('#merk').val());
                    fd.append('model_unit', $('#model_unit').val());
                    fd.append('nomor_rangka', $('#nomor_rangka_baru').val());
                    fd.append('nomor_mesin', $('#nomor_mesin_baru').val());
                    fd.append('no_polisi', $('#no_polisi').val().toUpperCase());
                    fd.append('perusahaan', $('#perusahaan').val());
                    fd.append('tahun', $('#tahun').val());
                    ['lampiran_stnk', 'lampiran_unit_depan', 'lampiran_unit_belakang',
                        'lampiran_unit_kiri', 'lampiran_unit_kanan'
                    ].forEach(function(f) {
                        var el = document.getElementById(f);
                        if (el && el.files[0]) fd.append(f, el.files[0]);
                    });
                } else {
                    fd.append('id_kendaraan', $('#id_kendaraan').val());
                    fd.append('nomor_rangka', $('#nomor_rangka_lama').val());
                    fd.append('nomor_mesin', $('#nomor_mesin_lama').val());
                }

                $.ajax({
                    url: '<?= site_url('pengajuan/store') ?>',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        NProgress.done();
                        $('#btnSubmit').prop('disabled', false)
                            .html('<i class="bi bi-send me-1"></i>Submit Pengajuan');
                        if (res.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                html: res.message,
                                icon: 'success',
                                confirmButtonColor: '#4154f1',
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
                        $('#btnSubmit').prop('disabled', false)
                            .html('<i class="bi bi-send me-1"></i>Submit Pengajuan');
                        toastr.error('Terjadi kesalahan server.');
                    }
                });
            });
        });

    });
</script>