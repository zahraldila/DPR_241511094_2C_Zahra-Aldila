<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">Dashboard Publik</h3>

<div class="row g-4 mb-4">
  <div class="col-md-6">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="text-muted small">Total Anggota</div>
        <div class="fs-3 fw-bold"><?= (int)($stats['anggota'] ?? 0) ?></div>
        <a href="<?= base_url('public/anggota') ?>" class="btn btn-sm btn-primary mt-2">
          <i class="bi bi-people me-1"></i> Lihat Anggota
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="text-muted small">Data Penggajian</div>
        <div class="fs-3 fw-bold"><?= (int)($stats['penggajian'] ?? 0) ?></div>
        <a href="<?= base_url('public/penggajian') ?>" class="btn btn-sm btn-primary mt-2">
          <i class="bi bi-cash-stack me-1"></i> Lihat Penggajian
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
