<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('public/penggajian') ?>" class="btn btn-sm btn-outline-secondary mb-3">← Kembali</a>
<h3 class="mb-3"><?= esc($title) ?></h3>

<div class="card mb-3">
  <div class="card-body">
    <div><strong>Periode:</strong> <?= sprintf('%02d/%d', (int)$header['bulan'], (int)$header['tahun']) ?></div>
    <div><strong>ID Anggota:</strong> <?= esc($header['id_anggota']) ?></div>
    <div><strong>Nama:</strong> <?= esc(trim($header['nama'])) ?></div>
    <div><strong>Jabatan:</strong> <?= esc($header['jabatan']) ?></div>
    <div><strong>Keterangan:</strong> <?= esc($header['keterangan'] ?? '') ?></div>
  </div>
</div>

<?php if (!empty($detail)): ?>
  <h5 class="mb-2">Rincian (jika tersedia)</h5>
  <div class="table-responsive">
    <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th>ID Detail</th>
          <th>ID Komponen</th>
          <th class="text-end">Nominal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detail as $d): ?>
        <tr>
          <td><?= esc($d['id_detail']) ?></td>
          <td><?= esc($d['id_komponen_gaji']) ?></td>
          <td class="text-end"><?= number_format((float)($d['nominal'] ?? 0), 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <div class="alert alert-info">Rincian komponen belum tersedia atau tabel <code>penggajian_detail</code> tidak ada.</div>
<?php endif; ?>

<?= $this->endSection() ?>
