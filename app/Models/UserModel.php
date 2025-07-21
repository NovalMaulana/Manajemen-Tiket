<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['username', 'password', 'email', 'full_name', 'role_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    // Validation rules dasar (untuk insert)
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'role_id' => 'required|numeric'
    ];

    // Custom validation rules untuk update
    protected $customValidationRules = [];

    // Set custom validation rules
    public function setCustomValidationRules(array $rules)
    {
        $this->customValidationRules = $rules;
    }

    // Override validasi rules
    public function getValidationRules(array $options = []): array
    {
        if (!empty($this->customValidationRules)) {
            return $this->customValidationRules;
        }
        return $this->validationRules;
    }

    public function getUser($id)
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.role_id = users.role_id')
                    ->find($id);
    }

    public function getUserByUsername($username)
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.role_id = users.role_id')
                    ->where('username', $username)
                    ->first();
    }

    public function getUserByEmail($email)
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.role_id = users.role_id')
                    ->where('email', $email)
                    ->first();
    }

    public function getUsersWithRoles()
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.role_id = users.role_id')
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }

    public function getActiveUsers()
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.role_id = users.role_id')
                    ->where('users.is_active', 1)
                    ->orderBy('users.full_name', 'ASC')
                    ->findAll();
    }
} 