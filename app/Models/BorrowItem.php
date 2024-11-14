<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowItem extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'borrow_item';

    // Menentukan kolom yang bisa diisi
    protected $fillable = [
        'borrow_id',
        'barcode',
        'status',
    ];

    // Relasi dengan model Borrow
    public function borrow()
    {
        return $this->belongsTo(Borrow::class, 'borrow_id');
    }

    // Relasi dengan model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barcode', 'kode_barcode');
    }
}

