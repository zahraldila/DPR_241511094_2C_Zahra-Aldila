<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">Admin Dashboard</h3>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="text-muted small">Total Anggota</div>
        <div class="fs-3 fw-bold"><?= (int)($stats['anggota'] ?? 0) ?></div>
        <a href="<?= base_url('admin/anggota') ?>" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
      </div>
    </div>
  </div>

  <?php if (array_key_exists('komponen', $stats)): ?>
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="text-muted small">Komponen Gaji</div>
        <div class="fs-3 fw-bold"><?= (int)($stats['komponen'] ?? 0) ?></div>
        <a href="<?= base_url('admin/komponen') ?>" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <?php if (array_key_exists('penggajian', $stats)): ?>
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="text-muted small">Data Penggajian</div>
        <div class="fs-3 fw-bold"><?= (int)($stats['penggajian'] ?? 0) ?></div>
        <a href="<?= base_url('admin/penggajian') ?>" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Quick actions -->
<div class="card border-0 shadow-sm">
  <div class="card-body d-flex flex-wrap gap-2">
    <a class="btn btn-primary" href="<?= base_url('admin/anggota/create') ?>">
      <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
    </a>
    <a class="btn btn-outline-secondary" href="<?= base_url('admin/anggota') ?>">
      <i class="bi bi-people me-1"></i> Kelola Anggota
    </a>
    <!-- tombol lain nanti setelah fitur ada -->
  </div>
</div>

<?= $this->endSection() ?>
