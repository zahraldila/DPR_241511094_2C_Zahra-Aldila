// app/Views/admin/komponen/create.php
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Tambah Komponen Gaji &amp; Tunjangan</h4>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/komponen/store') ?>">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Nama Komponen</label>
    <input type="text" class="form-control" name="nama_komponen" value="<?= old('nama_komponen') ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select class="form-select" name="kategori" required>
      <option value="">- pilih -</option>
      <option <?= old('kategori')==='Gaji Pokok'?'selected':'' ?>>Gaji Pokok</option>
      <option <?= old('kategori')==='Tunjangan Melekat'?'selected':'' ?>>Tunjangan Melekat</option>
      <option <?= old('kategori')==='Tunjangan'?'selected':'' ?>>Tunjangan</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Jabatan</label>
    <select class="form-select" name="jabatan" required>
      <option value="">- pilih -</option>
      <option <?= old('jabatan')==='Ketua'?'selected':'' ?>>Ketua</option>
      <option <?= old('jabatan')==='Wakil Ketua'?'selected':'' ?>>Wakil Ketua</option>
      <option <?= old('jabatan')==='Anggota'?'selected':'' ?>>Anggota</option>
      <option <?= old('jabatan')==='Semua'?'selected':'' ?>>Semua</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Nominal</label>
    <input type="number" class="form-control" name="nominal" min="0" step="1" value="<?= old('nominal') ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Satuan</label>
    <select class="form-select" name="satuan" required>
      <option value="">- pilih -</option>
      <option <?= old('satuan')==='Bulan'?'selected':'' ?>>Bulan</option>
      <option <?= old('satuan')==='Hari'?'selected':'' ?>>Hari</option>
      <option <?= old('satuan')==='Periode'?'selected':'' ?>>Periode</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/komponen') ?>" class="btn btn-light">Batal</a>
</form>

<?= $this->endSection() ?>
