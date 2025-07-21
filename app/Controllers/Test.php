<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo "Test controller works!";
    }

    public function login()
    {
        echo "Method: " . $this->request->getMethod() . "<br>";
        echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "Form submitted via POST!<br>";
            
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            echo "Username: " . $username . "<br>";
            echo "Password: " . $password . "<br>";
            
            if ($username === 'admin' && $password === 'admin123') {
                echo "Login berhasil!<br>";
                // Set session
                session()->set([
                    'user_id' => 1,
                    'username' => 'admin',
                    'full_name' => 'Administrator',
                    'role_id' => 1,
                    'role_name' => 'admin',
                    'logged_in' => true
                ]);
                echo "<br><a href='" . base_url('dashboard') . "'>Go to Dashboard</a>";
            } else {
                echo "Login gagal!";
            }
        } else {
            echo "Showing login form...<br>";
            return view('test/login');
        }
    }


} 