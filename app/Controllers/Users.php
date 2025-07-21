<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class Users extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        // Check if user is admin
        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->getUsersWithRoles()
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        // Check if user is admin
        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $data = [
            'title' => 'Tambah User',
            'roles' => $this->roleModel->findAll()
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        // Check if user is admin
        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Validation rules
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'role_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id' => $this->request->getPost('role_id')
        ];

        // Save user
        if ($this->userModel->insert($data)) {
            return redirect()->to('users')->with('success', 'User berhasil ditambahkan.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan user.');
        }
    }

    public function edit($id = null)
    {
        // Check if user is admin
        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $this->roleModel->findAll()
        ];

        return view('users/edit', $data);
    }

    public function update($id = null)
    {
        // Check if user is admin
        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('users')->with('error', 'User tidak ditemukan.');
        }

        // Validation rules
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,user_id,' . $id . ']',
            'role_id' => 'required|numeric'
        ];

        // Add password validation if password is provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'role_id' => $this->request->getPost('role_id')
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Update user
        if ($this->userModel->update($id, $data)) {
            return redirect()->to('users')->with('success', 'User berhasil diupdate.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate user.');
        }
    }

    public function delete($id = null)
    {
        // Check if user is admin
        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Prevent deleting own account
        if ($id == session()->get('user_id')) {
            return redirect()->to('users')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('users')->with('error', 'User tidak ditemukan.');
        }

        // Delete user
        if ($this->userModel->delete($id)) {
            return redirect()->to('users')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->to('users')->with('error', 'Terjadi kesalahan saat menghapus user.');
        }
    }
} 