<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $sessionData = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role_id' => $user['role_id'],
                    'role_name' => $user['role_name'],
                    'logged_in' => true
                ];
                session()->set($sessionData);

                // Tampilkan halaman redirect yang formal
                return view('auth/redirect', [
                    'message' => 'Login berhasil!',
                    'submessage' => 'Anda akan dialihkan ke dashboard dalam beberapa detik.',
                    'redirect_url' => base_url('dashboard'),
                    'redirect_text' => 'Dashboard',
                    'icon' => 'fas fa-check-circle',
                    'color' => 'success'
                ]);
            }

            // Tampilkan halaman error yang formal
            return view('auth/redirect', [
                'message' => 'Login gagal!',
                'submessage' => 'Username atau password yang Anda masukkan salah.',
                'redirect_url' => base_url('auth/login'),
                'redirect_text' => 'Kembali ke Login',
                'icon' => 'fas fa-exclamation-triangle',
                'color' => 'danger'
            ]);
        }

        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name'),
                'role_id' => 3 // Default role: customer
            ];

            try {
                $this->userModel->insert($data);
                return redirect()->to(base_url('auth/login'))->with('success', 'Registrasi berhasil, silakan login');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            }
        }

        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
} 