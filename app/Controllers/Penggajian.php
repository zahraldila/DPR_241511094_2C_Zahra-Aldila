<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\KomponenModel;   // table: komponen_gaji
use App\Models\PenggajianModel; // table: penggajian (junction)

class Penggajian extends BaseController
{
    protected $anggota;
    protected $komponen;
    protected $penggajian;

    public function __construct()
    {
        $this->anggota    = new AnggotaModel();
        $this->komponen   = new KomponenModel();    // pastikan Model ini pakai $table='komponen_gaji'
        $this->penggajian = new PenggajianModel();  // $table='penggajian', composite (tanpa PK tunggal)
    }

    
    /**
     * GET /admin/penggajian/create
     * Pilih Anggota -> tampilkan daftar komponen sesuai jabatan (atau 'Semua')
     */
    public function create()
    {
        $idAnggota = (int) ($this->request->getGet('id_anggota') ?? 0);

        $anggotaOptions = (new \App\Models\AnggotaModel())
        ->select('id_anggota, gelar_depan, nama_depan, nama_belakang, gelar_belakang, jabatan, status_pernikahan, jumlah_anak')
        ->orderBy('id_anggota','ASC')
        ->findAll();   // ← harus findAll() tanpa angka


        $anggota = null;
        $komponen = [];
        if ($idAnggota) {
            $anggota = $this->anggota->find($idAnggota);
            if ($anggota) {
                // Komponen valid = yang jabatan-nya sama dengan anggota ATAU 'Semua'
                $komponen = $this->komponen
                    ->groupStart()
                        ->where('jabatan', $anggota['jabatan'])
                        ->orWhere('jabatan', 'Semua')
                    ->groupEnd()
                    ->orderBy('kategori', 'ASC')
                    ->orderBy('nama_komponen', 'ASC')
                    ->findAll();
            }
        }

        return view('admin/penggajian/create', [
            'title'          => 'Tambah Penggajian',
            'anggotaOptions' => $anggotaOptions,
            'selectedId'     => $idAnggota,
            'anggota'        => $anggota,
            'komponen'       => $komponen,
        ]);
    }

    /**
     * POST /admin/penggajian/store
     * Simpan pasangan (id_anggota, id_komponen_gaji) — anti duplikat & sesuai jabatan
     */
    public function store()
    {
        $idAnggota = (int) $this->request->getPost('id_anggota');
        $selected  = $this->request->getPost('komponen') ?? [];
    
        if (!$idAnggota || empty($selected)) {
            return redirect()->back()->withInput()->with('error', 'Pilih anggota dan minimal satu komponen.');
        }
    
        $anggota = $this->anggota->find($idAnggota);
        if (!$anggota) {
            return redirect()->back()->withInput()->with('error', 'Anggota tidak valid.');
        }
    
        // Validasi: hanya komponen untuk jabatan anggota atau 'Semua'
        $allowedIds = array_column(
            $this->komponen
                ->groupStart()->where('jabatan', $anggota['jabatan'])->orWhere('jabatan','Semua')->groupEnd()
                ->findAll(),
            'id_komponen_gaji'
        );
    
        $selected = array_map('intval', array_unique($selected));
        $notAllowed = array_diff($selected, $allowedIds);
        if (!empty($notAllowed)) {
            return redirect()->back()->withInput()->with('error', 'Ada komponen yang tidak sesuai jabatan.');
        }
    
        // Siapkan batch data
        $rows = array_map(fn($idK) => [
            'id_anggota'       => $idAnggota,
            'id_komponen_gaji' => $idK,
        ], $selected);
    
        $db = \Config\Database::connect();
        $db->transStart();
    
        // Tulis dengan INSERT IGNORE agar duplikat dilewati tanpa error
        $tbl = $db->table('penggajian')->ignore(true);
        $tbl->insertBatch($rows);
    
        $db->transComplete();
    
        // Debug minimal kalau gagal
        if (! $db->transStatus()) {
            $err = $db->error(); // ['code'=>..., 'message'=>...]
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penggajian. '.$err['message']);
        }
    
        return redirect()->to('/admin/penggajian/create?id_anggota=' . $idAnggota)
            ->with('message', 'Data penggajian berhasil dibuat.');
    }
    
    // --- Method untuk commit berikutnya (nanti kita isi saat step "Lihat/Ubah/Hapus/Detail") ---
    public function index()      { /* TODO (commit 2) */ }
    public function edit($id)    { /* TODO (commit 3) */ }
    public function update($id)  { /* TODO (commit 3) */ }
    public function destroy()    { /* TODO (commit 4) */ }
    public function show($id)    { /* TODO (commit 5) */ }
}
