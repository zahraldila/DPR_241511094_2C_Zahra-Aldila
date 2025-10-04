<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Data Penggajian</h4>
<div class="d-flex align-items-center justify-content-between mb-3">
  <form class="d-flex" method="get" action="<?= site_url('admin/penggajian') ?>" style="max-width:520px; width:100%;">
    <input type="text" class="form-control me-2" name="q"
           placeholder="Cari"
           value="<?= esc($q ?? '') ?>">

    <button class="btn btn-outline-secondary me-2" type="submit">Cari</button>

    <?php if (!empty($q)): ?>
      <a class="btn btn-outline-danger" href="<?= site_url('admin/penggajian') ?>">Reset</a>
    <?php endif; ?>
  </form>

  <a class="btn btn-primary ms-3" href="<?= site_url('admin/penggajian/create') ?>">
    + Tambah Komponen
  </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session('success')) ?></div>
<?php endif; if (session()->getFlashdata('error')): ?>
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
        <th class="text-center" style="width:140px">Aksi</th>
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
            <a class="btn btn-warning btn-sm" href="<?= site_url('admin/penggajian/'.$r['id_anggota'].'/edit') ?>">Ubah</a>
            <button
                type="button"
                class="btn btn-danger btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalHapus"
                data-id="<?= $r['id_anggota'] ?>"
                data-nama="<?= esc(trim(($r['gelar_depan'] ? $r['gelar_depan'].' ' : '').$r['nama_depan'].' '.$r['nama_belakang'].' '.($r['gelar_belakang'] ?? ''))) ?>">
                Hapus
            </button>
            </td>
            </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<small class="text-muted d-block mt-2">
  THP = Total Komponen Bulanan + Tunjangan Pasangan (jika Kawin) + Tunjangan Anak (maks 2 anak).
</small>

<!-- Modal Hapus (tengah layar, gaya seperti di halaman Komponen) -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"><!-- ini yang bikin modal di tengah -->
    <form method="post" id="formHapus">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold" id="modalHapusLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p class="mb-1">
            Hapus semua komponen penggajian untuk anggota <strong class="target-nama text-dark"></strong>?
          </p>
          <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modalEl = document.getElementById('modalHapus');
  modalEl.addEventListener('show.bs.modal', function (ev) {
    const btn  = ev.relatedTarget;
    const id   = btn.getAttribute('data-id');
    const nama = btn.getAttribute('data-nama') || '';
    modalEl.querySelector('.target-nama').textContent = `#${id} ${nama}`.trim();
    const form = document.getElementById('formHapus');
    form.action = "<?= site_url('admin/penggajian') ?>/" + id + "/delete";
  });
});
</script>


<?= $this->endSection() ?>
