@extends('layouts.app')

@section('title', 'Edukasi')
@section('page_title', 'Edukasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h5 class="section-title mb-1">Konten Edukasi Preeklampsia</h5><p class="text-muted mb-0">Artikel, video, FAQ, dan kalkulator edukatif.</p></div>
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.edukasi.create') }}" class="btn btn-peka-primary"><i class="fas fa-plus"></i> Konten Baru</a>
    @endif
</div>
<div class="row g-4">
    @foreach($edukasis as $edukasi)
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-card rounded-xl h-100">
            <div class="card-body p-4">
                <span class="badge bg-light text-dark border mb-3">{{ $edukasi->kategori }}</span>
                <h5 class="section-title">{{ $edukasi->judul }}</h5>
                <p class="text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($edukasi->konten), 120) }}</p>
                <a href="{{ route('edukasi.show', $edukasi) }}" class="btn btn-sm btn-peka-outline"><i class="fas fa-book-open"></i> Baca</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
