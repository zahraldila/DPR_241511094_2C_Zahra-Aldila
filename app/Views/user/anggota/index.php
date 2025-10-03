<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<h4 class="mb-3"><?= esc($title) ?></h4>

<form class="row g-2 mb-3" method="get" action="<?= current_url() ?>">
  <div class="col-sm-8 col-md-6">
    <input type="text" name="q" class="form-control" value="<?= esc($q ?? '') ?>" placeholder="Cari ID/nama/jabatan...">
  </div>
  <div class="col-auto"><button class="btn btn-outline-secondary">Cari</button></div>
  <?php if (!empty($q)): ?><div class="col-auto"><a class="btn btn-outline-danger" href="<?= base_url('anggota') ?>">Reset</a></div><?php endif; ?>
</form>

<div class="card">
  <div class="card-body p-0">
    <?= view('components/anggota/table', [
        'rows' => $rows,
        'showActions' => false,             // user read-only
        'baseUrl' => $baseUrl               // biasanya '/anggota'
    ]) ?>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <small class="text-muted">Total: <?= number_format($total) ?> data</small>
    <div><?= $pagerHtml ?></div>
  </div>
</div>

<?= $this->endSection() ?>
