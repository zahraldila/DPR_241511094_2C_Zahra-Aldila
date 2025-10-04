<?php

// app/Controllers/PublicAnggota.php
namespace App\Controllers;

use App\Models\AnggotaModel;

class PublicAnggota extends BaseController
{
    public function index()
    {
    
        $model   = new \App\Models\AnggotaModel();
        $builder = $model->select('id_anggota, gelar_depan, nama_depan, nama_belakang, gelar_belakang, jabatan, status_pernikahan, jumlah_anak');
    
        $q = $this->request->getGet('q');
        $perPage = 10;
        $builder = $model->select('id_anggota, gelar_depan, nama_depan, nama_belakang, gelar_belakang, jabatan, status_pernikahan, jumlah_anak');
        
        if ($q) {
            // normalisasi query: ke lower, buang non-alnum → jadi token-token
            $norm = strtolower(preg_replace('~[^a-z0-9]+~i', ' ', $q));
            $tokens = array_values(array_filter(explode(' ', $norm)));
        
            foreach ($tokens as $t) {
                // untuk cocokkan "s.t" == "st" juga
                $tNoPunct = preg_replace('~[^a-z0-9]+~', '', $t);
        
                // tiap token di-AND; di dalamnya OR ke banyak kolom
                $builder->groupStart()
                    // nama & gelar (case-insensitive)
                    ->like('LOWER(gelar_depan)', $t, 'both', false)
                    ->orLike('LOWER(nama_depan)', $t, 'both', false)
                    ->orLike('LOWER(nama_belakang)', $t, 'both', false)
                    ->orLike('LOWER(gelar_belakang)', $t, 'both', false)
                    ->orLike('LOWER(jabatan)', $t, 'both', false)
                    ->orLike('LOWER(status_pernikahan)', $t, 'both', false)
        
                    // varian tanpa tanda baca (S.T == ST)
                    ->orLike("REPLACE(LOWER(gelar_depan), '.', '')", $tNoPunct, 'both', false)
                    ->orLike("REPLACE(LOWER(gelar_belakang), '.', '')", $tNoPunct, 'both', false)
                ->groupEnd();
                // catatan: successive groupStart() otomatis di-AND oleh builder
            }
        }
        
    
        // gunakan group 'anggota' untuk pager
        $rows  = $builder->orderBy('id_anggota','ASC')->paginate($perPage, 'anggota');
        $pager = $model->pager;
        $pager->setPath(base_url('public/anggota')); // path pager
    
        return view('public/anggota/index', [
            'title'    => 'Daftar Anggota DPR',
            'q'        => $q,
            'rows'     => $rows,
            'pager'    => $pager,
        ]);
    }
    
}
