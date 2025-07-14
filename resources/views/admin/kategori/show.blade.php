@extends('layouts.admin')

@section('title', 'Detail Kategori Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Kategori: {{ $kategori->nama_kategori }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                @if($kategori->foto)
                                    <img src="{{ asset('storage/' . $kategori->foto) }}" 
                                         alt="{{ $kategori->nama_kategori }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 300px; max-height: 300px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 300px; height: 200px; border-radius: 4px; margin: 0 auto;">
                                        <i class="fas fa-image text-muted fa-5x"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Kategori:</th>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi:</th>
                                    <td>{{ $kategori->deskripsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Barang:</th>
                                    <td><span class="badge badge-info">{{ $kategori->barangs()->count() }} barang</span></td>
                                </tr>
                                <tr>
                                    <th>Dibuat:</th>
                                    <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui:</th>
                                    <td>{{ $kategori->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Barang dalam Kategori -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Barang dalam Kategori</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.barang.create', ['kategori_id' => $kategori->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($barangs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Kode Barang</th>
                                        <th width="25%">Nama Barang</th>
                                        <th width="15%">Merk</th>
                                        <th width="15%">Kondisi</th>
                                        <th width="15%">Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barangs as $index => $barang)
                                        <tr>
                                            <td>{{ $barangs->firstItem() + $index }}</td>
                                            <td>{{ $barang->kode_barang }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->merk ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $barang->kondisi == 'baik' ? 'success' : ($barang->kondisi == 'rusak_ringan' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $barang->kondisi)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $barang->status == 'tersedia' ? 'success' : ($barang->status == 'dipinjam' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($barang->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.barang.show', $barang) }}" 
                                                   class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $barangs->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada barang dalam kategori ini</p>
                            <a href="{{ route('admin.barang.create', ['kategori_id' => $kategori->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Barang Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection