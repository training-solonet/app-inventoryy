<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Memeriksa apakah role pengguna ada dalam daftar role yang diterima
        if (!in_array(Auth::user()->role, $roles)) {
            // Arahkan ke halaman utama jika role tidak sesuai
            return redirect('/');
        }

        return $next($request);
    }
}

