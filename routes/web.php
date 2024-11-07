<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Menampilkan form login
Route::post('/login', [AuthController::class, 'login']); // Menangani POST request untuk login

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    if (Auth::user()->role == 'admin') {
        return redirect('/dashboard');
    } elseif (Auth::user()->role == 'operator') {
        return redirect('/scan');
    }

    return redirect('/');
});


Route::get('/', function () {
    return view('dashboard');
});
Route::get('/scan', function () {
    return view('operator.scan');
});
Route::get('/recap', [RecapController::class, 'index'])->name('recap');
Route::get('/scan', function () {
    return view('operator.scan'); // atau controller yang sesuai
})->name('scan');

Route::get('/get-barang/{barcode}', [BarangController::class, 'getBarang']);

Route::post('/process-borrow', [BorrowController::class, 'processBorrow'])->name('process.borrow');
Route::post('/return/{id}', [BorrowController::class, 'updateReturnDate'])->name('update.return');
Route::post('/borrow/{id}/complete', [BorrowController::class, 'completeBorrow'])->name('complete.borrow');

Route::resource('dashboard', DashboardController::class);
Route::resource('barang', BarangController::class);
Route::resource('petugas', PetugasController::class);
Route::resource('peminjaman', PeminjamanController::class);


