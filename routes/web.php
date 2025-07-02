<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');
});
