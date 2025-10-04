<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Komponen Gaji &amp; Tunjangan</h4>
<div class="d-flex align-items-center justify-content-between mb-3">
  <form class="d-flex" method="get" action="<?= site_url('admin/komponen') ?>" style="max-width:520px; width:100%;">
    <input type="text" class="form-control me-2" name="q"
           placeholder="Cari ID/nama/kategori/jabatan/nominal/satuan..."
           value="<?= esc($q ?? '') ?>">

    <button class="btn btn-outline-secondary me-2" type="submit">Cari</button>

    <?php if (!empty($q)): ?>
      <a class="btn btn-outline-danger" href="<?= site_url('admin/komponen') ?>">Reset</a>
    <?php endif; ?>
  </form>

  <a class="btn btn-primary ms-3" href="<?= site_url('admin/komponen/create') ?>">
    + Tambah Komponen
  </a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover mb-0 align-middle">
    <thead class="table-light">
      <tr>
      <th style="width:120px">ID</th>
     <th>Nama Komponen</th>
     <th>Kategori</th>
     <th>Jabatan</th>
     <th class="text-end">Nominal</th>
     <th>Satuan</th>
     <th style="width:140px" class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
        <tr><td colspan="7" class="text-center py-4">Tidak ada data.</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= esc($r['id_komponen_gaji']) ?></td>
          <td><?= esc($r['nama_komponen']) ?></td>
          <td><?= esc($r['kategori']) ?></td>
          <td><?= esc($r['jabatan']) ?></td>
          <td class="text-end"><?= number_format((float)$r['nominal'], 0, ',', '.') ?></td>
          <td><?= esc($r['satuan']) ?></td>
          <!-- TBODY, di dalam loop -->
          <td class="text-center">
            <div class="d-inline-flex gap-1">
                <a href="<?= site_url('admin/komponen/edit/'.$r['id_komponen_gaji']) ?>"
                class="btn btn-sm btn-warning">Ubah</a>

                <form action="<?= site_url('admin/komponen/delete/'.$r['id_komponen_gaji']) ?>"
                    method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="button" class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmDel<?= $r['id_komponen_gaji'] ?>">
                    Hapus
                </button>

            <!-- Modal konfirmasi -->
            <div class="modal fade" id="confirmDel<?= $r['id_komponen_gaji'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    Hapus komponen <strong><?= esc($r['nama_komponen']) ?></strong>
                    (ID: <?= esc($r['id_komponen_gaji']) ?>)?
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
        </td>

        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>

<?php if (isset($pager)): ?>
  <div class="mt-3">
    <?= $pager->links('komponen', 'bs_full') ?>
  </div>
<?php endif; ?>


<?= $this->endSection() ?>
