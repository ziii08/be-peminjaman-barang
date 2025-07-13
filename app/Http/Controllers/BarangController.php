<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $barangs = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategoris = Barang::distinct()->pluck('kategori')->filter();
        
        return view('admin.barang.index', compact('barangs', 'kategoris'));
    }
    
    public function create()
    {
        return view('admin.barang.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak,maintenance',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->all();
        $data['stok_tersedia'] = $request->stok_total;
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }
        
        Barang::create($data);
        
        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil ditambahkan!');
    }
    
    public function show(Barang $barang)
    {
        $transaksis = $barang->transaksis()->orderBy('waktu_pinjam', 'desc')->paginate(5);
        return view('admin.barang.show', compact('barang', 'transaksis'));
    }
    
    public function edit(Barang $barang)
    {
        return view('admin.barang.edit', compact('barang'));
    }
    
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak,maintenance',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }
        
        // Update stok tersedia jika stok total berubah
        if ($request->stok_total != $barang->stok_total) {
            $selisih = $request->stok_total - $barang->stok_total;
            $data['stok_tersedia'] = max(0, $barang->stok_tersedia + $selisih);
        }
        
        $barang->update($data);
        
        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil diperbarui!');
    }
    
    public function destroy(Barang $barang)
    {
        // Cek apakah ada transaksi aktif
        if ($barang->transaksiAktif()->count() > 0) {
            return redirect()->route('admin.barang.index')
                            ->with('error', 'Tidak dapat menghapus barang yang sedang dipinjam!');
        }
        
        // Hapus foto
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }
        
        $barang->delete();
        
        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil dihapus!');
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        $barangs = Barang::where('kode_barang', 'like', "%{$query}%")
                         ->orWhere('nama_barang', 'like', "%{$query}%")
                         ->where('status', 'tersedia')
                         ->where('kondisi', 'baik')
                         ->where('stok_tersedia', '>', 0)
                         ->limit(10)
                         ->get(['id', 'kode_barang', 'nama_barang', 'stok_tersedia']);
        
        return response()->json($barangs);
    }
}