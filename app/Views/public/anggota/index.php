<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<h3 class="mb-3"><?= esc($title) ?></h3>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th style="width:80px;">ID</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Status</th>
          <th class="text-end">Anak</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r):
          $nama = trim(($r['gelar_depan']??'').' '.($r['nama_depan']??'').' '.($r['nama_belakang']??'').' '.($r['gelar_belakang']??''));
        ?>
        <tr>
          <td><?= esc($r['id_anggota']) ?></td>
          <td><?= esc($nama) ?></td> <!-- BUKAN link lagi -->
          <td><?= esc($r['jabatan']) ?></td>
          <td><?= esc($r['status_pernikahan']) ?></td>
          <td class="text-end"><?= esc($r['jumlah_anak']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <nav class="mt-3">
    <?= $pager->only(['q'])->links('anggota', 'bs_full') ?>
  </nav>
<?= $this->endSection() ?>
