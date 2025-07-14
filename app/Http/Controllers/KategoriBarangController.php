<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBarang::withCount('barangs')
                                  ->orderBy('nama_kategori')
                                  ->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kategori', 'public');
        }

        KategoriBarang::create($data);

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(KategoriBarang $kategori)
    {
        $barangs = $kategori->barangs()->paginate(10);
        return view('admin.kategori.show', compact('kategori', 'barangs'));
    }

    public function edit(KategoriBarang $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBarang $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($kategori->foto) {
                Storage::disk('public')->delete($kategori->foto);
            }
            $data['foto'] = $request->file('foto')->store('kategori', 'public');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(KategoriBarang $kategori)
    {
        if ($kategori->barangs()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                            ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki barang!');
        }

        if ($kategori->foto) {
            Storage::disk('public')->delete($kategori->foto);
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil dihapus!');
    }
}