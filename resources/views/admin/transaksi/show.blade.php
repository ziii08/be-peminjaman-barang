@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-eye me-2"></i>Detail Transaksi #{{ $transaksi->id }}</h2>
    <div class="d-flex gap-2">
        @if($transaksi->status == 'aktif')
            <form action="{{ route('admin.transaksi.kembalikan', $transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengembalikan barang ini?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i>Kembalikan Barang
                </button>
            </form>
        @endif
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5><i class="bi bi-info-circle me-2"></i>Informasi Transaksi</h5>
                @if($transaksi->status == 'aktif')
                    <span class="badge bg-warning">Aktif</span>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">ID Transaksi:</td>
                        <td><span class="badge bg-primary">#{{ $transaksi->id }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Nama Peminjam:</td>
                        <td>{{ $transaksi->nama_peminjam }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Waktu Pinjam:</td>
                        <td>{{ $transaksi->waktu_pinjam->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Waktu Kembali:</td>
                        <td>
                            @if($transaksi->waktu_kembali)
                                {{ $transaksi->waktu_kembali->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Belum dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Durasi:</td>
                        <td>
                            @if($transaksi->waktu_kembali)
                                {{ $transaksi->waktu_pinjam->diffForHumans($transaksi->waktu_kembali, true) }}
                            @else
                                {{ $transaksi->waktu_pinjam->diffForHumans() }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status:</td>
                        <td>
                            @if($transaksi->status == 'aktif')
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock me-1"></i>Sedang Dipinjam
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Sudah Dikembalikan
                                </span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5><i class="bi bi-box me-2"></i>Informasi Barang</h5>
            </div>
            <div class="card-body">
                @if($transaksi->barang)
                    <div class="d-flex align-items-start">
                        @if($transaksi->barang->foto)
                            <img src="{{ asset('storage/' . $transaksi->barang->foto) }}" alt="{{ $transaksi->barang->nama_barang }}" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $transaksi->barang->nama_barang }}</h6>
                            <p class="mb-1">
                                <span class="badge bg-secondary">{{ $transaksi->barang->kode_barang }}</span>
                                @if($transaksi->barang->kategori)
                                    <span class="badge bg-info">{{ $transaksi->barang->kategori }}</span>
                                @endif
                            </p>
                            <small class="text-muted">
                                Stok: {{ $transaksi->barang->stok_tersedia }}/{{ $transaksi->barang->stok_total }}
                            </small>
                        </div>
                    </div>
                    
                    @if($transaksi->barang->deskripsi)
                        <hr>
                        <p class="text-muted mb-0">{{ $transaksi->barang->deskripsi }}</p>
                    @endif
                    
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Lokasi: {{ $transaksi->barang->lokasi ?? '-' }}</small>
                        <a href="{{ route('admin.barang.show', $transaksi->barang) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye me-1"></i>Detail Barang
                        </a>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Data barang tidak ditemukan atau telah dihapus.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection