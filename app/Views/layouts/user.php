<!doctype html>
<html lang="id">
<head>
  <?= $this->include('layouts/_partials/head') ?>
  <title>Publik • <?= esc($this->renderSection('title') ?? 'Transparansi') ?></title>
</head>
<body>
  <?= $this->include('layouts/_partials/navbar_user') ?>
  <main class="container py-4">
    <?= $this->include('layouts/_partials/flash') ?>
    <?= $this->renderSection('content') ?>
  </main>
</body>
</html>
