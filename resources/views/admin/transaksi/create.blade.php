@extends('layouts.admin')

@section('title', 'Pinjam Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle me-2"></i>Pinjam Barang</h2>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="modern-card">
    <div class="card-header-modern">
        <h5><i class="bi bi-arrow-right me-2"></i>Form Peminjaman Barang</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.transaksi.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" required>
                            <option value="">Pilih Barang</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->kode_barang }}" {{ old('kode_barang') == $barang->kode_barang ? 'selected' : '' }}>
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok_tersedia }})
                                </option>
                            @endforeach
                        </select>
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" 
                               id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" 
                               placeholder="Nama lengkap peminjam" required>
                        @error('nama_peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="waktu_pinjam" class="form-label">Waktu Pinjam <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control @error('waktu_pinjam') is-invalid @enderror" 
                       id="waktu_pinjam" name="waktu_pinjam" value="{{ old('waktu_pinjam', now()->format('Y-m-d\TH:i')) }}" required>
                @error('waktu_pinjam')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Peminjaman
                </button>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Info Barang Tersedia -->
@if($barangs->count() > 0)
    <div class="modern-card mt-4">
        <div class="card-header-modern">
            <h5><i class="bi bi-info-circle me-2"></i>Barang Tersedia</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($barangs->take(6) as $barang)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title">{{ $barang->nama_barang }}</h6>
                                <p class="card-text">
                                    <span class="badge bg-secondary">{{ $barang->kode_barang }}</span><br>
                                    <small class="text-muted">Stok: {{ $barang->stok_tersedia }}/{{ $barang->stok_total }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($barangs->count() > 6)
                <div class="text-center">
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-primary">
                        Lihat Semua Barang ({{ $barangs->count() }})
                    </a>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-warning mt-4">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Tidak ada barang yang tersedia untuk dipinjam. 
        <a href="{{ route('admin.barang.create') }}" class="alert-link">Tambah barang baru</a>
    </div>
@endif
@endsection