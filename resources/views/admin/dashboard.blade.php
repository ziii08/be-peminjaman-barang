<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="bi bi-clipboard-data"></i>
                    Dashboard Peminjaman Barang
                </h1>

                <!-- Filter Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="bi bi-funnel"></i> Filter Data</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="tanggal_dari" class="form-label">Tanggal Dari</label>
                                <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari"
                                    value="{{ request('tanggal_dari') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                                <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai"
                                    value="{{ request('tanggal_sampai') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>
                                        Kembali</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Export Buttons -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.export.excel') }}?{{ http_build_query(request()->all()) }}"
                                class="btn btn-success">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </a>
                            <a href="{{ route('admin.export.pdf') }}?{{ http_build_query(request()->all()) }}"
                                class="btn btn-danger">
                                <i class="bi bi-file-earmark-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-table"></i> Data Transaksi ({{ $transaksis->total() }} total)</h5>
                    </div>
                    <div class="card-body">
                        @if ($transaksis->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Peminjam</th>
                                            <th>Waktu Pinjam</th>
                                            <th>Waktu Kembali</th>
                                            <th>Status</th>
                                            <th>Durasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksis as $transaksi)
                                            <tr>
                                                <td>{{ $transaksi->id }}</td>
                                                <td><code>{{ $transaksi->kode_barang }}</code></td>
                                                <td>{{ $transaksi->nama_peminjam }}</td>
                                                <td>{{ $transaksi->waktu_pinjam->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if ($transaksi->waktu_kembali)
                                                        {{ $transaksi->waktu_kembali->format('d/m/Y H:i') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($transaksi->status == 'aktif')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="bi bi-clock"></i> Aktif
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle"></i> Kembali
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($transaksi->waktu_kembali)
                                                        {{ $transaksi->waktu_pinjam->diffForHumans($transaksi->waktu_kembali, true) }}
                                                    @else
                                                        {{ $transaksi->waktu_pinjam->diffForHumans() }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $transaksis->appends(request()->all())->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="mt-3 text-muted">Tidak ada data transaksi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
