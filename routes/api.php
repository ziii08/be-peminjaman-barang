<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

Route::get('/connect', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API connection is working',
        'timestamp' => now()->toDateTimeString()
    ]);
});

Route::post('/pinjam', [TransaksiController::class, 'pinjam']);
Route::post('/kembali', [TransaksiController::class, 'kembali']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');