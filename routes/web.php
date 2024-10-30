<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});


Route::resource('dashboard', DashboardController::class);
Route::resource('barang', BarangController::class);
Route::resource('user', UserController::class);
Route::resource('peminjaman', PeminjamanController::class);


