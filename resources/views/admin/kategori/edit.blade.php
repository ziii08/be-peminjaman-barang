@extends('layouts.admin')

@section('title', 'Edit Kategori Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Kategori: {{ $kategori->nama_kategori }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_kategori') is-invalid @enderror" 
                                           id="nama_kategori" 
                                           name="nama_kategori" 
                                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                           placeholder="Masukkan nama kategori" 
                                           required>
                                    @error('nama_kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" 
                                              name="deskripsi" 
                                              rows="4" 
                                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto Saat Ini</label>
                                    @if($kategori->foto)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $kategori->foto) }}" 
                                                 alt="{{ $kategori->nama_kategori }}" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 200px; max-height: 200px;">
                                        </div>
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center mb-3" 
                                             style="width: 200px; height: 150px; border-radius: 4px; margin: 0 auto;">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="foto">Ganti Foto</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('foto') is-invalid @enderror" 
                                               id="foto" 
                                               name="foto" 
                                               accept="image/*">
                                        <label class="custom-file-label" for="foto">Pilih foto baru...</label>
                                    </div>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label>Preview Foto Baru</label>
                                    <div id="preview-container" class="text-center" style="display: none;">
                                        <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Preview image before upload
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview-image');
    const container = document.getElementById('preview-container');
    const label = document.querySelector('.custom-file-label');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(file);
        label.textContent = file.name;
    } else {
        container.style.display = 'none';
        label.textContent = 'Pilih foto baru...';
    }
});
</script>
@endsection