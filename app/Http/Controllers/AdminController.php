<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('barang');

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu_pinjam', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu_pinjam', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->orderBy('waktu_pinjam', 'desc')->paginate(10);

        // Statistik
        $totalTransaksi = Transaksi::count();
        $sedangDipinjam = Transaksi::where('status', 'aktif')->count();
        $sudahKembali = Transaksi::where('status', 'kembali')->count();
        $totalBarang = Barang::count();
        $barangTersedia = Barang::where('status', 'tersedia')->count();

        return view('admin.dashboard', compact(
            'transaksis', 
            'totalTransaksi', 
            'sedangDipinjam', 
            'sudahKembali',
            'totalBarang',
            'barangTersedia'
        ));
    }

    public function exportExcel(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu_pinjam', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu_pinjam', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return Excel::download(new TransaksiExport($query), 'transaksi-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu_pinjam', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu_pinjam', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->orderBy('waktu_pinjam', 'desc')->get();

        $pdf = Pdf::loadView('admin.pdf', compact('transaksis'));
        return $pdf->download('transaksi-' . date('Y-m-d') . '.pdf');
    }
}
