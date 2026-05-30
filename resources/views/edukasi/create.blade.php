@extends('layouts.app')

@section('title', 'Konten Edukasi Baru')
@section('page_title', 'Konten Edukasi Baru')

@section('content')
<form method="POST" action="{{ route('admin.edukasi.store') }}" class="card border-0 shadow-card rounded-xl">
    @csrf
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label form-label-required">Judul</label><input name="judul" class="form-control-peka" required></div>
            <div class="col-md-4"><label class="form-label form-label-required">Kategori</label><select name="kategori" class="form-control-peka" required><option>Artikel</option><option>Video</option><option>Infografis</option><option>FAQ</option><option>Kalkulator</option></select></div>
            <div class="col-md-6"><label class="form-label">Thumbnail URL</label><input name="thumbnail" class="form-control-peka"></div>
            <div class="col-md-6"><label class="form-label">Tanggal Publikasi</label><input type="datetime-local" name="published_at" class="form-control-peka"></div>
            <div class="col-12"><label class="form-label form-label-required">Konten</label><textarea name="konten" class="form-control-peka" rows="10" required></textarea></div>
        </div>
        <div class="text-end mt-4"><button class="btn btn-peka-primary"><i class="fas fa-save"></i> Simpan</button></div>
    </div>
</form>
@endsection
