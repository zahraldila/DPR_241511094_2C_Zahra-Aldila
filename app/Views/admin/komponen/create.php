<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3>Tambah Komponen Gaji & Tunjangan</h3>

<form method="post" action="<?= site_url('admin/komponen/store') ?>">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Nama Komponen</label>
    <input type="text" class="form-control" name="nama_komponen" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select class="form-select" name="kategori" required>
      <option value="">- pilih -</option>
      <option>Gaji Pokok</option>
      <option>Tunjangan Melekat</option>
      <option>Tunjangan</option>
      <!-- tambah opsi lain kalau enum kamu lebih lengkap -->
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Jabatan</label>
    <select class="form-select" name="jabatan" required>
      <option value="">- pilih -</option>
      <option>Semua</option>
      <option>Anggota</option>
      <option>Wakil Ketua</option>
      <option>Ketua</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Nominal</label>
    <input type="number" class="form-control" name="nominal" min="0" step="1" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Satuan</label>
    <select class="form-select" name="satuan" required>
      <option value="">- pilih -</option>
      <option>Bulan</option>
      <option>Hari</option>
      <option>Periode</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>


<?= $this->endSection() ?>
