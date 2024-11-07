<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  // Pastikan ada view login di resources/views/auth/login.blade.php
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Cek role pengguna dan arahkan ke halaman yang sesuai
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard');
            } elseif (Auth::user()->role == 'operator') {
                return redirect('/scan');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

