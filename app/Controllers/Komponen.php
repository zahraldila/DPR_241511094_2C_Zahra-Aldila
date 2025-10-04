<?php

namespace App\Controllers;

use App\Models\KomponenModel;

class Komponen extends BaseController
{
    protected $komponen;

    public function __construct()
    {
        $this->komponen = new KomponenModel();
    }

    public function index()
    {
        $q = trim((string) $this->request->getGet('q'));
    
        $m = $this->komponen->orderBy('id_komponen_gaji','ASC');
    
        if ($q !== '') {
            $m = $m->groupStart()
                    ->like('id_komponen_gaji', $q)
                    ->orLike('nama_komponen', $q)
                    ->orLike('kategori', $q)
                    ->orLike('jabatan', $q)
                    ->orLike('nominal', $q)
                    ->orLike('satuan', $q)
                  ->groupEnd();
        }
    
        // pakai group pager khusus biar rapi
        $rows  = $m->paginate(10, 'komponen');
        $pager = $this->komponen->pager;
    
        // bawa ?q=... ke semua link
        $pager->only(['q']);
    
        return view('admin/komponen/index', [
            'title' => 'Komponen Gaji & Tunjangan',
            'rows'  => $rows,
            'pager' => $pager,
            'q'     => $q,
        ]);
    }
    



    // Form tambah
    public function create()
    {
        return view('admin/komponen/create', ['title'=>'Tambah Komponen Gaji']);
    }

    public function store()
    {
        $rules = [
            'nama_komponen' => 'required|min_length[3]',
            'kategori'      => 'required',
            'jabatan'       => 'required',
            'nominal'       => 'required|decimal|greater_than_equal_to[0]',
            'satuan'        => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali input kamu.');
        }

        $data = $this->request->getPost(['nama_komponen','kategori','jabatan','nominal','satuan']);
        (new \App\Models\KomponenModel())->insert($data);

        return redirect()->to('/admin/komponen')->with('message','Komponen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = $this->komponen->find($id);
        if (!$row) {
            return redirect()->to('/admin/komponen')->with('error','Data tidak ditemukan.');
        }

        return view('admin/komponen/edit', [
            'title' => 'Ubah Komponen',
            'row'   => $row,
            // enum helper utk select
            'optKategori' => ['Gaji Pokok','Tunjangan Melekat','Tunjangan'],
            'optJabatan'  => ['Ketua','Wakil Ketua','Anggota','Semua'],
            'optSatuan'   => ['Bulan','Hari','Periode'],
        ]);
    }

    public function update($id)
    {
        $row = $this->komponen->find($id);
        if (!$row) {
            return redirect()->to('/admin/komponen')->with('error','Data tidak ditemukan.');
        }

        $rules = [
            'nama_komponen' => 'required|min_length[3]',
            'kategori'      => 'required',
            'jabatan'       => 'required',
            'nominal'       => 'required|decimal|greater_than_equal_to[0]',
            'satuan'        => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error','Periksa kembali input kamu.');
        }

        $data = $this->request->getPost(['nama_komponen','kategori','jabatan','nominal','satuan']);
        $this->komponen->update($id, $data);

        return redirect()->to('/admin/komponen')->with('message','Komponen berhasil diubah.');
    }

    public function destroy($id)
    {
        $row = $this->komponen->find($id);
        if (!$row) {
            return redirect()->to('/admin/komponen')->with('error','Data tidak ditemukan.');
        }

        try {
            $this->komponen->delete($id);
            return redirect()->to('/admin/komponen')->with('message','Komponen berhasil dihapus.');
        } catch (\Throwable $e) {
            // misal nanti terkait FK penggajian
            return redirect()->to('/admin/komponen')->with('error','Tidak bisa menghapus: data sedang dipakai.');
        }
    }

}
