<?php namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggota;

    public function __construct()
    {
        $this->anggota = new AnggotaModel();
        helper(['form','text']);
    }

    // LIST untuk admin & user (view beda)
    public function index()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');

        $role    = session('role') ?? 'user';
        $q       = $this->request->getGet('q');
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 10;

        $rows  = $this->anggota->searchPaginated($q, $perPage);
        $total = count($rows);

        $offset  = ($page-1)*$perPage;
        $data    = array_slice($rows, $offset, $perPage);

        $pager   = \Config\Services::pager();
        $pagerHtml = $pager->makeLinks($page, $perPage, $total, 'default_full');

        $viewData = [
            'title'      => 'Data Anggota DPR',
            'rows'       => $data,
            'q'          => $q,
            'pagerHtml'  => $pagerHtml,
            'total'      => $total,
            'baseUrl'    => ($role === 'admin') ? base_url('admin/anggota') : base_url('anggota'),
        ];

        if ($role === 'admin') {
            // showActions di view admin di-set true
            return view('admin/anggota/index', $viewData);
        }
        // user read-only
        return view('user/anggota/index', $viewData);
    }

    // ------- CREATE -------
    public function create()
    {
        // opsional: cek lagi role di sini kalau belum pakai filter
        if (session('role') !== 'admin') return redirect()->to('/anggota');

        return view('admin/anggota/create', [
            'title' => 'Tambah Anggota DPR',
        ]);
    }

    public function store()
    {
        if (session('role') !== 'admin') return redirect()->to('/anggota');

        $post = $this->request->getPost();
        $post['jumlah_anak'] = (string)($post['jumlah_anak'] ?? '0'); // default 0

        $rules = [
            'nama_depan'        => 'required',
            'jabatan'           => 'required',
            'status_pernikahan' => 'required',
            'jumlah_anak'       => 'required|is_natural' // 0,1,2,...
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Form belum valid')
                ->with('validation', $this->validator);
        }

        // simpan
        if (!$this->anggota->insert([
            'gelar_depan'       => $post['gelar_depan'] ?? null,
            'nama_depan'        => $post['nama_depan'],
            'nama_belakang'     => $post['nama_belakang'] ?? null,
            'gelar_belakang'    => $post['gelar_belakang'] ?? null,
            'jabatan'           => $post['jabatan'],
            'status_pernikahan' => $post['status_pernikahan'],
            'jumlah_anak'       => (int)$post['jumlah_anak'],
        ])) {
            // tampilkan error model jika ada
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.implode(', ', $this->anggota->errors()));
        }

        return redirect()->to('/admin/anggota')->with('message','Anggota ditambahkan');
    }


    // ------- EDIT -------
    public function edit($id)
    {
        if (session('role') !== 'admin') return redirect()->to('/anggota');

        $row = $this->anggota->find($id);
        if (!$row) return redirect()->to('/admin/anggota')->with('error','Data tidak ditemukan');

        return view('admin/anggota/edit', [
            'title' => 'Ubah Anggota DPR',
            'row'   => $row,
        ]);
    }

    public function update($id)
    {
        if (session('role') !== 'admin') return redirect()->to('/anggota');

        $post = $this->request->getPost();
        $rules = [
            'nama_depan'        => 'required',
            'jabatan'           => 'required',
            'status_pernikahan' => 'required',
            'jumlah_anak'       => 'required|is_natural'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error','Form belum valid')
                ->with('validation', $this->validator);
        }

        $ok = $this->anggota->update($id, [
            'gelar_depan'       => $post['gelar_depan'] ?? null,
            'nama_depan'        => $post['nama_depan'],
            'nama_belakang'     => $post['nama_belakang'] ?? null,
            'gelar_belakang'    => $post['gelar_belakang'] ?? null,
            'jabatan'           => $post['jabatan'],
            'status_pernikahan' => $post['status_pernikahan'],
            'jumlah_anak'       => (int)($post['jumlah_anak'] ?? 0),
        ]);

        if (!$ok) {
            return redirect()->back()
                ->withInput()
                ->with('error','Gagal menyimpan: '.implode(', ', $this->anggota->errors()));
        }

        return redirect()->to('/admin/anggota')->with('message','Anggota berhasil diubah');
    }


    // ------- DELETE -------
    public function delete($id)
    {
        if (session('role') !== 'admin') return redirect()->to('/anggota');

        // TODO: kalau nanti ada relasi ke penggajian, tangani try/catch di sini
        $this->anggota->delete($id);

        return redirect()->to('/admin/anggota')->with('message','Anggota dihapus');
    }



    public function destroy($id)
    {
        if (session('role') !== 'admin') return redirect()->to('/anggota');

        try {
            $this->anggota->delete($id);
            return redirect()->to('/admin/anggota')->with('message','Anggota dihapus');
        } catch (\Throwable $e) {
            // contoh: kalau nanti terikat FK penggajian, beri pesan ramah
            return redirect()->to('/admin/anggota')->with('error','Tidak bisa menghapus: data terpakai.');
        }
    }
}
