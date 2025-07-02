<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_peminjam',
        'waktu_pinjam',
        'waktu_kembali',
        'status'
    ];

    protected $casts = [
        'waktu_pinjam' => 'datetime',
        'waktu_kembali' => 'datetime'
    ];
}
