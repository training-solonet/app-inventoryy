<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BorrowItem;
use App\Models\Borrow;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Query untuk memfilter data berdasarkan pencarian atau tanggal
        $query = Borrow::query();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('borrower_name', 'like', "%$search%")
                ->orWhere('borrow_id', 'like', "%$search%")
                ->orWhereHas('borrowItems.barang', function ($q2) use ($search) {
                    $q2->where('nama_barang', 'like', "%$search%")
                        ->orWhere('kode_barcode', 'like', "%$search%");
                });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('borrow_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('borrow_date', '<=', $request->end_date);
        }

        // Urutkan berdasarkan tanggal peminjaman terbaru (desc)
        $borrows = $query->orderBy('borrow_date', 'desc')->get();

        // Kirim data ke view
        return view('operator.search', compact('borrows'));
    }
}
