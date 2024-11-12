<?php

namespace App\Http\Controllers;
use App\Models\Barang;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function getBarangByBarcode($barcode)
    {
        $barang = Barang::where('kode_barcode', $barcode)->first();

        if ($barang) {
            return response()->json(['nama_barang' => $barang->nama_barang, 'barcode' => $barang->kode_barcode]);
        } else {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }
    }

}
