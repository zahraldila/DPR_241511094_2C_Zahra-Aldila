<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3 class="mb-4"><?= esc($title) ?></h3>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>
<?php if (isset($validation)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0"><?php foreach ($validation->getErrors() as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/anggota/update/'.$row['id_anggota']) ?>" class="row g-3">
  <?= csrf_field() ?>

  <div class="col-md-3">
    <label class="form-label">Gelar Depan</label>
    <input name="gelar_depan" class="form-control" value="<?= old('gelar_depan', $row['gelar_depan'] ?? '') ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
    <input name="nama_depan" class="form-control" required value="<?= old('nama_depan', $row['nama_depan'] ?? '') ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Nama Belakang</label>
    <input name="nama_belakang" class="form-control" value="<?= old('nama_belakang', $row['nama_belakang'] ?? '') ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Gelar Belakang</label>
    <input name="gelar_belakang" class="form-control" value="<?= old('gelar_belakang', $row['gelar_belakang'] ?? '') ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label">Jabatan <span class="text-danger">*</span></label>
    <?php $jabatan = old('jabatan', $row['jabatan'] ?? ''); ?>
    <select name="jabatan" class="form-select" required>
      <option value="">-- Pilih --</option>
      <option value="Ketua"       <?= $jabatan==='Ketua'?'selected':'' ?>>Ketua</option>
      <option value="Wakil Ketua" <?= $jabatan==='Wakil Ketua'?'selected':'' ?>>Wakil Ketua</option>
      <option value="Anggota"     <?= $jabatan==='Anggota'?'selected':'' ?>>Anggota</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
    <?php $sp = old('status_pernikahan', $row['status_pernikahan'] ?? ''); ?>
    <select name="status_pernikahan" class="form-select" required>
        <option value="">-- Pilih --</option>
        <option value="Belum Kawin" <?= old('status_pernikahan', $row['status_pernikahan'] ?? '')==='Belum Kawin'?'selected':'' ?>>Belum Kawin</option>
        <option value="Kawin" <?= old('status_pernikahan', $row['status_pernikahan'] ?? '')==='Kawin'?'selected':'' ?>>Kawin</option>
        <option value="Cerai Hidup" <?= old('status_pernikahan', $row['status_pernikahan'] ?? '')==='Cerai Hidup'?'selected':'' ?>>Cerai Hidup</option>
        <option value="Cerai Mati" <?= old('status_pernikahan', $row['status_pernikahan'] ?? '')==='Cerai Mati'?'selected':'' ?>>Cerai Mati</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Jumlah Anak <span class="text-danger">*</span></label>
    <input type="number" min="0" name="jumlah_anak" class="form-control" required
           value="<?= old('jumlah_anak', $row['jumlah_anak'] ?? 0) ?>">
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/anggota') ?>" class="btn btn-outline-secondary">Batal</a>
  </div>
</form>

<?= $this->endSection() ?>
