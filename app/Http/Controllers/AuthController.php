<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    
    $user = \App\Models\User::where('email', $credentials['email'])->first();
    
    if ($user && $user->password === $credentials['password']) { 
        Auth::login($user);
        
        if ($user->role == 'admin') {
            return redirect('/dashboard');
        } elseif ($user->role == 'operator') {
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

