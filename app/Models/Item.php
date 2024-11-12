<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'items'; // Hanya jika nama tabel bukan 'items'

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'barcode',        // Pastikan kolom ini ada di tabel
        'nama_barang',    // Pastikan kolom ini ada di tabel
    ];

    // Definisikan relasi ke Borrow jika diperlukan
    public function borrows()
    {
        return $this->belongsToMany(Borrow::class, 'borrow_item', 'barcode', 'borrow_id');
    }
}
