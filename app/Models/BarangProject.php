<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangProject extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'kode_barcode', // Kode barcode
        'nama_barang', // Nama Barang
        'gambar',      // Gambar
        'kondisi',     // Kondisi
        'qty',         // Quantity
    ];
}
