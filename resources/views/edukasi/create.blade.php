@extends('layouts.app')

@section('title', 'Konten Edukasi Baru')
@section('page_title', 'Unggah Edukasi')

@section('content')
<div class="mb-4">
    <a href="{{ route('edukasi.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
    </a>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h5 class="section-title mb-1"><i class="fas fa-pen-nib me-2 text-peka-primary"></i>Tulis Materi Edukasi</h5>
        <p class="text-muted small">Publikasikan artikel, video, atau panduan kesehatan untuk ibu hamil.</p>
    </div>
    
    <form method="POST" action="{{ route('admin.edukasi.store') }}">
        @csrf
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Judul Materi</label>
                        <div class="position-relative">
                            <i class="fas fa-heading input-icon"></i>
                            <input name="judul" class="form-control-peka" placeholder="Contoh: Pentingnya Menjaga Tekanan Darah" value="{{ old('judul') }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Kategori Konten</label>
                        <div class="position-relative">
                            <i class="fas fa-tags input-icon"></i>
                            <select name="kategori" class="form-control-peka" required>
                                <option value="" disabled selected>Pilih kategori...</option>
                                <option>Artikel</option>
                                <option>Video</option>
                                <option>Infografis</option>
                                <option>FAQ</option>
                                <option>Kalkulator</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="input-group-peka">
                        <label class="form-label">Thumbnail / URL Gambar</label>
                        <div class="position-relative">
                            <i class="fas fa-image input-icon"></i>
                            <input name="thumbnail" class="form-control-peka" placeholder="https://link-gambar.com/foto.jpg" value="{{ old('thumbnail') }}">
                        </div>
                        <div class="text-hint mt-2">Gunakan URL gambar publik untuk sampul materi.</div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group-peka">
                        <label class="form-label">Tanggal Publikasi</label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-check input-icon"></i>
                            <input type="datetime-local" name="published_at" class="form-control-peka" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Isi Materi / Konten</label>
                        <textarea name="konten" class="form-control-peka" rows="12" placeholder="Tuliskan isi materi secara detail di sini..." required>{{ old('konten') }}</textarea>
                    </div>
                    <div class="text-hint mt-2"><i class="fas fa-circle-info me-1"></i> Gunakan bahasa yang mudah dipahami oleh ibu hamil.</div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-light border-0 p-4 text-end">
            <button type="reset" class="btn btn-light border px-4 me-2 rounded-pill">Reset</button>
            <button type="submit" class="btn btn-peka-primary px-5 rounded-pill shadow-sm">
                <i class="fas fa-paper-plane me-2"></i> Publikasikan Materi
            </button>
        </div>
    </form>
</div>
@endsection
