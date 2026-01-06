<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VarianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GajiKaryawanController;
use App\Http\Controllers\TransaksiPembelianController;
use App\Http\Controllers\TransaksiPenjualanController;

// Landing Page
Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/menu', 'menu')->name('menu');

    Route::get('/promo', 'promo')->name('promo.landing');
    Route::get('/tentang', 'about')->name('about');
    Route::get('/kontak', 'contact')->name('contact');
});

Route::get('/menu/{slug}',[PublicController::class,'menuShow'])->name('menu.show');
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

    Route::resource('kategori', CategoryController::class);

    // Produk Management (Resource Routes)
    Route::resource('produk', ProdukController::class);
    Route::resource('produk.varian', VarianController::class);

    // Promo Management (Resource Routes)
    Route::resource('promo', PromoController::class);

    // Transaksi Penjualan
    Route::get('/penjualan', [TransaksiPenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [TransaksiPenjualanController::class, 'store'])->name('transaksi.store');
    Route::get('/penjualan/struk/{kode}', [TransaksiPenjualanController::class, 'struk'])->name('transaksi.struk');

    // Transaksi Pembelian

    Route::resource('pembelian', TransaksiPembelianController::class);
    Route::get('/gaji-karyawan',[GajiKaryawanController::class,'index'])->name('gaji.index');
    Route::post('/gaji-karyawan',[GajiKaryawanController::class,'store'])->name('gaji.store');
    Route::delete('/gaji-karyawan/{id}',[GajiKaryawanController::class,'destroy'])->name('gaji.destroy');

    Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
});
Route::get('/force-seed', function () {
    try {
        // Kita pakai migrate:fresh agar database BERSIH TOTAL sebelum diisi seeder
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        return "Database Berhasil Di-Reset & Di-Seed! <pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "Gagal Reset Database. Error: " . $e->getMessage();
    }
});

require __DIR__ . '/auth.php';
