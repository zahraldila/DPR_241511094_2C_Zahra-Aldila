<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>


<h4 class="mb-3">Data Anggota DPR</h4>
<div class="d-flex align-items-center justify-content-between mb-3">
  <form class="d-flex" method="get" action="<?= site_url('admin/anggota') ?>" style="max-width:520px; width:100%;">
    <input type="text" class="form-control me-2" name="q"
           placeholder="Cari"
           value="<?= esc($q ?? '') ?>">

    <button class="btn btn-outline-secondary me-2" type="submit">Cari</button>

    <?php if (!empty($q)): ?>
      <a class="btn btn-outline-danger" href="<?= site_url('admin/anggota') ?>">Reset</a>
    <?php endif; ?>
  </form>

  <a class="btn btn-primary ms-3" href="<?= site_url('admin/anggota/create') ?>">
    + Tambah Komponen
  </a>
</div>

<div class="card">
  <div class="card-body p-0">
    <?= view('components/anggota/table', [
        'rows' => $rows,
        'showActions' => true,              // admin punya tombol aksi
        'baseUrl' => $baseUrl               // biasanya '/admin/anggota'
    ]) ?>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <small class="text-muted">Total: <?= number_format($total) ?> data</small>
    <div><?= $pagerHtml ?></div>
  </div>
</div>

<?= $this->endSection() ?>
