<?php
namespace App\Controllers;

class PublicPenggajian extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // cek kolom yang ada
        $fields = array_map('strtolower', $db->getFieldNames('penggajian'));
        $has = fn($name) => in_array(strtolower($name), $fields, true);

        // SELECT aman
        $select = [
            'p.id_anggota',
            "CONCAT(
                COALESCE(a.gelar_depan,''), ' ',
                COALESCE(a.nama_depan,''), ' ',
                COALESCE(a.nama_belakang,''), ' ',
                COALESCE(a.gelar_belakang,'')
            ) AS nama",
            'a.jabatan',
        ];
        if ($has('bulan'))      $select[] = 'p.bulan';
        if ($has('tahun'))      $select[] = 'p.tahun';
        if ($has('periode'))    $select[] = 'p.periode';
        if ($has('tanggal'))    $select[] = 'p.tanggal';
        if ($has('keterangan')) $select[] = 'p.keterangan';

        $builder = $db->table('penggajian p')
            ->select($select)
            ->join('anggota a', 'a.id_anggota = p.id_anggota', 'left');

        // order by adaptif
        if ($has('tahun') && $has('bulan')) {
            $builder->orderBy('p.tahun', 'DESC')->orderBy('p.bulan', 'DESC');
        } elseif ($has('periode')) {
            $builder->orderBy('p.periode', 'DESC');
        } elseif ($has('tanggal')) {
            $builder->orderBy('p.tanggal', 'DESC');
        } else {
            $builder->orderBy('p.id_anggota', 'ASC');
        }

        // paginate manual
        $page    = max(1, (int)($this->request->getGet('page') ?? 1));
        $perPage = 10;
        $offset  = ($page - 1) * $perPage;

        $rows  = $builder->get($perPage, $offset)->getResultArray();
        $total = $db->table('penggajian')->countAllResults();

        // pager: gunakan PATH RELATIF (bukan base_url)
        $pager = \Config\Services::pager();
        $pager->setPath('public/penggajian');

        // siapkan HTML siap pakai (biar di view tinggal echo)
        $pagerHtml = $pager->makeLinks($page, $perPage, $total, 'bs_full');

        $caps = [
            'hasBulan'   => $has('bulan'),
            'hasTahun'   => $has('tahun'),
            'hasPeriode' => $has('periode'),
            'hasTanggal' => $has('tanggal'),
            'hasKet'     => $has('keterangan'),
        ];

        return view('public/penggajian/index', [
            'title'     => 'Data Penggajian',
            'rows'      => $rows,
            'caps'      => $caps,
            'pagerHtml' => $pagerHtml,
        ]);
    }
}
