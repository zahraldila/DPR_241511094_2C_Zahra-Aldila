<div class="container py-4">
  <a href="<?= base_url('public/anggota') ?>" class="btn btn-sm btn-outline-secondary mb-3">← Kembali</a>
  <h2 class="h5 mb-3">
    <?= esc(trim(($row['gelar_depan'] ?? '').' '.($row['nama_depan'] ?? '').' '.($row['nama_belakang'] ?? '').' '.($row['gelar_belakang'] ?? ''))) ?>
  </h2>

  <dl class="row">
    <dt class="col-sm-3">Jabatan</dt><dd class="col-sm-9"><?= esc($row['jabatan']) ?></dd>
    <dt class="col-sm-3">Status Pernikahan</dt><dd class="col-sm-9"><?= esc($row['status_pernikahan']) ?></dd>
    <dt class="col-sm-3">Jumlah Anak</dt><dd class="col-sm-9"><?= esc($row['jumlah_anak']) ?></dd>
  </dl>
</div>
