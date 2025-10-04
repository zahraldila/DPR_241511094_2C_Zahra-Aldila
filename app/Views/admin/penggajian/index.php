<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Data Penggajian</h4>
<div class="d-flex align-items-center justify-content-between mb-3">
  <form class="d-flex" method="get" action="<?= site_url('admin/penggajian') ?>" style="max-width:520px; width:100%;">
    <input type="text" class="form-control me-2" name="q"
           placeholder="Cari"
           value="<?= esc($q ?? '') ?>">

    <button class="btn btn-outline-secondary me-2" type="submit">Cari</button>

    <?php if (!empty($q)): ?>
      <a class="btn btn-outline-danger" href="<?= site_url('admin/penggajian') ?>">Reset</a>
    <?php endif; ?>
  </form>

  <a class="btn btn-primary ms-3" href="<?= site_url('admin/penggajian/create') ?>">
    + Tambah Komponen
  </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session('success')) ?></div>
<?php endif; if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>


<div class="table-responsive">
  <table class="table table-sm table-striped align-middle">
    <thead>
      <tr>
        <th>ID Anggota</th>
        <th>Gelar Depan</th>
        <th>Nama Depan</th>
        <th>Nama Belakang</th>
        <th>Gelar Belakang</th>
        <th>Jabatan</th>
        <th class="text-end">THP (Bulanan)</th>
        <th class="text-center" style="width:140px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr>
      <?php else: foreach ($rows as $r): ?>
        <tr>
          <td><?= esc($r['id_anggota']) ?></td>
          <td><?= esc($r['gelar_depan']) ?></td>
          <td><?= esc($r['nama_depan']) ?></td>
          <td><?= esc($r['nama_belakang']) ?></td>
          <td><?= esc($r['gelar_belakang']) ?></td>
          <td><?= esc($r['jabatan']) ?></td>
          <td class="text-end"><?= number_format($r['thp'], 0, ',', '.') ?></td>
          <td class="text-center">
            <a class="btn btn-warning btn-sm" href="<?= site_url('admin/penggajian/'.$r['id_anggota'].'/edit') ?>">Ubah</a>
            <!-- Detail/Hapus nanti -->
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<small class="text-muted d-block mt-2">
  THP = Total Komponen Bulanan + Tunjangan Pasangan (jika Kawin) + Tunjangan Anak (maks 2 anak).
</small>

<?= $this->endSection() ?>
