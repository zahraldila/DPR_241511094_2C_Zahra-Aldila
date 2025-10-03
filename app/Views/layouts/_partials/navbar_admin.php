<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navAdmin">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/dashboard') ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/anggota') ?>">Anggota</a></li>
      </ul>
      <a class="btn btn-outline-light btn-sm" href="<?= base_url('logout') ?>">Logout</a>
    </div>
  </div>
</nav>
