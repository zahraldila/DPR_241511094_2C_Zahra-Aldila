<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\KomponenModel;   // table: komponen_gaji
use App\Models\PenggajianListModel;

class Penggajian extends BaseController
{
    protected $anggota;
    protected $komponen;
    protected $penggajian;

    public function __construct()
    {
        $this->anggota    = new AnggotaModel();
        $this->komponen   = new KomponenModel();    // pastikan Model ini pakai $table='komponen_gaji'
    }

    public function index()
    {
        $db = db_connect();

        
        // --- NEW: ambil query pencarian
        $q = trim((string)$this->request->getGet('q'));
    
        // aturan tunjangan keluarga
        $PASANGAN_PCT = 0.10; // 10% dari gaji pokok bulanan
        $ANAK_PCT     = 0.02; // 2% per anak
        $ANAK_MAX     = 2;    // maksimal 2 anak
    
        // normalisasi satuan -> bulanan (Bulan=1, Hari≈22 hari kerja, Periode=1)
        $mul = "CASE LOWER(kg.satuan)
        WHEN 'bulan'   THEN 1
        WHEN 'hari'    THEN 22
        WHEN 'periode' THEN 1
        ELSE 1
        END";

    /** @var \CodeIgniter\Database\BaseBuilder $builder */
    $builder = $db->table('anggota a')
    ->select([
        'a.id_anggota','a.gelar_depan','a.nama_depan','a.nama_belakang','a.gelar_belakang',
        'a.jabatan','a.status_pernikahan','a.jumlah_anak',
        "COALESCE(SUM( (kg.nominal * $mul) ),0) AS plus_bln",
        "0 AS minus_bln",
        "COALESCE(SUM(CASE WHEN kg.kategori = 'Gaji Pokok'
                        THEN (kg.nominal * $mul) ELSE 0 END),0) AS gaji_pokok_bln",
    ])
    ->join('penggajian pg',   'pg.id_anggota = a.id_anggota', 'left')
    ->join('komponen_gaji kg','kg.id_komponen_gaji = pg.id_komponen_gaji', 'left')
    ->groupBy('a.id_anggota');

    if ($q !== '') {
    $builder->groupStart()
        ->like('a.id_anggota', $q)
        ->orLike('a.gelar_depan', $q)
        ->orLike('a.nama_depan', $q)
        ->orLike('a.nama_belakang', $q)
        ->orLike('a.gelar_belakang', $q)
        ->orLike('a.jabatan', $q)
    ->groupEnd();
    }

    $rows = $builder
    ->orderBy('a.id_anggota','ASC')
    ->get()->getResultArray();

    
        // hitung THP = (plus - minus) + tunjangan pasangan + tunjangan anak
        $data = [];
        foreach ($rows as $r) {
            $gajiPokok = (float)$r['gaji_pokok_bln'];
            $isMarried = ($r['status_pernikahan'] ?? '') === 'Kawin';
            $anak      = min((int)($r['jumlah_anak'] ?? 0), $ANAK_MAX);
    
            $tunjPasangan = $isMarried ? $gajiPokok * $PASANGAN_PCT : 0.0;
            $tunjAnak     = $gajiPokok * $ANAK_PCT * $anak;
    
            $thp = ((float)$r['plus_bln'] - (float)$r['minus_bln']) + $tunjPasangan + $tunjAnak;
    
            $data[] = [
                'id_anggota'     => $r['id_anggota'],
                'gelar_depan'    => $r['gelar_depan'],
                'nama_depan'     => $r['nama_depan'],
                'nama_belakang'  => $r['nama_belakang'],
                'gelar_belakang' => $r['gelar_belakang'],
                'jabatan'        => $r['jabatan'],
                'thp'            => $thp,
            ];
        }
    
        return view('admin/penggajian/index', [
            'title' => 'Daftar Penggajian',
            'rows'  => $data,
            'q'     => $q, 
        ]);
    }
    
    
    public function create()
    {
        $db = db_connect(); // <-- tambahkan
    
        $idAnggota = (int) ($this->request->getGet('id_anggota') ?? 0);
    
        // kalau mau aman juga, pastikan model terisi
        $this->anggota  = $this->anggota  ?? new \App\Models\AnggotaModel();
        $this->komponen = $this->komponen ?? new \App\Models\KomponenModel();
    
        $anggotaOptions = $this->anggota
            ->select('id_anggota, gelar_depan, nama_depan, nama_belakang, gelar_belakang, jabatan, status_pernikahan, jumlah_anak')
            ->orderBy('id_anggota','ASC')
            ->findAll();
    
        $anggota  = null;
        $komponen = [];
        $existing = [];
    
        if ($idAnggota) {
            $anggota = $this->anggota->find($idAnggota);
            if ($anggota) {
                $komponen = $this->komponen
                    ->groupStart()->where('jabatan', $anggota['jabatan'])->orWhere('jabatan','Semua')->groupEnd()
                    ->orderBy('kategori','ASC')->orderBy('nama_komponen','ASC')
                    ->findAll();
    
                // pakai $db, bukan $this->db
                $existing = array_column(
                    $db->table('penggajian')
                       ->select('id_komponen_gaji')
                       ->where('id_anggota', $idAnggota)
                       ->get()->getResultArray(),
                    'id_komponen_gaji'
                );
            }
        }
    
        return view('admin/penggajian/create', [
            'title'          => 'Tambah Penggajian',
            'anggotaOptions' => $anggotaOptions,
            'selectedId'     => $idAnggota,
            'anggota'        => $anggota,
            'komponen'       => $komponen,
            'existing'       => $existing,
        ]);
    }
    
    public function store()
    {
        $db = db_connect(); // <-- tambahkan
    
        $idAnggota = (int) $this->request->getPost('id_anggota');
        $selected  = $this->request->getPost('komponen') ?? [];
    
        if (!$idAnggota || empty($selected)) {
            return redirect()->back()->withInput()->with('error','Pilih anggota dan minimal satu komponen.');
        }
    
        $this->anggota  = $this->anggota  ?? new \App\Models\AnggotaModel();
        $this->komponen = $this->komponen ?? new \App\Models\KomponenModel();
    
        $anggota = $this->anggota->find($idAnggota);
        if (!$anggota) {
            return redirect()->back()->withInput()->with('error','Anggota tidak valid.');
        }
    
        $allowedIds = array_column(
            $this->komponen
                ->groupStart()->where('jabatan', $anggota['jabatan'])->orWhere('jabatan','Semua')->groupEnd()
                ->findAll(),
            'id_komponen_gaji'
        );
    
        $selected   = array_map('intval', array_unique($selected));
        $notAllowed = array_diff($selected, $allowedIds);
        if (!empty($notAllowed)) {
            return redirect()->back()->withInput()->with('error','Ada komponen yang tidak sesuai jabatan.');
        }
    
        // pakai $db, bukan $this->db
        $existingIds = array_column(
            $db->table('penggajian')
               ->select('id_komponen_gaji')
               ->where('id_anggota', $idAnggota)
               ->get()->getResultArray(),
            'id_komponen_gaji'
        );
    
        $dupIds = array_values(array_intersect($selected, $existingIds));
        $newIds = array_values(array_diff($selected, $existingIds));
    
        if (empty($newIds)) {
            $dupNames = !empty($dupIds)
                ? array_column($this->komponen->whereIn('id_komponen_gaji', $dupIds)->findAll(), 'nama_komponen')
                : [];
            $msg = 'Semua komponen yang dipilih sudah terdaftar' . (!empty($dupNames) ? ': '.implode(', ', $dupNames) : '') . '.';
            return redirect()->back()->withInput()->with('error', $msg);
        }
    
        $rows = array_map(fn($idK) => [
            'id_anggota'       => $idAnggota,
            'id_komponen_gaji' => $idK,
        ], $newIds);
    
        $db->transStart();
        $db->table('penggajian')->insertBatch($rows);
        $db->transComplete();
    
        if (! $db->transStatus()) {
            $err = $db->error();
            return redirect()->back()->withInput()->with('error','Gagal menyimpan penggajian. '.$err['message']);
        }
    
        $flash = 'Berhasil menambahkan '.count($newIds).' komponen.';
        if (!empty($dupIds)) {
            $dupNames = array_column($this->komponen->whereIn('id_komponen_gaji', $dupIds)->findAll(), 'nama_komponen');
            $flash   .= ' (Diabaikan duplikat: '.implode(', ', $dupNames).')';
        }
    
        return redirect()->to(site_url('admin/penggajian'))
             ->with('success', $flash);

    }

    public function edit(int $idAnggota)
    {
        $db = db_connect();

        $a = $this->anggota->find($idAnggota);
        if (!$a) return redirect()->to(site_url('admin/penggajian'))->with('error','Anggota tidak ditemukan.');

        // komponen yang valid untuk jabatan ini
        $komponen = $this->komponen
            ->groupStart()->where('jabatan', $a['jabatan'])->orWhere('jabatan','Semua')->groupEnd()
            ->orderBy('kategori','ASC')->orderBy('nama_komponen','ASC')
            ->findAll();

        // komponen yang sudah terpasang
        $existing = array_column(
            $db->table('penggajian')->select('id_komponen_gaji')->where('id_anggota', $idAnggota)->get()->getResultArray(),
            'id_komponen_gaji'
        );

        return view('admin/penggajian/edit', [
            'title'    => 'Ubah Penggajian',
            'a'        => $a,
            'komponen' => $komponen,
            'existing' => $existing,
        ]);
    }

    public function update(int $idAnggota)
    {
        $db = db_connect();

        $a = $this->anggota->find($idAnggota);
        if (!$a) return redirect()->to(site_url('admin/penggajian'))->with('error','Anggota tidak ditemukan.');

        $picked = array_map('intval', $this->request->getPost('komponen') ?? []);

        // validasi hanya {jabatan anggota} ∪ {Semua}
        $allowedIds = array_column(
            $this->komponen
                ->groupStart()->where('jabatan', $a['jabatan'])->orWhere('jabatan','Semua')->groupEnd()
                ->findAll(),
            'id_komponen_gaji'
        );
        $notAllowed = array_diff($picked, $allowedIds);
        if ($notAllowed) {
            return redirect()->back()->withInput()->with('error','Ada komponen yang tidak sesuai jabatan.');
        }

        $current = array_column(
            $db->table('penggajian')->select('id_komponen_gaji')->where('id_anggota', $idAnggota)->get()->getResultArray(),
            'id_komponen_gaji'
        );

        $toAdd = array_values(array_diff($picked, $current));
        $toDel = array_values(array_diff($current, $picked));

        $db->transStart();
        if ($toAdd) {
            $rows = array_map(fn($idK)=>['id_anggota'=>$idAnggota,'id_komponen_gaji'=>$idK], $toAdd);
            $db->table('penggajian')->insertBatch($rows);
        }
        if ($toDel) {
            $db->table('penggajian')
            ->where('id_anggota', $idAnggota)
            ->whereIn('id_komponen_gaji', $toDel)
            ->delete();
        }
        $db->transComplete();

        if (! $db->transStatus()) {
            $err = $db->error();
            return redirect()->back()->withInput()->with('error','Gagal menyimpan perubahan. '.$err['message']);
        }

        return redirect()->to(site_url('admin/penggajian'))
            ->with('success', 'Perubahan penggajian disimpan.');
    }

  
}
