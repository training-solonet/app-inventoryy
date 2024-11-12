<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total barang
        $totalBarangs = Barang::count();

        // Menghitung total petugas dengan role 'operator' atau 'admin'
        $totalPetugas = User::where('role', 'operator')->orWhere('role', 'admin')->count();

        // Menghitung total barang yang sedang dipinjam
        $totalBorrowedItems = Borrow::where('status', 'Sedang Dipinjam')->count();

        // Menghitung petugas baru yang ditambahkan dalam 30 hari terakhir
        $recentPetugas = User::where('role', 'operator')
                             ->orWhere('role', 'admin')
                             ->where('created_at', '>=', Carbon::now()->subDays(30))
                             ->count();

        // Menghitung jumlah barang yang pengembaliannya tertunda
        $pendingReturns = Borrow::where('status', 'Tertunda')
                                ->count();

        return view('dashboard', compact('totalBarangs', 'totalPetugas', 'totalBorrowedItems', 'recentPetugas', 'pendingReturns'));
    }
}
