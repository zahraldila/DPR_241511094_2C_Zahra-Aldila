<?= $this->extend('layouts/main.php') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><?= esc($title) ?></h3>
  <a href="/admin/anggota/new" class="btn btn-primary">Tambah</a>
</div>

<form class="row g-2 mb-3" method="get">
  <div class="col-sm-4">
    <input class="form-control" name="q" value="<?= esc($q) ?>" placeholder="Cari id/nama/jabatan...">
  </div>
  <div class="col-auto">
    <button class="btn btn-outline-secondary">Search</button>
    <a class="btn btn-outline-dark" href="/admin/anggota">Reset</a>
  </div>
</form>

<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>ID Anggota</th>
      <th>Gelar Depan</th>
      <th>Nama Depan</th>
      <th>Nama Belakang</th>
      <th>Gelar Belakang</th>
      <th>Jabatan</th>
      <th>Status Pernikahan</th>
      <th style="width: 120px;">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($records)): ?>
      <tr><td colspan="9" class="text-center text-muted">Belum ada data.</td></tr>
    <?php else: foreach ($records as $r): ?>
      <tr>
        <td><?= esc($r['id_anggota']) ?></td>
        <td><?= esc($r['gelar_depan']) ?></td>
        <td><?= esc($r['nama_depan']) ?></td>
        <td><?= esc($r['nama_belakang']) ?></td>
        <td><?= esc($r['gelar_belakang']) ?></td>
        <td><?= esc($r['jabatan']) ?></td>
        <td><?= esc($r['status_pernikahan']) ?></td>
        <td>
          <a href="/admin/anggota/<?= $r['id_anggota'] ?>/edit" class="btn btn-sm btn-warning disabled">Edit</a>
          <button class="btn btn-sm btn-danger" disabled>Hapus</button>
        </td>
      </tr>
    <?php endforeach; endif; ?>
  </tbody>
</table>
</div>

<div><?= $pager->links() ?></div>

<?= $this->endSection() ?>
