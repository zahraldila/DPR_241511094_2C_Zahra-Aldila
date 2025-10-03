<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        return (session('role') === 'admin')
            ? redirect()->to('/admin/dashboard')
            : redirect()->to('/user/dashboard');
    }

    // app/Controllers/Dashboard.php
    public function admin()
    {
        $stats = ['anggota' => 0, 'komponen' => 0, 'penggajian' => 0];
    
        // selalu ada
        $stats['anggota'] = (new \App\Models\AnggotaModel())->countAllResults();
    
        // opsional: hanya kalau modelnya sudah ada
        if (class_exists(\App\Models\KomponenModel::class)) {
            $stats['komponen'] = (new \App\Models\KomponenModel())->countAllResults();
        }
        if (class_exists(\App\Models\PenggajianModel::class)) {
            $stats['penggajian'] = (new \App\Models\PenggajianModel())->countAllResults();
        }
    
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
        ]);
    }
    
    


    public function user()
    {
        return view('user/dashboard', [
            'title' => 'User Dashboard',
            'menu'  => [
                ['href'=>'/user/dashboard','text'=>'Overview','id'=>'menu-overview'],
            ],
        ]);
    }
}
