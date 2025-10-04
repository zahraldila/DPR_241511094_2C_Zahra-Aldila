<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Ubah Komponen Gaji &amp; Tunjangan</h4>

<?php if ($err = session()->getFlashdata('error')): ?>
  <div class="alert alert-danger py-2 small"><?= esc($err) ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/komponen/update/'.$row['id_komponen_gaji']) ?>">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Nama Komponen</label>
    <input type="text" class="form-control" name="nama_komponen"
           value="<?= old('nama_komponen', $row['nama_komponen']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select class="form-select" name="kategori" required>
      <option value="">- pilih -</option>
      <?php foreach($optKategori as $opt): ?>
        <option value="<?= esc($opt) ?>" <?= old('kategori',$row['kategori'])===$opt?'selected':'' ?>>
          <?= esc($opt) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Jabatan</label>
    <select class="form-select" name="jabatan" required>
      <option value="">- pilih -</option>
      <?php foreach($optJabatan as $opt): ?>
        <option value="<?= esc($opt) ?>" <?= old('jabatan',$row['jabatan'])===$opt?'selected':'' ?>>
          <?= esc($opt) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Nominal</label>
    <input type="number" class="form-control" name="nominal" min="0" step="1"
           value="<?= old('nominal', $row['nominal']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Satuan</label>
    <select class="form-select" name="satuan" required>
      <option value="">- pilih -</option>
      <?php foreach($optSatuan as $opt): ?>
        <option value="<?= esc($opt) ?>" <?= old('satuan',$row['satuan'])===$opt?'selected':'' ?>>
          <?= esc($opt) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
  <a href="<?= site_url('admin/komponen') ?>" class="btn btn-light">Batal</a>
</form>

<?= $this->endSection() ?>
