@extends('layouts.admin')

@section('title', 'Data Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-arrow-left-right me-2"></i>Data Transaksi</h2>
    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Pinjam Barang
    </a>
</div>

<div class="modern-card">
    <div class="card-header-modern">
        <h5><i class="bi bi-table me-2"></i>Daftar Transaksi</h5>
        <span class="badge bg-primary">{{ $transaksis->total() }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Nama Peminjam</th>
                        <th>Waktu Pinjam</th>
                        <th>Waktu Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                        <tr>
                            <td><strong>#{{ $transaksi->id }}</strong></td>
                            <td><span class="badge bg-secondary">{{ $transaksi->kode_barang }}</span></td>
                            <td>{{ $transaksi->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
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
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.transaksi.show', $transaksi) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($transaksi->status == 'aktif')
                                        <form action="{{ route('admin.transaksi.kembalikan', $transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengembalikan barang ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Kembalikan">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                                <p class="text-muted mt-2">Tidak ada data transaksi yang ditemukan.</p>
                                <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Buat Transaksi Pertama
                                </a>
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