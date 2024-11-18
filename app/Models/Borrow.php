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

    // Borrow.php
    public function borrowItems()
    {
        return $this->hasMany(BorrowItem::class, 'borrow_id', 'id');
    }
}
