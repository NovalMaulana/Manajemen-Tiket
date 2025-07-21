<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class Profile extends BaseController
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
        $userId = session()->get('user_id');
        $user = $this->userModel->getUser($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $data = [
            'title' => 'Profile Saya',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    public function edit()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->getUser($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Profile',
            'user' => $user,
            'roles' => $this->roleModel->findAll()
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        // Set validation rules khusus untuk update
        $validationRules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,user_id,' . $userId . ']',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,user_id,' . $userId . ']'
        ];

        // Add password validation if password is provided
        if ($this->request->getPost('password')) {
            $validationRules['password'] = 'min_length[6]';
            $validationRules['confirm_password'] = 'matches[password]';
        }

        // Set custom validation rules
        $this->userModel->setCustomValidationRules($validationRules);

        // Prepare data
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'role_id' => $user['role_id'] // Mempertahankan role_id yang ada
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Debug: Log data yang akan diupdate
        log_message('debug', 'Update Profile Data: ' . json_encode($data));

        try {
            // Update user
            if ($this->userModel->update($userId, $data)) {
                // Update session data
                $updatedUser = $this->userModel->getUser($userId);
                session()->set([
                    'username' => $updatedUser['username'],
                    'full_name' => $updatedUser['full_name']
                ]);

                return redirect()->to('profile')->with('success', 'Profile berhasil diupdate.');
            } else {
                // Debug: Log error dari model
                log_message('error', 'Update Profile Error: ' . json_encode($this->userModel->errors()));
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat mengupdate profile. Error: ' . json_encode($this->userModel->errors()));
            }
        } catch (\Exception $e) {
            // Debug: Log exception
            log_message('error', 'Update Profile Exception: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $data = [
            'title' => 'Ganti Password',
            'user' => $user
        ];

        return view('profile/change_password', $data);
    }

    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        // Validation rules
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Check current password
        $currentPassword = $this->request->getPost('current_password');
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password saat ini tidak sesuai.');
        }

        // Update password
        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        
        if ($this->userModel->update($userId, ['password' => $newPassword])) {
            return redirect()->to('profile')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengubah password.');
        }
    }
} 