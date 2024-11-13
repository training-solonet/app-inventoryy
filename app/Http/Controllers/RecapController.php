<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        // Mengambil semua data peminjaman dan mengurutkannya berdasarkan tanggal peminjaman terbaru
        $borrows = Borrow::orderBy('borrow_date', 'desc')->get();
        return view('operator.recap', compact('borrows'));
    }

    // Memperbarui tanggal kembali untuk peminjaman tertentu
    public function updateReturnDate($id)
    {
        // Mencari peminjaman berdasarkan ID
        $borrow = Borrow::findOrFail($id);

        // Mengatur tanggal kembali ke waktu sekarang
        $borrow->return_date = now();
        $borrow->save();

        // Mengembalikan respons JSON dengan tanggal kembali yang baru
        return response()->json(['return_date' => $borrow->return_date]);
    }

    // Menampilkan detail peminjaman berdasarkan borrow_id
    public function showDetail($borrow_id)
    {
        // Mencari peminjaman berdasarkan borrow_id
        $borrow = Borrow::where('borrow_id', $borrow_id)->firstOrFail();

        // Mengambil barang yang dipinjam, jika tidak ada, gunakan koleksi kosong
        $items = $borrow->items ?? collect();

        // Mengembalikan view detail dengan data peminjaman dan barang
        return view('operator.detail', compact('borrow', 'items'));
    }

    public function detail($borrow_id)
    {
        $borrow = Borrow::with('items')->where('borrow_id', $borrow_id)->first();

        if (!$borrow) {
            return redirect()->route('recap')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return view('operator.detail', [
            'borrow' => $borrow,
            'items' => $borrow->items
        ]);
    }
}
