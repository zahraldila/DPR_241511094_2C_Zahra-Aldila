<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attempt()
    {
        $login    = trim((string)$this->request->getPost('username')); // username/email
        $password = (string)$this->request->getPost('password');

        if ($login === '' || $password === '') {
            return redirect()->back()->with('error', 'Username & password wajib diisi.');
        }

        $model = new PenggunaModel();

        // cari berdasarkan username ATAU email
        $user = $model->groupStart()
                        ->where('username', $login)
                        ->orWhere('email', $login)
                      ->groupEnd()
                      ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        // verifikasi password
        $stored = (string)$user['password'];
        $isBcrypt = str_starts_with($stored, '$2y$'); 
        $valid = $isBcrypt ? password_verify($password, $stored)
                           : hash_equals($stored, $password);

        if (!$valid) {
            return redirect()->back()->with('error', 'Kredensial salah.');
        }

        // buat nama lengkap dari nama_depan + nama_belakang
        $fullName = trim(($user['nama_depan'] ?? '').' '.($user['nama_belakang'] ?? ''));
        if ($fullName === '') {
            $fullName = $user['username'] ?? 'User';
        }

        // normalisasi role dari DB ke role app
        $rawRole = strtolower($user['role'] ?? 'user');

        if (in_array($rawRole, ['admin','administrator','superadmin'])) {
            $role = 'admin';
        } elseif (in_array($rawRole, ['user','public','member','citizen'])) {
            $role = 'user';
        } else {
            $role = 'user';
        }

        // set session
        session()->set([
            'user_id'    => $user['id_pengguna'],
            'username'   => $user['username'],
            'full_name'  => $fullName,
            'role'       => $role,
            'isLoggedIn' => true,
        ]);

        // redirect sesuai role
        return ($role === 'admin')
            ? redirect()->to('/admin/dashboard')
            : redirect()->to('/user/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
