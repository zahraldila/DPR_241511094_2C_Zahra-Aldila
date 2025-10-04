<?php $role = session('role') ?? 'user'; $uname = session('username') ?? ''; ?>
<header class="topbar d-flex align-items-center justify-content-between bg-white">
  <div class="small text-muted">
    <i class="bi bi-person-circle me-1"></i> (<?= esc($role) ?>) <?= esc($uname) ?>
  </div>
</header>
