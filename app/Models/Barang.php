<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'kode_barcode',
        'nama_barang',
        'kondisi',
        'jenis',
        'gambar',
    ];

    // Di model BorrowItem
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barcode', 'kode_barcode');
    }
}
