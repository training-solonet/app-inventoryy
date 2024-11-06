<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Borrow;

class BorrowController extends Controller
{
    public function processBorrow(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'barcode' => 'required|string',
            'borrow_date' => 'required|date_format:Y-m-d\TH:i',
            'borrower_name' => 'required|string|max:255',
        ]);

        // Periksa apakah barcode terdaftar di data barang (dengan nama kolom 'kode_barcode')
        $barang = Barang::where('kode_barcode', $validatedData['barcode'])->first();
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang dengan barcode ini tidak terdaftar.'
            ], 400);
        }

        // Periksa apakah barang sedang dipinjam dan belum dikembalikan
        $existingBorrow = Borrow::where('barcode', $validatedData['barcode'])
                                ->where('status', 'Sedang Dipinjam')
                                ->first();

        if ($existingBorrow) {
            return response()->json([
                'success' => false,
                'message' => 'Barang ini masih dalam status dipinjam dan belum dikembalikan.'
            ], 400);
        }

        // Simpan data ke database dengan status "Sedang Dipinjam"
        $borrow = Borrow::create([
            'barcode' => $validatedData['barcode'],
            'borrow_date' => $validatedData['borrow_date'],
            'borrower_name' => $validatedData['borrower_name'],
            'status' => 'Sedang Dipinjam'
        ]);

        // Update session dengan peminjaman terbaru
        $borrowList = session('borrows', []);
        $borrowList[] = $borrow;

        // Urutkan daftar peminjaman berdasarkan tanggal pinjam terbaru
        usort($borrowList, function ($a, $b) {
            return strtotime($b->borrow_date) - strtotime($a->borrow_date);
        });

        // Simpan kembali ke session
        session(['borrows' => $borrowList]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('recap')
        ]);
    }



    public function updateReturnDate($id)
    {
        $borrow = Borrow::find($id);
        if (!$borrow) {
            return response()->json(['error' => 'Data peminjaman tidak ditemukan.'], 404);
        }

        // Mengupdate tanggal kembali dan status
        $borrow->return_date = now(); // Mengatur tanggal kembali ke waktu sekarang
        $borrow->status = 'Dikembalikan'; // Mengubah status
        $borrow->save();

        return response()->json([
            'success' => true,
            'return_date' => $borrow->return_date->format('d-m-Y H:i:s') // Format sesuai yang diinginkan
        ]);
    }


    public function completeBorrow(Request $request, $id)
    {
        $borrow = Borrow::findOrFail($id);

        // Mengubah status dan menyimpan tanggal kembali
        $borrow->status = 'Dikembalikan';
        $borrow->return_date = now();
        $borrow->save();

        // Perbarui sesi
        $borrowList = session('borrows', []);
        foreach ($borrowList as $index => $sessionBorrow) {
            if ($sessionBorrow->id == $borrow->id) {
                $sessionBorrow->status = 'Dikembalikan';
                $sessionBorrow->return_date = $borrow->return_date;
                break;
            }
        }
        session(['borrows' => $borrowList]);

        return response()->json([
            'return_date' => $borrow->return_date->format('d-m-Y H:i:s'),
            'status' => $borrow->status
        ]);
    }


}



