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
        'waktu_kembali' => 'datetime',
    ];

    // Relasi dengan barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    // Accessor untuk format tanggal
    public function getWaktuPinjamFormattedAttribute()
    {
        return $this->waktu_pinjam->format('d/m/Y H:i');
    }

    public function getWaktuKembaliFormattedAttribute()
    {
        return $this->waktu_kembali ? $this->waktu_kembali->format('d/m/Y H:i') : '-';
    }

    public function getDurasiAttribute()
    {
        if ($this->status == 'aktif') {
            $diff = $this->waktu_pinjam->diffInDays(now());
            if ($diff == 0) {
                $hours = $this->waktu_pinjam->diffInHours(now());
                return $hours . ' jam yang lalu';
            } else {
                return $diff . ' hari yang lalu';
            }
        } else {
            if ($this->waktu_kembali) {
                $diff = $this->waktu_pinjam->diffInDays($this->waktu_kembali);
                if ($diff == 0) {
                    $hours = $this->waktu_pinjam->diffInHours($this->waktu_kembali);
                    return $hours . ' jam';
                } else {
                    return $diff . ' hari';
                }
            }
        }
        return '-';
    }

    public function scopeByDateRange($query, $from, $to)
    {
        if ($from) {
            $query->whereDate('waktu_pinjam', '>=', $from);
        }
        if ($to) {
            $query->whereDate('waktu_pinjam', '<=', $to);
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
}
