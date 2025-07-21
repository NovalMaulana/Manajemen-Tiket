<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Silakan login terlebih dahulu');
        }

        // Jika arguments (roles) diberikan, periksa role user
        if ($arguments !== null) {
            $userRole = session()->get('role_name');
            if (!in_array($userRole, $arguments)) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 