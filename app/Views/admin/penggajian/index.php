<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3"><?= esc($title ?? 'Daftar Penggajian') ?></h4>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>


<div class="table-responsive">
  <table class="table table-sm table-striped align-middle">
    <thead>
      <tr>
        <th>ID Anggota</th>
        <th>Gelar Depan</th>
        <th>Nama Depan</th>
        <th>Nama Belakang</th>
        <th>Gelar Belakang</th>
        <th>Jabatan</th>
        <th class="text-end">THP (Bulanan)</th>
        <th class="text-center" style="width:160px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr>
      <?php else: foreach ($rows as $r): ?>
        <tr>
          <td><?= esc($r['id_anggota']) ?></td>
          <td><?= esc($r['gelar_depan']) ?></td>
          <td><?= esc($r['nama_depan']) ?></td>
          <td><?= esc($r['nama_belakang']) ?></td>
          <td><?= esc($r['gelar_belakang']) ?></td>
          <td><?= esc($r['jabatan']) ?></td>
          <td class="text-end"><?= number_format($r['thp'], 0, ',', '.') ?></td>
          <td class="text-center">
            <!-- tombol Tambah akan buka halaman create dengan id_anggota terpilih -->
            <a class="btn btn-sm btn-primary" href="<?= site_url('admin/penggajian/create?id_anggota='.$r['id_anggota']) ?>">Tambah</a>
            <!-- nanti kita tambahkan Detail/Ubah/Hapus di step berikut -->
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<small class="text-muted d-block mt-2">
  THP = (Total Tambahan Bulanan − Total Potongan Bulanan) + Tunjangan Pasangan (jika Kawin) + Tunjangan Anak (maks 2 anak).
</small>

<?= $this->endSection() ?>
