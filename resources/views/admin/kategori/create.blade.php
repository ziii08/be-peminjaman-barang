@extends('layouts.admin')

@section('title', 'Tambah Kategori Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kategori Barang</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_kategori') is-invalid @enderror" 
                                           id="nama_kategori" 
                                           name="nama_kategori" 
                                           value="{{ old('nama_kategori') }}" 
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
                                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="foto">Foto Kategori</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('foto') is-invalid @enderror" 
                                               id="foto" 
                                               name="foto" 
                                               accept="image/*">
                                        <label class="custom-file-label" for="foto">Pilih foto...</label>
                                    </div>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label>Preview Foto</label>
                                    <div id="preview-container" class="text-center" style="display: none;">
                                        <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
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
        label.textContent = 'Pilih foto...';
    }
});
</script>
@endsection