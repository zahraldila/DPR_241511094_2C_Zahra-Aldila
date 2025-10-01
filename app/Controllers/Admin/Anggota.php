<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    private AnggotaModel $anggota;

    public function __construct()
    {
        $this->anggota = new AnggotaModel();
        helper(['form']);
    }

    public function index()
    {
        $q = trim((string)($this->request->getGet('q') ?? ''));
        $perPage = 10;

        // siapkan builder untuk search
        $model = $this->anggota;
        if ($q !== '') {
            $model = $model->groupStart()
                ->like('id_anggota', $q)
                ->orLike('nama_depan', $q)
                ->orLike('nama_belakang', $q)
                ->orLike('jabatan', $q)
            ->groupEnd();
        }

        // ambil data dengan paginate (wajib agar $pager ada)
        $records = $model->orderBy('id_anggota','DESC')->paginate($perPage);
        $pager   = $model->pager;

        return view('admin/anggota/index', [
            'title'   => 'Data Anggota DPR',
            'q'       => $q,
            'records' => $records,
            'pager'   => $pager,
        ]);
    }

    private function rules(): array
    {
        return [
            'nama_depan'        => 'required|min_length[2]',
            'nama_belakang'     => 'permit_empty',
            'gelar_depan'       => 'permit_empty',
            'gelar_belakang'    => 'permit_empty',
            'jabatan'           => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'status_pernikahan' => 'required|in_list[Belum Kawin,Kawin]',
        ];
    }

    public function create()
    {
        return view('admin/anggota/create', [
            'title' => 'Tambah Anggota DPR',
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $this->anggota->insert([
            'gelar_depan'       => trim((string)$this->request->getPost('gelar_depan')),
            'nama_depan'        => trim((string)$this->request->getPost('nama_depan')),
            'nama_belakang'     => trim((string)$this->request->getPost('nama_belakang')),
            'gelar_belakang'    => trim((string)$this->request->getPost('gelar_belakang')),
            'jabatan'           => (string)$this->request->getPost('jabatan'),
            'status_pernikahan' => (string)$this->request->getPost('status_pernikahan'),
        ]);

        return redirect()->to('/admin/anggota')->with('success','Anggota berhasil ditambahkan.');
    }

}
