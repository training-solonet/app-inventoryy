<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('tb_peminjaman',[
            "active" => 'peminjaman'
        ]);
    }
}
