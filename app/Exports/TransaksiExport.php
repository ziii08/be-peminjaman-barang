<?php
// app/Exports/TransaksiExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $query;
    protected $counter = 0;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query->orderBy('waktu_pinjam', 'desc');
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Peminjam',
            'Waktu Pinjam',
            'Waktu Kembali',
            'Status',
            'Durasi (Menit)'
        ];
    }

    public function map($transaksi): array
    {
        $this->counter++;
        
        $durasi = '';
        if ($transaksi->waktu_kembali) {
            $durasi = $transaksi->waktu_pinjam->diffInMinutes($transaksi->waktu_kembali) . ' menit';
        }

        return [
            $this->counter,
            $transaksi->kode_barang,
            $transaksi->nama_peminjam,
            $transaksi->waktu_pinjam->format('d/m/Y H:i:s'),
            $transaksi->waktu_kembali ? $transaksi->waktu_kembali->format('d/m/Y H:i:s') : '',
            ucfirst($transaksi->status),
            $durasi
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}