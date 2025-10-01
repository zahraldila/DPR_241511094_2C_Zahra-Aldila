<?= $this->extend('layouts/main') /* atau 'layout' sesuai punyamu */ ?>
<?= $this->section('content') ?>

<h3 class="mb-3"><?= esc($title) ?></h3>

<form action="/admin/anggota" method="post" class="row g-3 needs-validation" novalidate>
  <?= csrf_field() ?>

  <div class="col-md-3">
    <label class="form-label">Gelar Depan</label>
    <input type="text" name="gelar_depan" class="form-control" value="<?= old('gelar_depan') ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
    <input required type="text" name="nama_depan" class="form-control" value="<?= old('nama_depan') ?>">
    <div class="invalid-feedback">Wajib diisi.</div>
  </div>
  <div class="col-md-3">
    <label class="form-label">Nama Belakang</label>
    <input type="text" name="nama_belakang" class="form-control" value="<?= old('nama_belakang') ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Gelar Belakang</label>
    <input type="text" name="gelar_belakang" class="form-control" value="<?= old('gelar_belakang') ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label">Jabatan <span class="text-danger">*</span></label>
    <select required class="form-select" name="jabatan">
      <option value="" disabled selected>-- Pilih --</option>
      <option <?= old('jabatan')==='Ketua'?'selected':'' ?>>Ketua</option>
      <option <?= old('jabatan')==='Wakil Ketua'?'selected':'' ?>>Wakil Ketua</option>
      <option <?= old('jabatan')==='Anggota'?'selected':'' ?>>Anggota</option>
    </select>
    <div class="invalid-feedback">Pilih jabatan.</div>
  </div>

  <div class="col-md-4">
    <label class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
    <select required class="form-select" name="status_pernikahan">
      <option value="" disabled selected>-- Pilih --</option>
      <option <?= old('status_pernikahan')==='Belum Kawin'?'selected':'' ?>>Belum Kawin</option>
      <option <?= old('status_pernikahan')==='Kawin'?'selected':'' ?>>Kawin</option>
    </select>
    <div class="invalid-feedback">Pilih status.</div>
  </div>

  <div class="col-12 d-flex gap-2">
    <button class="btn btn-primary">Simpan</button>
    <a href="/admin/anggota" class="btn btn-secondary">Batal</a>
  </div>
</form>

<script>
// bootstrap client-side validation
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<?= $this->endSection() ?>
