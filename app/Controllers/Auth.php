<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login', ['title' => 'Login']);
    }

    public function attemptLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->with('error', 'Username dan password wajib diisi')->withInput();
        }

        $user = (new PenggunaModel())
            ->select('id_pengguna, username, password, role, nama_depan, nama_belakang, email')
            ->where('username', $username)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan')->withInput();
        }

        // Deteksi otomatis: kalau password di DB sudah di-hash (bcrypt/argon), pakai password_verify.
        // Kalau masih plain text, bandingkan biasa.
        $dbPass = (string) $user['password'];
        $isHash = preg_match('~^\$2y\$|\$argon2id\$|\$argon2i\$~', $dbPass) === 1;

        $valid = $isHash ? password_verify($password, $dbPass) : hash_equals($dbPass, $password);

        if (!$valid) {
            return redirect()->back()->with('error', 'Password salah')->withInput();
        }

        // Set session
        session()->set([
            'isLoggedIn' => true,
            'user_id'    => (int) $user['id_pengguna'],
            'username'   => $user['username'],
            'nama'       => trim(($user['nama_depan'] ?? '') . ' ' . ($user['nama_belakang'] ?? '')),
            'email'      => $user['email'] ?? null,
            // pastikan kolom role berisi 'admin' atau 'user'/'public'
            'role'       => strtolower($user['role']),
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
