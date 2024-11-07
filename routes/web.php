<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RecapController;

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/', [DashboardController::class, 'dashboard']);
Route::get('/dashboard', [DashboardController::class, 'dashboard']);

Route::get('/scan', function () {
    return view('operator.scan');
});
Route::get('/recap', [RecapController::class, 'index'])->name('recap');
Route::get('/scan', function () {
    return view('operator.scan'); // atau controller yang sesuai
})->name('scan');

Route::post('/process-borrow', [BorrowController::class, 'processBorrow'])->name('process.borrow');
Route::post('/return/{id}', [BorrowController::class, 'updateReturnDate'])->name('update.return');
Route::post('/borrow/{id}/complete', [BorrowController::class, 'completeBorrow'])->name('complete.borrow');




Route::resource('dashboard', DashboardController::class);
Route::resource('barang', BarangController::class);
Route::resource('petugas', PetugasController::class);
Route::resource('peminjaman', PeminjamanController::class);


