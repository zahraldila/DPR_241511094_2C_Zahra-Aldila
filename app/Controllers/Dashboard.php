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

    public function admin()
    {
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'menu'  => [
                ['href'=>'/admin/dashboard','text'=>'Home','id'=>'m-home','icon'=>'bi-house'],
                ['href'=>'/admin/items','text'=>'Items','id'=>'m-items','icon'=>'bi-grid'],
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
                // tambah menu user di sini nanti
            ],
        ]);
    }
}
