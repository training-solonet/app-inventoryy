<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecapController extends Controller
{
    // Menampilkan daftar peminjaman dengan pagination dan filter tanggal peminjaman
    public function index(Request $request)
    {
        $query = Borrow::query();

        // Filter berdasarkan tanggal mulai
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('borrow_date', '>=', Carbon::parse($request->start_date)->startOfDay());
        }

        // Filter berdasarkan tanggal akhir
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('borrow_date', '<=', Carbon::parse($request->end_date)->endOfDay());
        }

        // Filter berdasarkan pencarian nama peminjam, ID peminjaman, nama barang, atau kode barcode
        if ($request->has('search') && $request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('borrower_name', 'like', '%' . $request->search . '%')
                    ->orWhere('borrow_id', 'like', '%' . $request->search . '%')
                    ->orWhereHas('borrowItems', function ($q) use ($request) {
                        $q->whereHas('barang', function ($q2) use ($request) {
                            $q2->where('kode_barcode', 'like', '%' . $request->search . '%')
                                ->orWhere('nama_barang', 'like', '%' . $request->search . '%');
                        });
                    });
            });
        }

        // Filter berdasarkan status
        $status = $request->input('status', 'Semua'); // Default to "Sedang Dipinjam"
        if ($status !== 'Semua') {
            if ($status == 'Sedang Dipinjam') {
                $query->whereHas('borrowItems', function ($q) {
                    $q->where('status', 'Sedang Dipinjam');
                });
            } else {
                $query->whereDoesntHave('borrowItems', function ($q) {
                    $q->where('status', 'Sedang Dipinjam');
                });
            }
        }

        // Urutkan data terbaru di paling atas
        $borrows = $query->orderBy('borrow_date', 'desc')->paginate(5);

        // Menghitung jumlah barang yang belum dikembalikan berdasarkan barcode dan status 'Sedang Dipinjam'
        $unreturnedItemsCount = BorrowItem::where('status', 'Sedang Dipinjam')
            ->whereHas('barang', function ($q) {
                $q->whereNotNull('kode_barcode');
            })->count();

        return view('operator.recap', compact('borrows', 'unreturnedItemsCount'));
    }





    // Memperbarui tanggal kembali untuk peminjaman tertentu
    public function updateReturnDate($id)
    {
        $borrow = Borrow::findOrFail($id);

        // Mengatur tanggal kembali ke waktu sekarang
        $borrow->return_date = now();
        $borrow->save();

        return response()->json(['return_date' => $borrow->return_date]);
    }

    // Menampilkan detail peminjaman berdasarkan borrow_id
    public function showBorrowDetails($borrowId)
    {
        // Gunakan eager loading untuk memuat relasi 'borrowItems' dan 'barang'
        $borrow = Borrow::with('borrowItems.barang')->where('borrow_id', $borrowId)->first();

        // Jika peminjaman tidak ditemukan, tampilkan 404 atau redirect dengan pesan error
        if (!$borrow) {
            return redirect()->route('recap')->with('error', 'Peminjaman tidak ditemukan');
        }

        return view('operator.detail', compact('borrow'));
    }





    // Menampilkan detail peminjaman
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
