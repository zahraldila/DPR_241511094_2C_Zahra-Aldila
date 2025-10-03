<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('dashboard') ?>">Transparansi DPR</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUser">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navUser">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('anggota') ?>">Anggota</a></li>
      </ul>
      <a class="btn btn-outline-primary btn-sm" href="<?= base_url('logout') ?>">Logout</a>
    </div>
  </div>
</nav>
