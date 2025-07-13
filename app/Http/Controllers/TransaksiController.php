<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('barang')
                              ->orderBy('waktu_pinjam', 'desc')
                              ->paginate(10);
        return view('admin.transaksi.index', compact('transaksis'));
    }
    
    public function create()
    {
        $barangs = Barang::where('status', 'tersedia')
                         ->where('kondisi', 'baik')
                         ->where('stok_tersedia', '>', 0)
                         ->get();
        return view('admin.transaksi.create', compact('barangs'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|exists:barangs,kode_barang',
            'nama_peminjam' => 'required|string|max:255',
            'waktu_pinjam' => 'required|date'
        ]);
        
        $barang = Barang::where('kode_barang', $request->kode_barang)->first();
        
        // Validasi ketersediaan barang
        if (!$barang->bisaDipinjam()) {
            return back()->with('error', 'Barang tidak tersedia untuk dipinjam!');
        }
        
        // Buat transaksi
        $transaksi = Transaksi::create([
            'kode_barang' => $request->kode_barang,
            'nama_peminjam' => $request->nama_peminjam,
            'waktu_pinjam' => $request->waktu_pinjam,
            'status' => 'aktif'
        ]);
        
        // Update stok barang
        $barang->kurangiStok();
        
        return redirect()->route('admin.transaksi.index')
                        ->with('success', 'Transaksi peminjaman berhasil dibuat!');
    }
    
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('barang');
        return view('admin.transaksi.show', compact('transaksi'));
    }
    
    public function kembalikan(Transaksi $transaksi)
    {
        if ($transaksi->status !== 'aktif') {
            return back()->with('error', 'Transaksi sudah selesai!');
        }
        
        $transaksi->update([
            'waktu_kembali' => now(),
            'status' => 'kembali'
        ]);
        
        // Update stok barang
        $barang = Barang::where('kode_barang', $transaksi->kode_barang)->first();
        if ($barang) {
            $barang->tambahStok();
        }
        
        return back()->with('success', 'Barang berhasil dikembalikan!');
    }
}
