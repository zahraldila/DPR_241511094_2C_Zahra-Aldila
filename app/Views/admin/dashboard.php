<?= $this->extend('layouts/main') ?>

<?= $this->section('page_head_left') ?>
  <h4>Admin Dashboard</h4>
  <div class="search-wrap">
    <i class="bi bi-search"></i>
    <input type="text" class="form-control" placeholder="Search...">
  </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <!-- konten dashboard di sini -->
<?= $this->endSection() ?>
