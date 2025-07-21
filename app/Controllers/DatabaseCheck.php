<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DatabaseCheck extends Controller
{
    public function index()
    {
        try {
            $db = Database::connect();
            $query = $db->query('SELECT VERSION() as version');
            $row = $query->getRow();

            return view('database_check', [
                'status' => 'Berhasil',
                'message' => 'Koneksi ke database berhasil!',
                'version' => $row->version
            ]);
        } catch (\Exception $e) {
            return view('database_check', [
                'status' => 'Gagal',
                'message' => 'Koneksi ke database gagal: ' . $e->getMessage(),
                'version' => '-'
            ]);
        }
    }
} 