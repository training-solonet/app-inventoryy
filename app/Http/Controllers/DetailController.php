<?php

namespace App\Http\Controllers;

use App\Models\BorrowItem;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function returnBorrowedItem($id)
    {
        $borrowItem = BorrowItem::findOrFail($id);

        // Update status menjadi "Dikembalikan"
        $borrowItem->status = 'Dikembalikan';
        $borrowItem->save();

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
    }
}
