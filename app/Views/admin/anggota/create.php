<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">Tambah Anggota DPR</h3>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>

<?php if (isset($validation)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($validation->getErrors() as $e): ?>
        <li><?= esc($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/anggota/store') ?>" class="row g-3">
  <?= csrf_field() ?>

  <div class="col-md-3">
    <label class="form-label">Gelar Depan</label>
    <input name="gelar_depan" class="form-control" value="<?= old('gelar_depan') ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
    <input name="nama_depan" class="form-control" required value="<?= old('nama_depan') ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Nama Belakang</label>
    <input name="nama_belakang" class="form-control" value="<?= old('nama_belakang') ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Gelar Belakang</label>
    <input name="gelar_belakang" class="form-control" value="<?= old('gelar_belakang') ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label">Jabatan <span class="text-danger">*</span></label>
    <select name="jabatan" class="form-select" required>
      <option value="">-- Pilih --</option>
      <option <?= old('jabatan')==='Ketua'?'selected':'' ?>>Ketua</option>
      <option <?= old('jabatan')==='Wakil Ketua'?'selected':'' ?>>Wakil Ketua</option>
      <option <?= old('jabatan')==='Anggota'?'selected':'' ?>>Anggota</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
    <select name="status_pernikahan" class="form-select" required>
      <option value="">-- Pilih --</option>
      <option <?= old('status_pernikahan')==='Belum Kawin'?'selected':'' ?>>Belum Kawin</option>
      <option <?= old('status_pernikahan')==='Kawin'?'selected':'' ?>>Kawin</option>
      <option <?= old('status_pernikahan')==='Cerai'?'selected':'' ?>>Cerai</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Jumlah Anak <span class="text-danger">*</span></label>
    <input type="number" min="0" name="jumlah_anak" class="form-control"
           value="<?= old('jumlah_anak', 0) ?>" required>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/anggota') ?>" class="btn btn-outline-secondary">Batal</a>
  </div>
</form>

<?= $this->endSection() ?>
