@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box me-2"></i>Data Barang</h2>
    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Barang
    </a>
</div>

<!-- Filter Section -->
<div class="modern-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.barang.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Barang</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Kode atau nama barang...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="modern-card">
    <div class="card-header-modern">
        <h5><i class="bi bi-table me-2"></i>Daftar Barang</h5>
        <span class="badge bg-primary">{{ $barangs->total() }} barang</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Foto</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                        <tr>
                            <td>
                                @if($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $barang->kode_barang }}</span></td>
                            <td>
                                <strong>{{ $barang->nama_barang }}</strong>
                                @if($barang->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($barang->deskripsi, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($barang->kategori)
                                    <span class="badge bg-info">{{ $barang->kategori }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $barang->stok_tersedia > 0 ? 'success' : 'danger' }}">
                                    {{ $barang->stok_tersedia }}/{{ $barang->stok_total }}
                                </span>
                            </td>
                            <td>
                                @if($barang->kondisi == 'baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($barang->kondisi == 'rusak')
                                    <span class="badge bg-danger">Rusak</span>
                                @else
                                    <span class="badge bg-warning">Maintenance</span>
                                @endif
                            </td>
                            <td>
                                @if($barang->status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.barang.show', $barang) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.barang.edit', $barang) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.barang.destroy', $barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                                <p class="text-muted mt-2">Tidak ada data barang yang ditemukan.</p>
                                <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah Barang Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($barangs->hasPages())
            <div class="d-flex justify-content-center p-3">
                {{ $barangs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection