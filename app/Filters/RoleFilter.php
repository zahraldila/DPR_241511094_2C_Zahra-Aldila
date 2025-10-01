<?php

namespace App\Filters;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before($request, $arguments = null)
    {
        $session = session();
        $requiredRole = $arguments[0] ?? null;

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($requiredRole && $session->get('role') !== $requiredRole) {
            // Bisa diarahkan ke 403 atau dashboard sesuai role
            return redirect()->to('/forbidden');
        }
    }

    public function after($request, $response, $arguments = null)
    {
        // no-op
    }
}
