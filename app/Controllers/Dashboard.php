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
    return view('admin/dashboard', [
        'title' => 'Admin Dashboard',
        'menu'  => [
            ['href'=>'/admin/dashboard','text'=>'Home','id'=>'m-home','icon'=>'bi-house'],
            // ganti "Items" jadi "Anggota DPR"
            ['href'=>'/admin/anggota','text'=>'Anggota DPR','id'=>'m-anggota','icon'=>'bi-people'],
            // (opsional) sisakan settings
            ['href'=>'/admin/settings','text'=>'Settings','id'=>'m-settings','icon'=>'bi-gear'],
        ],
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
