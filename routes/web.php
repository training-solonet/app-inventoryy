<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rute Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Pengalihan Berdasarkan Role Pengguna
Route::get('/home', function () {
    if (Auth::user()->role == 'admin') {
        return redirect('/dashboard');
    } elseif (Auth::user()->role == 'operator') {
        return redirect('/scan');
    }
    return redirect('/');
})->middleware('auth');

// Halaman Utama
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

// Rute dalam Grup Middleware Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/scan', [BorrowController::class, 'showBorrowForm'])->name('scan');
    Route::get('/recap', [RecapController::class, 'index'])->name('recap');
    Route::get('/items', [BorrowController::class, 'showItems'])->name('items.show');
    Route::post('/process-borrow', [BorrowController::class, 'processBorrow'])->name('process.borrow');
    Route::post('/return/{id}', [BorrowController::class, 'updateReturnDate'])->name('update.return');
    Route::post('/borrow/{id}/complete', [BorrowController::class, 'completeBorrow'])->name('complete.borrow');
    Route::post('/add-to-cart', [BorrowController::class, 'addToCart'])->name('add.to.cart');
    Route::get('/get-cart', [BorrowController::class, 'getCart'])->name('get.cart');
    Route::post('/remove-from-cart', [BorrowController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::post('/scan-barcode', [BorrowController::class, 'scanBarcode'])->name('scanBarcode');
    Route::post('/borrow/add-to-cart', [BorrowController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/borrow/process', [BorrowController::class, 'processBorrow'])->name('process.borrow');
    Route::get('/get-item-details/{barcode}', [BorrowController::class, 'getItemDetails']);
    Route::post('/borrow/remove-from-cart', [BorrowController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::get('/borrow', [BorrowController::class, 'showBorrowForm'])->name('show.borrow.form');
    Route::get('/borrow/{borrow_id}/detail', [RecapController::class, 'showDetail'])->name('borrow.detail');
    Route::post('/borrow/complete/{id}', [RecapController::class, 'updateReturnDate'])->name('complete.borrow');

});

// Route Resource
Route::resource('dashboard', DashboardController::class)->middleware('auth');
Route::resource('barang', BarangController::class)->middleware('auth');
Route::resource('petugas', PetugasController::class)->middleware('auth');
Route::resource('peminjaman', PeminjamanController::class)->middleware('auth');
