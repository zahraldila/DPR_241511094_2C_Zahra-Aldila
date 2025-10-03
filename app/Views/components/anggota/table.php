<?php
// butuh: $rows, $showActions (bool), $baseUrl
?>
<div class="table-responsive">
  <table class="table table-striped table-hover mb-0 align-middle">
    <thead class="table-light">
      <tr>
        <th style="width:80px;">ID</th>
        <th>Nama Lengkap</th>
        <th>Jabatan</th>
        <th>Status Pernikahan</th>
        <th>Jumlah Anak</th>
        <?php if (!empty($showActions)): ?>
          <th style="width:160px;" class="text-center">Aksi</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
      <tr><td colspan="<?= !empty($showActions)?6:5 ?>" class="text-center py-4">Tidak ada data.</td></tr>
      <?php else: foreach ($rows as $r):
        $nama = trim(($r['gelar_depan']? $r['gelar_depan'].' ' : '')
          . $r['nama_depan'].' '
          . ($r['nama_belakang']? $r['nama_belakang'].' ' : '')
          . ($r['gelar_belakang']? $r['gelar_belakang'] : ''));
      ?>
      <tr>
        <td><?= esc($r['id_anggota']) ?></td>
        <td><?= esc($nama) ?></td>
        <td><?= esc($r['jabatan']) ?></td>
        <td><?= esc($r['status_pernikahan']) ?></td>
        <td><?= esc($r['jumlah_anak']) ?></td>
        <?php if (!empty($showActions)): ?>
        <td class="text-center">
          <a href="<?= $baseUrl.'/edit/'.$r['id_anggota'] ?>" class="btn btn-sm btn-warning">Ubah</a>
          <a href="<?= $baseUrl.'/delete/'.$r['id_anggota'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
        </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
