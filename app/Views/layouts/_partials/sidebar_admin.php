<?php
helper('url');
function active($pattern){ return url_is($pattern) ? 'active' : ''; }
?>
<aside class="sidebar">
  <div class="brand">UTS Proyek3</div>

  <nav class="menu nav flex-column gap-1">
    <a class="nav-link <?= active('admin/dashboard') ?>" href="<?= base_url('admin/dashboard') ?>">
      <i class="bi bi-house me-2"></i> Home
    </a>

    <a class="nav-link <?= active('admin/anggota*') ?>" href="<?= base_url('admin/anggota') ?>">
      <i class="bi bi-people me-2"></i> Anggota DPR
    </a>

    <a class="nav-link <?= active('admin/komponen*') ?>" href="<?= base_url('admin/komponen') ?>">
      <i class="bi bi-cash-coin me-2"></i> Komponen Gaji &amp; Tunjangan
    </a>
  </nav>

  <div class="mt-auto pt-4">
    <a class="btn btn-outline-primary w-100" href="<?= base_url('logout') ?>">
      <i class="bi bi-box-arrow-right me-1"></i> Logout
    </a>
  </div>
</aside>
