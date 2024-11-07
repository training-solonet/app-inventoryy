<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarangs = Barang::count(); // Menghitung total data barang

        return view('dashboard', [
            "totalBarangs" => $totalBarangs // Mengirimkan ke view dashboard
        ]);
    }
    public function dashboard()
{
    $totalBarangs = Barang::count();
    return view('dashboard', compact('totalBarangs'));
}

}

