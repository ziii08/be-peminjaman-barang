@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-eye me-2"></i>Detail Barang</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.barang.edit', $barang) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5><i class="bi bi-image me-2"></i>Foto Barang</h5>
            </div>
            <div class="card-body text-center">
                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="img-fluid rounded" style="max-height: 300px;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-muted mt-2">Tidak ada foto</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5><i class="bi bi-info-circle me-2"></i>Informasi Barang</h5>
                <div class="d-flex gap-2">
                    @if($barang->status == 'tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Tidak Tersedia</span>
                    @endif
                    
                    @if($barang->kondisi == 'baik')
                        <span class="badge bg-success">Kondisi Baik</span>
                    @elseif($barang->kondisi == 'rusak')
                        <span class="badge bg-danger">Rusak</span>
                    @else
                        <span class="badge bg-warning">Maintenance</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Kode Barang:</td>
                                <td><span class="badge bg-secondary">{{ $barang->kode_barang }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama Barang:</td>
                                <td>{{ $barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kategori:</td>
                                <td>
                                    @if($barang->kategori)
                                        <span class="badge bg-info">{{ $barang->kategori }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Lokasi:</td>
                                <td>{{ $barang->lokasi ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Stok Total:</td>
                                <td><span class="badge bg-primary">{{ $barang->stok_total }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Stok Tersedia:</td>
                                <td><span class="badge bg-{{ $barang->stok_tersedia > 0 ? 'success' : 'danger' }}">{{ $barang->stok_tersedia }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Dibuat:</td>
                                <td>{{ $barang->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Diperbarui:</td>
                                <td>{{ $barang->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($barang->deskripsi)
                    <div class="mt-3">
                        <h6 class="fw-bold">Deskripsi:</h6>
                        <p class="text-muted">{{ $barang->deskripsi }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Transaksi -->
<div class="modern-card mt-4">
    <div class="card-header-modern">
        <h5><i class="bi bi-clock-history me-2"></i>Riwayat Transaksi</h5>
        <span class="badge bg-primary">{{ $transaksis->total() }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Waktu Pinjam</th>
                        <th>Waktu Kembali</th>
                        <th>Status</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->nama_peminjam }}</td>
                            <td>{{ $transaksi->waktu_pinjam->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($transaksi->waktu_kembali)
                                    {{ $transaksi->waktu_kembali->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($transaksi->status == 'aktif')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Kembali
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($transaksi->waktu_kembali)
                                    {{ $transaksi->waktu_pinjam->diffForHumans($transaksi->waktu_kembali, true) }}
                                @else
                                    {{ $transaksi->waktu_pinjam->diffForHumans() }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                <p class="text-muted mt-2">Belum ada riwayat transaksi untuk barang ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transaksis->hasPages())
            <div class="d-flex justify-content-center p-3">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection