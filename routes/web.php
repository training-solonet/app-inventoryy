<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleMiddleware; 

// Rute Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
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
    // Rute untuk role operator dan admin
    Route::get('/scan', [BorrowController::class, 'showBorrowForm'])->name('scan')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::get('/recap', [RecapController::class, 'index'])->name('recap')
        ->middleware(RoleMiddleware::class . ':operator,admin');
    Route::get('/items', [BorrowController::class, 'showItems'])->name('items.show')
        ->middleware(RoleMiddleware::class . ':operator,admin');
    Route::get('/borrow/{borrowId}/detail', [RecapController::class, 'showBorrowDetails'])->name('borrow.details')
        ->middleware(RoleMiddleware::class . ':operator,admin');

    // Rute khusus operator
    Route::post('/process-borrow', [BorrowController::class, 'processBorrow'])->name('process.borrow')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::post('/return/{id}', [BorrowController::class, 'updateReturnDate'])->name('update.return')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::post('/borrow/{id}/complete', [BorrowController::class, 'completeBorrow'])->name('complete.borrow')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::post('/add-to-cart', [BorrowController::class, 'addToCart'])->name('add.to.cart')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::get('/get-cart', [BorrowController::class, 'getCart'])->name('get.cart')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::post('/remove-from-cart', [BorrowController::class, 'removeFromCart'])->name('remove.from.cart')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::post('/scan-barcode', [BorrowController::class, 'scanBarcode'])->name('scanBarcode')
        ->middleware(RoleMiddleware::class . ':operator');
    Route::patch('/borrow/{id}/return', [BorrowController::class, 'returnItem'])->name('borrow.return')
        ->middleware(RoleMiddleware::class . ':operator');
});

// Route Resource dengan Pembatasan Role
Route::resource('dashboard', DashboardController::class)
    ->middleware(['auth', RoleMiddleware::class . ':admin']);
Route::resource('barang', BarangController::class)
    ->middleware(['auth', RoleMiddleware::class . ':admin']);
Route::resource('petugas', PetugasController::class)
    ->middleware(['auth', RoleMiddleware::class . ':admin']);
Route::resource('peminjaman', PeminjamanController::class)
    ->middleware(['auth', RoleMiddleware::class . ':operator,admin']);
