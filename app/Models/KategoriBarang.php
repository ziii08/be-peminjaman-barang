<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'foto'
    ];

    // Relasi dengan barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }

    // Hitung total barang per kategori
    public function getTotalBarangAttribute()
    {
        return $this->barangs()->count();
    }

    // Hitung barang tersedia per kategori
    public function getBarangTersediaAttribute()
    {
        return $this->barangs()->where('status', 'tersedia')->count();
    }

    // Hitung barang dipinjam per kategori
    public function getBarangDipinjamAttribute()
    {
        return $this->barangs()->where('status', 'dipinjam')->count();
    }
}