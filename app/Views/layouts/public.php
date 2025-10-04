<!doctype html>
<html lang="id">
<head>
  <?= $this->include('layouts/_partials/head') ?>
  <title><?= esc($title ?? 'Publik') ?></title>
  <style>
    body{ background:#f4f7ff; }
    .layout{ display:flex; min-height:100vh; }
    .sidebar{ width:240px; background:#e8f0ff; padding:20px 16px; border-right:1px solid #d8e3ff; }
    .sidebar .brand{ font-weight:700; letter-spacing:.2px; color:#0a2a6b; margin-bottom:1rem; }
    .menu .nav-link{ border-radius:12px; padding:.65rem .9rem; color:#0a2a6b; }
    .menu .nav-link.active{ background:#d7e6ff; font-weight:600; }
    .content{ flex:1; display:flex; flex-direction:column; }
    .topbar{ padding:14px 20px; border-bottom:1px solid #e3ebff; background:#fff; }
    .page{ padding:28px; }
  </style>
</head>
<body>
<div class="layout">
  <!-- SIDEBAR -->
  <?= $this->include('layouts/_partials/sidebar_public') ?>

  <!-- MAIN -->
  <div class="content">
    <main class="page container-fluid">
      <?= $this->include('layouts/_partials/flash') ?>
      <?= $this->renderSection('content') ?>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
