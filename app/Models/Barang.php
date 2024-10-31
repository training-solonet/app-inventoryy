<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'barcode',
        'kondisi',
        'jenis',
        'tgl_registrasi',
        'gambar',
    ];
}
