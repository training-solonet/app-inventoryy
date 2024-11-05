<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


// Route::resource('dashboard', controller: DashboardController::class);
Route::resource('barang', BarangController::class);
Route::resource('petugas', PetugasController::class);
Route::resource('peminjaman', PeminjamanController::class);
Route::resource('login', controller: SesiController::class);


Route::middleware('guest')->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});
// Route::get('/home',function () {
//     return redirect('/admin');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/operator', [AdminController::class, 'operator'])->middleware('userAkses:operator');
    Route::get('/logout', [SesiController::class, 'logout']);
});