<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
  <h4 class="mb-3">User Dashboard</h4>
  <div class="card">
    <div class="card-body">
      <p>Halo, <?= esc(session('full_name')) ?>. Ini area user.</p>
      <ul class="mb-0">
        <li>Lihat daftar courses (nanti)</li>
        <li>Enroll course (nanti)</li>
      </ul>
    </div>
  </div>
<?= $this->endSection() ?>
