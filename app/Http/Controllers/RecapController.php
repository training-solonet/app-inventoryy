<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    public function index()
    {
        $borrows = Borrow::orderBy('borrow_date', 'desc')->get();
        return view('operator.recap', compact('borrows'));
    }

    public function updateReturnDate($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->return_date = now();
        $borrow->save(); 

        return response()->json(['return_date' => $borrow->return_date]);
    }
}



