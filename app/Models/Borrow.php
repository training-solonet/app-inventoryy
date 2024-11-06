<?php

// Borrow.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'borrower_name',
        'borrow_date',
        'status',         // Tambahkan kolom status
        'return_date',    // Tambahkan kolom tanggal kembali
    ];
}


