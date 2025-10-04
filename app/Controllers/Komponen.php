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

}
