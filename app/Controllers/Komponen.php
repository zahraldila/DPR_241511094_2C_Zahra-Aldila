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
        $rows = $this->komponen->orderBy('id_komponen_gaji','ASC')->findAll();
        return view('admin/komponen/index', [
            'title' => 'Komponen Gaji & Tunjangan',
            'rows'  => $rows,
        ]);
    }


    // Form tambah
    public function create()
    {
        return view('admin/komponen/create', [
            'title' => 'Tambah Komponen Gaji'
        ]);
    }

    // Simpan data
    public function store()
    {
        $data = $this->request->getPost([
            'nama_komponen', 'kategori', 'jabatan', 'nominal', 'satuan'
        ]);

        $this->komponen->insert($data);
        return redirect()->to('/admin/komponen')->with('message', 'Komponen berhasil ditambahkan.');
    }
}
