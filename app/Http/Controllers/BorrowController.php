<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\BorrowItem;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

        // Cek apakah ada barang yang masih dipinjam
        foreach ($cartData as $item) {
            // Cek apakah barang dengan barcode yang dipilih masih dalam status "Sedang Dipinjam"
            $isBorrowed = BorrowItem::where('barcode', $item['barcode'])
                ->where('status', 'Sedang Dipinjam')
                ->exists();

            if ($isBorrowed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang dengan barcode ' . $item['barcode'] . ' masih dipinjam dan tidak bisa dipinjam kembali.'
                ]);
            }
        }

        // Buat peminjaman baru
        $borrow = Borrow::create([
            'borrow_id' => $request->borrow_id,
            'borrower_name' => $request->borrower_name,
            'borrow_date' => $request->borrow_date,
            'status' => 'Sedang Dipinjam'
        ]);

        // Simpan setiap item di keranjang ke tabel `borrow_item` melalui model `BorrowItem`
        foreach ($cartData as $item) {
            // Ambil data barang berdasarkan barcode
            $barang = Barang::where('kode_barcode', $item['barcode'])->first();

            if ($barang) {
                // Simpan item yang dipinjam beserta kondisi dan gambar
                BorrowItem::create([
                    'borrow_id' => $borrow->id,
                    'barcode' => $item['barcode'],
                    'status' => 'Sedang Dipinjam',
                    'kondisi' => $barang->kondisi,  // Menyimpan kondisi barang
                    'gambar' => $barang->gambar     // Menyimpan gambar barang
                ]);
            }
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
            'image' => asset('images/' . $barang->gambar),  // Return image path
            'condition' => $barang->kondisi  // Return condition
        ]);
    }


    public function detail($borrow_id)
    {
        $borrow = Borrow::with('items')->where('borrow_id', $borrow_id)->first();

        if (!$borrow) {
            return redirect()->route('recap')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        // Format tanggal peminjaman dengan Carbon
        $borrow->borrow_date = Carbon::parse($borrow->borrow_date)->format('d-m-Y');

        return view('operator.detail', [
            'borrow' => $borrow,
            'items' => $borrow->items
        ]);
    }


    // In BorrowController.php
    public function returnItem(Request $request, $id)
    {
        $borrowItem = BorrowItem::findOrFail($id);

        // Mendapatkan kondisi dari request
        $condition = $request->input('condition', 'Baik'); // default 'Baik'

        // Update kondisi barang pada borrow item
        $borrowItem->kondisi = $condition;
        $borrowItem->status = 'Dikembalikan';  // Update status menjadi "Dikembalikan"
        $borrowItem->return_date = now();  // Set tanggal kembali
        $borrowItem->save();

        // Jika kondisi barang adalah "Rusak", update kondisi di tabel barangs juga
        if ($condition === 'Rusak') {
            $barang = Barang::where('kode_barcode', $borrowItem->barcode)->first();
            if ($barang) {
                $barang->kondisi = 'Rusak';
                $barang->save();
            }
        }

        // Tentukan pesan yang akan ditampilkan
        $message = ($condition === 'Rusak') ? 'Barang Dikembalikan dengan kondisi Rusak' : 'Barang Dikembalikan dengan kondisi Baik';

        // Kirimkan pesan sukses ke session
        return redirect()->back()->with('success', $message);
    }
}
