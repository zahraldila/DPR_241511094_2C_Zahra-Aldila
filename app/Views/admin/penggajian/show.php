<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3"><?= esc($title ?? 'Detail Penggajian') ?></h4>

<div class="card mb-3">
  <div class="card-body">
    <div><strong>ID Anggota:</strong> <?= esc($a['id_anggota']) ?></div>
    <div><strong>Nama:</strong>
      <?= esc(trim(($a['gelar_depan'] ? $a['gelar_depan'].' ' : '').$a['nama_depan'].' '.$a['nama_belakang'].' '.($a['gelar_belakang'] ?? ''))) ?>
    </div>
    <div><strong>Jabatan:</strong> <?= esc($a['jabatan']) ?></div>
    <div><strong>Status:</strong> <?= esc($a['status_pernikahan']) ?> | <strong>Anak:</strong> <?= esc($a['jumlah_anak']) ?></div>
  </div>
</div>

<div class="table-responsive mb-3">
  <table class="table table-sm table-striped align-middle">
    <thead>
      <tr>
        <th>Komponen</th>
        <th>Kategori</th>
        <th>Satuan</th>
        <th class="text-end">Nominal</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($detail)): ?>
        <tr><td colspan="4" class="text-center text-muted">Belum ada komponen.</td></tr>
      <?php else: foreach ($detail as $d): ?>
        <tr>
          <td><?= esc($d['nama_komponen']) ?></td>
          <td><?= esc($d['kategori']) ?></td>
          <td><?= esc($d['satuan']) ?></td>
          <td class="text-end">Rp <?= number_format($d['nominal'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<div class="card">
  <div class="card-body">
    <div><strong>Total Komponen (bulanan):</strong> Rp <?= number_format($ringkasan['plus_bln'], 0, ',', '.') ?></div>
    <div><strong>Gaji Pokok (bulanan):</strong> Rp <?= number_format($ringkasan['gaji_pokok_bln'], 0, ',', '.') ?></div>
    <div><strong>Tunjangan Pasangan:</strong> Rp <?= number_format($ringkasan['tunj_pasangan'], 0, ',', '.') ?></div>
    <div><strong>Tunjangan Anak:</strong> Rp <?= number_format($ringkasan['tunj_anak'], 0, ',', '.') ?></div>
    <hr class="my-2">
    <div><strong>Take Home Pay (Bulanan):</strong> Rp <?= number_format($ringkasan['thp'], 0, ',', '.') ?></div>
  </div>
</div>

<div class="mt-3 d-flex gap-2">
  <a class="btn btn-secondary btn-sm" href="<?= site_url('admin/penggajian') ?>">Kembali</a>
  <a class="btn btn-warning btn-sm" href="<?= site_url('admin/penggajian/'.$a['id_anggota'].'/edit') ?>">Ubah</a>
</div>

<?= $this->endSection() ?>
