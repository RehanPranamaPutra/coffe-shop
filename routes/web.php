<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GajiKaryawanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\TransaksiPembelianController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Protected Routes (memerlukan authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Produk Management (Resource Routes)
    Route::resource('produk', ProdukController::class);

    // Promo Management (Resource Routes)
    Route::resource('promo', PromoController::class);

    // Transaksi Penjualan
    Route::get('/penjualan', [TransaksiPenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [TransaksiPenjualanController::class, 'store'])->name('transaksi.store');
    Route::get('/penjualan/struk/{kode}', [TransaksiPenjualanController::class, 'struk'])->name('transaksi.struk');
    // Transaksi Pembelian
    Route::resource('pembelian', TransaksiPembelianController::class);
    //gaji karyawan
    Route::get('/gaji-karyawan',[GajiKaryawanController::class,'index'])->name('gaji.index');
    Route::post('/gaji-karyawan',[GajiKaryawanController::class,'store'])->name('gaji.store');
    Route::get('/gaji-karyawan/{id}',[GajiKaryawanController::class,'destroy'])->name('gaji.destroy');


});

require __DIR__ . '/auth.php';
