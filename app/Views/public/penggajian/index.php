<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<h3 class="mb-3"><?= esc($title) ?></h3>

<?php if (empty($rows)): ?>
  <div class="alert alert-secondary">Belum ada data penggajian.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th style="width:140px;">Periode</th>
          <th style="width:120px;">ID Anggota</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <?php if (!empty($caps['hasKet'])): ?><th>Keterangan</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
        <tr>
          <td>
            <?php
              if (!empty($caps['hasTahun']) && !empty($caps['hasBulan']) && isset($r['bulan'], $r['tahun'])) {
                echo sprintf('%02d/%d', (int)$r['bulan'], (int)$r['tahun']);
              } elseif (!empty($caps['hasPeriode']) && isset($r['periode'])) {
                echo esc($r['periode']);
              } elseif (!empty($caps['hasTanggal']) && isset($r['tanggal'])) {
                // format tanggal kalau ada
                echo esc(date('d/m/Y', strtotime($r['tanggal'])));
              } else {
                echo '-';
              }
            ?>
          </td>
          <td><?= esc($r['id_anggota']) ?></td>
          <td><?= esc(trim($r['nama'] ?? '')) ?></td>
          <td><?= esc($r['jabatan'] ?? '') ?></td>
          <?php if (!empty($caps['hasKet'])): ?>
            <td><?= esc($r['keterangan'] ?? '') ?></td>
          <?php endif; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <nav class="mt-3">
  <?= $pagerHtml ?? '' ?>
</nav>



<?php endif; ?>

<?= $this->endSection() ?>
