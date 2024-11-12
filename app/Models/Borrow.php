<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_id',
        'status',
        'borrow_date',
        'borrower_name',
        'return_date',
    ];

    // Definisikan relasi satu peminjaman bisa memiliki banyak barang
    public function items()
    {
        return $this->belongsToMany(Item::class, 'borrow_item', 'borrow_id', 'barcode');
    }
}
