<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\TransaksiController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/admin');
});

// Admin Routes (protected by admin middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');
    
    // Kategori Barang Management
    Route::resource('kategori', KategoriBarangController::class)->names([
        'index' => 'admin.kategori.index',
        'create' => 'admin.kategori.create',
        'store' => 'admin.kategori.store',
        'show' => 'admin.kategori.show',
        'edit' => 'admin.kategori.edit',
        'update' => 'admin.kategori.update',
        'destroy' => 'admin.kategori.destroy'
    ]);
    
    // Barang Management
    Route::resource('barang', BarangController::class)->names([
        'index' => 'admin.barang.index',
        'create' => 'admin.barang.create',
        'store' => 'admin.barang.store',
        'show' => 'admin.barang.show',
        'edit' => 'admin.barang.edit',
        'update' => 'admin.barang.update',
        'destroy' => 'admin.barang.destroy'
    ]);
    Route::get('/barang-search', [BarangController::class, 'search'])->name('admin.barang.search');
    Route::get('/barang/{barang}/barcode', [BarangController::class, 'generateBarcode'])->name('admin.barang.barcode');
    
    // Transaksi Management
    Route::resource('transaksi', TransaksiController::class)->names([
        'index' => 'admin.transaksi.index',
        'create' => 'admin.transaksi.create',
        'store' => 'admin.transaksi.store',
        'show' => 'admin.transaksi.show'
    ]);
    Route::patch('/transaksi/{transaksi}/kembalikan', [TransaksiController::class, 'kembalikan'])
         ->name('admin.transaksi.kembalikan');
});
