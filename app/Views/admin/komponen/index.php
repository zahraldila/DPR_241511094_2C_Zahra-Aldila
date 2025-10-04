<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Komponen Gaji &amp; Tunjangan</h4>
  <a class="btn btn-primary" href="<?= site_url('admin/komponen/create') ?>">+ Tambah Komponen</a>
</div>

<?php if (session()->getFlashdata('message')): ?>
  <div class="alert alert-success py-2 small"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-striped table-hover mb-0 align-middle">
    <thead class="table-light">
      <tr>
        <th style="width:120px">ID Komponen</th>
        <th>Nama Komponen</th>
        <th>Kategori</th>
        <th>Jabatan</th>
        <th class="text-end">Nominal</th>
        <th>Satuan</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
      <tr><td colspan="6" class="text-center py-4">Belum ada data.</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= esc($r['id_komponen_gaji']) ?></td>
          <td><?= esc($r['nama_komponen']) ?></td>
          <td><?= esc($r['kategori']) ?></td>
          <td><?= esc($r['jabatan']) ?></td>
          <td class="text-end"><?= number_format((float)$r['nominal'], 0, ',', '.') ?></td>
          <td><?= esc($r['satuan']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
