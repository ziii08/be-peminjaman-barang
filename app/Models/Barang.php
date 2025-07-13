<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang', 
        'deskripsi',
        'kategori',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'lokasi',
        'foto',
        'status'
    ];

    // Relasi dengan transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kode_barang', 'kode_barang');
    }

    // Relasi transaksi aktif
    public function transaksiAktif()
    {
        return $this->hasMany(Transaksi::class, 'kode_barang', 'kode_barang')
                    ->where('status', 'aktif');
    }

    // Check apakah barang bisa dipinjam
    public function bisaDipinjam()
    {
        return $this->status === 'tersedia' && 
               $this->kondisi === 'baik' && 
               $this->stok_tersedia > 0;
    }

    // Update stok saat peminjaman
    public function kurangiStok()
    {
        if ($this->stok_tersedia > 0) {
            $this->decrement('stok_tersedia');
            if ($this->stok_tersedia == 0) {
                $this->update(['status' => 'tidak_tersedia']);
            }
        }
    }

    // Update stok saat pengembalian
    public function tambahStok()
    {
        if ($this->stok_tersedia < $this->stok_total) {
            $this->increment('stok_tersedia');
            if ($this->status === 'tidak_tersedia') {
                $this->update(['status' => 'tersedia']);
            }
        }
    }
}