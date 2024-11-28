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

        // Simpan setiap item di keranjang ke tabel `borrow_item`
        foreach ($cartData as $item) {
            $barang = Barang::where('kode_barcode', $item['barcode'])->first();

            if ($barang) {
                BorrowItem::create([
                    'borrow_id' => $borrow->id,
                    'barcode' => $item['barcode'],
                    'status' => 'Sedang Dipinjam',
                    'kondisi' => $barang->kondisi,
                    'gambar' => $barang->gambar
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
            'image' => asset('images/' . $barang->gambar),
            'condition' => $barang->kondisi
        ]);
    }

    public function detail($borrow_id)
    {
        $borrow = Borrow::with('items')->where('borrow_id', $borrow_id)->first();

        if (!$borrow) {
            return redirect()->route('recap')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $borrow->borrow_date = Carbon::parse($borrow->borrow_date)->format('d-m-Y');

        return view('operator.detail', [
            'borrow' => $borrow,
            'items' => $borrow->items
        ]);
    }

    public function returnItem(Request $request, $id)
    {
        $borrowItem = BorrowItem::findOrFail($id);
    
        // Ambil kondisi dari request, defaultnya 'Baik'
        $condition = $request->input('condition', 'Baik');
    
        // Update kondisi dan status di BorrowItem
        $borrowItem->kondisi = $condition;
        $borrowItem->status = 'Dikembalikan';
        $borrowItem->return_date = now();
        $borrowItem->save();
    
        // Cari barang berdasarkan kode barcode
        $barang = Barang::where('kode_barcode', $borrowItem->barcode)->first();
    
        if ($barang) {
            // Perbarui kondisi barang sesuai kondisi pengembalian
            if (in_array($condition, ['Rusak', 'Service', 'Hilang'])) {
                $barang->kondisi = $condition;
                $barang->save();
            }
        }
    
        // Tentukan pesan sukses berdasarkan kondisi
        $message = match ($condition) {
            'Rusak' => 'Barang Dikembalikan dengan kondisi Rusak',
            'Service' => 'Barang Dikembalikan dengan kondisi Service',
            'Hilang' => 'Barang Dikembalikan dengan kondisi Hilang',
            default => 'Barang Dikembalikan dengan kondisi Baik',
        };
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', $message);
    }
    
}
