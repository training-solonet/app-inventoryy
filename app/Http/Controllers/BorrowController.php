<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Borrow;
use Illuminate\Support\Facades\Log;

class BorrowController extends Controller
{
    /**
     * Handle the borrowing process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processBorrow(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'borrow_id' => 'required|string|unique:borrows,borrow_id',
            'borrower_name' => 'required|string',
            'borrow_date' => 'required|date',
            'cartData' => 'required|json'
        ]);

        // Decode cartData dari JSON
        $cartData = json_decode($request->cartData, true);

        // Buat peminjaman baru
        $borrow = Borrow::create([
            'borrow_id' => $request->borrow_id,
            'borrower_name' => $request->borrower_name,
            'borrow_date' => $request->borrow_date,
            'status' => 'Sedang Dipinjam'
        ]);

        // Loop melalui setiap item di keranjang dan simpan informasi peminjaman
        foreach ($cartData as $item) {
            // Pastikan Anda memiliki relasi yang sesuai
            $borrow->items()->attach($item['barcode']); // Pastikan barcode ada di cartData
        }

        return response()->json(['success' => true, 'message' => 'Peminjaman berhasil diproses!']);
    }

    /**
     * Generate a unique borrow ID.
     *
     * @return string
     */
    private function generateBorrowId()
    {
        $latestBorrow = Borrow::latest('id')->first();

        $newIdNumber = $latestBorrow ? intval(substr($latestBorrow->borrow_id, -4)) + 1 : 1;
        return 'BORROW' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Display the borrow form with a generated borrow ID.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showBorrowForm()
    {
        $borrowId = $this->generateBorrowId();
        return view('operator.scan', compact('borrowId'));
    }


    /**
     * Get item details by barcode.
     *
     * @param string $barcode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItemDetails($barcode)
    {
        $barang = Barang::where('kode_barcode', $barcode)->first();

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'name' => $barang->nama_barang,
            'barcode' => $barang->kode_barcode,
        ]);
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
