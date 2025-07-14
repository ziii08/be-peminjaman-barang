<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'kategori_id',
        'nama_barang',
        'deskripsi',
        'merk',
        'model',
        'serial_number',
        'tahun_pembelian',
        'harga_beli',
        'kondisi',
        'lokasi',
        'foto',
        'status',
        'catatan'
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'tahun_pembelian' => 'integer'
    ];

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    // Relasi dengan transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kode_barang', 'kode_barang');
    }

    // Relasi transaksi aktif
    public function transaksiAktif()
    {
        return $this->hasOne(Transaksi::class, 'kode_barang', 'kode_barang')
                    ->where('status', 'aktif')
                    ->latest();
    }

    // Check apakah barang bisa dipinjam
    public function bisaDipinjam()
    {
        return $this->status === 'tersedia' && 
               $this->kondisi === 'baik';
    }

    // Update status saat peminjaman
    public function pinjam()
    {
        $this->update(['status' => 'dipinjam']);
    }

    // Update status saat pengembalian
    public function kembalikan()
    {
        $this->update(['status' => 'tersedia']);
    }

    // Generate kode barang otomatis
    public static function generateKodeBarang($kategoriId)
    {
        $kategori = KategoriBarang::find($kategoriId);
        $prefix = strtoupper(substr($kategori->nama_kategori, 0, 3));
        
        // Cari nomor terakhir untuk kategori ini
        $lastBarang = self::where('kategori_id', $kategoriId)
                         ->where('kode_barang', 'like', $prefix . '%')
                         ->orderBy('kode_barang', 'desc')
                         ->first();
        
        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_barang, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Scope untuk filter
    public function scopeByKategori($query, $kategoriId)
    {
        if ($kategoriId) {
            return $query->where('kategori_id', $kategoriId);
        }
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeByKondisi($query, $kondisi)
    {
        if ($kondisi) {
            return $query->where('kondisi', $kondisi);
        }
        return $query;
    }
}