<?php namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id_anggota';
    protected $returnType       = 'array';
    protected $allowedFields = [
        'gelar_depan','nama_depan','nama_belakang','gelar_belakang',
        'jabatan','status_pernikahan','jumlah_anak'
    ];
      

    // kolom yang diijinkan untuk pencarian
    protected $searchable = [
        'id_anggota','gelar_depan','nama_depan','nama_belakang','gelar_belakang','jabatan'
    ];

    public function searchPaginated(?string $q, int $perPage = 10)
    {
        $builder = $this->builder();

        if ($q && $q !== '') {
            $q = trim($q);
            $builder->groupStart();
            foreach ($this->searchable as $i => $col) {
                if ($i === 0) {
                    // allow exact or partial for id_anggota
                    $builder->like($col, $q);
                } else {
                    $builder->orLike($col, $q);
                }
            }
            $builder->groupEnd();
        }

        // urutkan nama depan lalu belakang
        $builder->orderBy('nama_depan', 'ASC')->orderBy('nama_belakang', 'ASC');

        return $builder->get()->getResultArray();
    }
}
