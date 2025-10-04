<?php
$uri = service('uri');
$seg1 = $uri->getSegment(1) ?? '';
$seg2 = $uri->getSegment(2) ?? '';

function isActive($paths) {
  $cur = current_url();
  foreach ($paths as $p) { if (strpos($cur, base_url($p)) === 0) return 'active'; }
  return '';
}

$nama  = trim((string) (session('nama') ?? session('username') ?? ''));
?>
<aside class="sidebar">
  <div class="brand mb-3">Perhitungan Gaji DPR</div>

<span class="text-primary fw-bold">
  <i class="bi bi-person-badge me-1"></i> Public — <?= esc($nama) ?>
</span>



  <nav class="menu nav flex-column gap-1 my-3">
    <a class="nav-link <?= isActive(['public/dashboard']) ?>"
       href="<?= base_url('public/dashboard') ?>">
      <i class="bi bi-house-door me-2"></i> Home
    </a>

    <a class="nav-link <?= isActive(['public/anggota']) ?>"
        href="<?= base_url('public/anggota') ?>">
        <i class="bi bi-people me-2"></i> Anggota DPR
    </a>

    <?php /* Jika mau expose komponen secara read-only untuk publik, buka ini:
    <a class="nav-link <?= isActive(['public/komponen']) ?>"
       href="<?= base_url('public/komponen') ?>">
      <i class="bi bi-wallet2 me-2"></i> Komponen Gaji & Tunjangan
    </a>
    */ ?>

    <a class="nav-link <?= isActive(['public/penggajian']) ?>"
       href="<?= base_url('public/penggajian') ?>">
      <i class="bi bi-camera me-2"></i> Penggajian
    </a>
  </nav>

  <div class="mt-auto pt-3">
    <a class="btn btn-outline-primary w-100" href="<?= base_url('logout') ?>">
      <i class="bi bi-box-arrow-right me-1"></i> Logout
    </a>
  </div>
</aside>
