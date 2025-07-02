<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function pinjam(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string',
            'nama_peminjam' => 'required|string'
        ]);

        // Cek apakah barang masih dipinjam
        $transaksiAktif = Transaksi::where('kode_barang', $request->kode_barang)
            ->where('status', 'aktif')
            ->first();

        if ($transaksiAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Barang masih dipinjam oleh ' . $transaksiAktif->nama_peminjam,
                'data' => $transaksiAktif
            ], 422);
        }

        $transaksi = Transaksi::create([
            'kode_barang' => $request->kode_barang,
            'nama_peminjam' => $request->nama_peminjam,
            'waktu_pinjam' => Carbon::now(),
            'status' => 'aktif'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dipinjam',
            'data' => $transaksi
        ]);
    }

    public function kembali(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string'
        ]);

        $transaksi = Transaksi::where('kode_barang', $request->kode_barang)
            ->where('status', 'aktif')
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada transaksi aktif untuk barang ini'
            ], 404);
        }

        $transaksi->update([
            'waktu_kembali' => Carbon::now(),
            'status' => 'kembali'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dikembalikan',
            'data' => $transaksi
        ]);
    }
}
