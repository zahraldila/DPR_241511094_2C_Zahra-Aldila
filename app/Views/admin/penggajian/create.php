// app/Views/admin/penggajian/create.php
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Tambah Penggajian</h4>

<form class="row gy-2 gx-2 align-items-end mb-3" method="get" action="<?= site_url('admin/penggajian/create') ?>">
  <div class="col-md-6">
    <label class="form-label">Pilih Anggota</label>
    <select name="id_anggota" class="form-select" onchange="this.form.submit()">
      <option value="">- pilih -</option>
      <?php foreach($anggotaOptions as $a):
        $nama = trim(($a['gelar_depan']? $a['gelar_depan'].' ' : '')
          . $a['nama_depan'].' '.($a['nama_belakang']? $a['nama_belakang'] : '')
          . ($a['gelar_belakang']? ', '.$a['gelar_belakang'] : ''));
      ?>
        <option value="<?= $a['id_anggota'] ?>" <?= (int)$selectedId === (int)$a['id_anggota'] ? 'selected':'' ?>>
          [<?= $a['id_anggota'] ?>] <?= esc($nama) ?> — <?= esc($a['jabatan']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</form>

<?php if ($anggota): ?>
  <form method="post" action="<?= site_url('admin/penggajian/store') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id_anggota" value="<?= (int)$anggota['id_anggota'] ?>">

<!-- Toolbar select-all -->
<div class="d-flex align-items-center justify-content-between mb-2">
  <div class="d-inline-flex gap-2">
    <button type="button" class="btn btn-sm btn-outline-primary" id="btnSelectAll">Pilih semua</button>
    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnClear">Kosongkan</button>
  </div>
</div>

<!-- daftar komponen -->
<div id="komponenWrap" class="border rounded p-2 mb-3" style="max-height:360px; overflow:auto;">
  <?php if (empty($komponen)): ?>
    <div class="text-muted">Tidak ada komponen untuk jabatan ini.</div>
  <?php else: ?>
    <?php foreach ($komponen as $k): ?>
      <?php
        $already = in_array($k['id_komponen_gaji'], $existing ?? [], true);
        $cid     = 'k' . (int)$k['id_komponen_gaji'];
      ?>
      <div class="form-check">
        <input
          class="form-check-input"
          type="checkbox"
          name="komponen[]"
          id="<?= $cid ?>"
          value="<?= (int)$k['id_komponen_gaji'] ?>"
          <?= $already ? 'checked disabled' : '' ?>
        >
        <label class="form-check-label" for="<?= $cid ?>">
          <strong>[<?= esc($k['kategori']) ?>]</strong>
          <?= esc($k['nama_komponen']) ?> —
          Rp <?= number_format((float)$k['nominal'], 0, ',', '.') ?> / <?= esc($k['satuan']) ?>
          <span class="text-muted"> (<?= esc($k['jabatan']) ?>)</span>
          <?php if ($already): ?>
            <span class="badge bg-success ms-2">Sudah terdaftar</span>
          <?php endif; ?>
        </label>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>



    <button type="submit" class="btn btn-primary">Simpan Penggajian</button>
    <a href="<?= site_url('admin/penggajian/create') ?>" class="btn btn-light">Batal</a>
  </form>
<?php endif; ?>

<script>
(function(){
  const wrap  = document.getElementById('komponenWrap');
  const master= document.getElementById('checkAll');
  const btnAll= document.getElementById('btnSelectAll');
  const btnClr= document.getElementById('btnClear');

  function setAll(checked){
    wrap.querySelectorAll('input.form-check-input[name="komponen[]"]:not(:disabled)')
        .forEach(cb => cb.checked = checked);
    master.checked = checked;
  }

  master?.addEventListener('change', () => setAll(master.checked));
  btnAll?.addEventListener('click',  () => setAll(true));
  btnClr?.addEventListener('click',  () => setAll(false));

  // sinkronkan master saat user centang/hapus satuan
  wrap?.addEventListener('change', () => {
    const enabled = wrap.querySelectorAll('input[name="komponen[]"]:not(:disabled)');
    const checked = wrap.querySelectorAll('input[name="komponen[]"]:not(:disabled):checked');
    master.checked = enabled.length && enabled.length === checked.length;
    master.indeterminate = checked.length > 0 && checked.length < enabled.length;
  });
})();
</script>


<?= $this->endSection() ?>
