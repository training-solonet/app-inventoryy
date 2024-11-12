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

    public function borrows()
    {
        return $this->belongsToMany(Borrow::class, 'borrow_barang');
    }
}

