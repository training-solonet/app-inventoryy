<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        return view('operator.index'); // Pastikan view ada di resources/views/operator/index.blade.php
    }
}
