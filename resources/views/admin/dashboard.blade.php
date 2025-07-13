<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Peminjaman</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #dbeafe;
            --dark-blue: #1e40af;
            --accent-blue: #3b82f6;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
            --border-color: #e5e7eb;
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: var(--text-dark);
        }

        .main-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            color: white;
            padding: 1rem 0;
            margin-bottom: 1rem;
            border-radius: 0 0 0.5rem 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-header h1 {
            font-weight: 600;
            font-size: 1.8rem;
            margin: 0;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .main-header .subtitle {
            opacity: 0.9;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .modern-card {
            background: white;
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header-modern {
            background: linear-gradient(135deg, var(--light-blue) 0%, rgba(59, 130, 246, 0.1) 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .card-header-modern h5 {
            color: var(--primary-blue);
            font-weight: 600;
            margin: 0;
            font-size: 1rem;
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-sm-modern {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-filter {
            background: var(--primary-blue);
            color: white;
        }

        .btn-filter:hover {
            background: var(--dark-blue);
            color: white;
        }

        .btn-excel {
            background: #10b981;
            color: white;
        }

        .btn-excel:hover {
            background: #059669;
            color: white;
        }

        .btn-pdf {
            background: #ef4444;
            color: white;
        }

        .btn-pdf:hover {
            background: #dc2626;
            color: white;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary-modern {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            color: var(--text-light);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary-modern:hover {
            background: var(--bg-light);
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0 0 0.5rem 0.5rem;
            font-size: 0.875rem;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 0.75rem;
            border: none;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
        }

        .table-modern tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
        }

        .table-modern tbody td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-active {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .status-returned {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .stat-card {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 3px solid var(--primary-blue);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 0;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .code-highlight {
            background: linear-gradient(135deg, var(--light-blue) 0%, rgba(59, 130, 246, 0.1) 100%);
            color: var(--primary-blue);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .pagination .page-link {
            border: none;
            color: var(--primary-blue);
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background: var(--light-blue);
            color: var(--primary-blue);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-blue);
            color: white;
        }

        .modal-content {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--light-blue) 0%, rgba(59, 130, 246, 0.1) 100%);
            border-bottom: 1px solid var(--border-color);
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .modal-title {
            color: var(--primary-blue);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .main-header h1 {
                font-size: 1.5rem;
            }

            .main-header .subtitle {
                font-size: 0.8rem;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .header-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .card-header-modern {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    @extends('layouts.admin')

    @section('title', 'Dashboard')

    @section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-data text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0 text-primary">{{ number_format($totalTransaksi) }}</h4>
                    <small class="text-muted">Total Transaksi</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0 text-warning">{{ number_format($sedangDipinjam) }}</h4>
                    <small class="text-muted">Sedang Dipinjam</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0 text-success">{{ number_format($sudahKembali) }}</h4>
                    <small class="text-muted">Sudah Kembali</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <i class="bi bi-box text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0 text-info">{{ number_format($totalBarang ?? 0) }}</h4>
                    <small class="text-muted">Total Barang</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <i class="bi bi-check2-square text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0 text-success">{{ number_format($barangTersedia ?? 0) }}</h4>
                    <small class="text-muted">Barang Tersedia</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-plus-circle me-1"></i>Pinjam Barang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="modern-card">
        <div class="card-header-modern">
            <h5><i class="bi bi-table me-2"></i>Data Transaksi Terbaru</h5>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <form action="{{ route('admin.export.excel') }}" method="GET" class="d-inline">
                    @if(request('tanggal_dari'))
                        <input type="hidden" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                    @endif
                    @if(request('tanggal_sampai'))
                        <input type="hidden" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                    @endif
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                    </button>
                </form>
                <form action="{{ route('admin.export.pdf') }}" method="GET" class="d-inline">
                    @if(request('tanggal_dari'))
                        <input type="hidden" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                    @endif
                    @if(request('tanggal_sampai'))
                        <input type="hidden" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                    @endif
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>NO</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Nama Peminjam</th>
                            <th>Waktu Pinjam</th>
                            <th>Waktu Kembali</th>
                            <th>Status</th>
                            <th>Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $transaksi)
                            <tr>
                                <td><strong>{{ $transaksis->firstItem() + $index }}</strong></td>
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
                                    @if($transaksi->waktu_kembali)
                                        {{ $transaksi->waktu_pinjam->diffForHumans($transaksi->waktu_kembali, true) }}
                                    @else
                                        {{ $transaksi->waktu_pinjam->diffForHumans() }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <p class="text-muted mt-2">Tidak ada data transaksi yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transaksis->hasPages())
                <div class="d-flex justify-content-center p-3">
                    {{ $transaksis->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Dari</label>
                                <input type="date" class="form-control" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Sampai</label>
                                <input type="date" class="form-control" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function applyFilter() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
            modal.hide();

            // Submit form
            document.getElementById('filterForm').submit();
        }

        function resetFilter() {
            document.getElementById('filterForm').reset();
            // Redirect ke halaman tanpa filter
            window.location.href = "{{ route('admin.dashboard') }}";
        }

        // Auto refresh functionality
        {{-- function setupAutoRefresh(seconds) {
            // Store current scroll position before refresh
            sessionStorage.setItem('scrollPosition', window.scrollY);
            
            // Set timeout for refresh
            setTimeout(function() {
                // Get current URL with all query parameters
                const currentUrl = window.location.href;
                window.location.href = currentUrl;
            }, seconds * 1000);
        }
        
        // Initialize auto refresh (10 seconds)
        setupAutoRefresh(10); --}}
    </script>
</body>

</html>
