<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3"><?= esc($title ?? 'Ubah Penggajian') ?></h4>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session('success')) ?></div>
<?php endif; if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>

<div class="card mb-3">
  <div class="card-body">
    <div><strong>ID Anggota:</strong> <?= esc($a['id_anggota']) ?></div>
    <div><strong>Nama:</strong>
      <?= esc(trim(($a['gelar_depan'] ? $a['gelar_depan'].' ' : '').$a['nama_depan'].' '.$a['nama_belakang'].' '.($a['gelar_belakang'] ?? ''))) ?>
    </div>
    <div><strong>Jabatan:</strong> <?= esc($a['jabatan']) ?></div>
  </div>
</div>

<form method="post" action="<?= site_url('admin/penggajian/'.$a['id_anggota'].'/update') ?>">
  <?= csrf_field() ?>
  <div id="komponenWrap" class="border rounded p-2 mb-3" style="max-height:360px; overflow:auto;">
    <?php if (empty($komponen)): ?>
      <div class="text-muted">Tidak ada komponen untuk jabatan ini.</div>
    <?php else: foreach($komponen as $k): ?>
      <?php $checked = in_array($k['id_komponen_gaji'], $existing ?? [], true); ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="komponen[]"
               value="<?= $k['id_komponen_gaji'] ?>" id="k<?= $k['id_komponen_gaji'] ?>"
               <?= $checked ? 'checked' : '' ?>>
        <label class="form-check-label" for="k<?= $k['id_komponen_gaji'] ?>">
          <strong><?= esc($k['nama_komponen']) ?></strong>
          <small class="text-muted">[<?= esc($k['kategori']) ?> • <?= esc($k['satuan']) ?>]</small>
          <small class="badge bg-light text-dark">Rp <?= number_format($k['nominal'],0,',','.') ?></small>
          <?php if ($k['kategori']==='Gaji Pokok'): ?>
            <span class="badge bg-primary">Gaji Pokok</span>
          <?php endif; ?>
        </label>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary btn-sm">Simpan Perubahan</button>
    <a class="btn btn-secondary btn-sm" href="<?= site_url('admin/penggajian') ?>">Batal</a>
  </div>
</form>

<?= $this->endSection() ?>
