<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        
        $barangs = $query->orderBy('created_at', 'desc')->paginate(15);
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();
        
        return view('admin.barang.index', compact('barangs', 'kategoris'));
    }
    
    public function create()
    {
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();
        return view('admin.barang.create', compact('kategoris'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'merk' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'tahun_pembelian' => 'nullable|integer|min:1900|max:' . date('Y'),
            'harga_beli' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak,maintenance',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string'
        ]);
        
        $data = $request->all();
        
        // Generate kode barang otomatis
        $data['kode_barang'] = Barang::generateKodeBarang($request->kategori_id);
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }
        
        Barang::create($data);
        
        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil ditambahkan dengan kode: ' . $data['kode_barang']);
    }
    
    public function show(Barang $barang)
    {
        $barang->load('kategori');
        $transaksis = $barang->transaksis()->orderBy('waktu_pinjam', 'desc')->paginate(5);
        return view('admin.barang.show', compact('barang', 'transaksis'));
    }
    
    public function edit(Barang $barang)
    {
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }
    
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'merk' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'tahun_pembelian' => 'nullable|integer|min:1900|max:' . date('Y'),
            'harga_beli' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak,maintenance',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string'
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }
        
        $barang->update($data);
        
        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil diperbarui!');
    }
    
    public function destroy(Barang $barang)
    {
        if ($barang->transaksiAktif) {
            return redirect()->route('admin.barang.index')
                            ->with('error', 'Tidak dapat menghapus barang yang sedang dipinjam!');
        }
        
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
        $barangs = Barang::with('kategori')
                         ->where('kode_barang', 'like', "%{$query}%")
                         ->orWhere('nama_barang', 'like', "%{$query}%")
                         ->where('status', 'tersedia')
                         ->where('kondisi', 'baik')
                         ->limit(10)
                         ->get(['id', 'kode_barang', 'nama_barang', 'kategori_id']);
        
        return response()->json($barangs);
    }
    
    public function generateBarcode(Barang $barang)
    {
        // Implementasi generate barcode jika diperlukan
        return view('admin.barang.barcode', compact('barang'));
    }
}