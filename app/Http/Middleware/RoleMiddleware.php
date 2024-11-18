<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Memeriksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['message' => 'Anda harus login untuk mengakses halaman ini.']);
        }

        // Memeriksa apakah role pengguna ada dalam daftar role yang diterima
        if (!in_array(Auth::user()->role, $roles)) {
            // Arahkan ke halaman yang tidak berizin atau halaman utama jika role tidak sesuai
            return redirect('/unauthorized')->withErrors(['message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.']);
        }

        return $next($request);
    }
}
