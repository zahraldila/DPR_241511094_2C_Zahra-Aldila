<?php $role = session('role') ?? 'user'; $uname = session('username') ?? ''; ?>
<header class="topbar d-flex align-items-center justify-content-between bg-white">
  <form class="d-none d-md-block" role="search" style="max-width:520px;width:100%;">
    <div class="input-group">
      <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
      <input class="form-control" placeholder="Search..." />
    </div>
  </form>
  <div class="small text-muted">
    <i class="bi bi-person-circle me-1"></i> (<?= esc($role) ?>) <?= esc($uname) ?>
  </div>
</header>
