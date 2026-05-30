@extends('layouts.app')

@section('title', 'Edukasi')
@section('page_title', 'Pusat Edukasi')

@section('content')
<!-- Search & Header Section -->
<div class="row align-items-center mb-5">
    <div class="col-lg-6">
        <h2 class="fw-800 text-dark mb-1">Pusat Pengetahuan <span class="text-peka-primary">SIPEKA</span></h2>
        <p class="text-muted">Temukan informasi terpercaya seputar kehamilan dan preeklampsia.</p>
    </div>
    <div class="col-lg-6">
        <div class="input-group-peka shadow-sm">
            <div class="position-relative w-100">
                <i class="fas fa-search input-icon" style="top: 50%;"></i>
                <input type="text" class="form-control-peka ps-5 rounded-pill border-0" placeholder="Cari topik kesehatan (misal: Nutrisi, Tekanan Darah)..." style="height: 50px;">
            </div>
        </div>
    </div>
</div>

<!-- Featured Article (if exists) -->
@if($edukasis->count() > 0)
@php $featured = $edukasis->first(); @endphp
<div class="welcome-card mb-5 p-0 overflow-hidden" style="min-height: 350px;">
    <div class="row g-0 h-100">
        <div class="col-lg-7 p-4 p-lg-5 d-flex flex-column justify-content-center">
            <div class="mb-3">
                <span class="badge bg-white text-peka-primary rounded-pill px-3 py-2 fw-bold">MATERI UNGGULAN</span>
            </div>
            <h2 class="fw-800 mb-3 display-6">{{ $featured->judul }}</h2>
            <p class="mb-4 opacity-75 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($featured->konten), 200) }}</p>
            <div>
                <a href="{{ route('edukasi.show', $featured) }}" class="btn btn-light rounded-pill px-4 fw-bold">
                    Baca Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
            <div class="w-100 h-100 bg-light opacity-25 d-flex align-items-center justify-content-center">
                <i class="fas fa-book-open" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h5 class="section-title mb-0">Katalog Materi Lengkap</h5>
    </div>
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.edukasi.create') }}" class="btn btn-peka-primary shadow-sm rounded-pill px-4">
            <i class="fas fa-plus me-2"></i> Tambah Materi
        </a>
    @endif
</div>

<!-- Category Filters -->
<div class="d-flex gap-2 mb-4 overflow-x-auto pb-2 scrollbar-hidden">
    <button class="btn btn-peka-primary rounded-pill px-4 py-2 fw-bold small">Semua Materi</button>
    <button class="btn btn-white border rounded-pill px-4 py-2 small text-muted fw-bold">Artikel Kesehatan</button>
    <button class="btn btn-white border rounded-pill px-4 py-2 small text-muted fw-bold">Video Edukasi</button>
    <button class="btn btn-white border rounded-pill px-4 py-2 small text-muted fw-bold">Panduan / FAQ</button>
</div>

<div class="row g-4">
    @forelse($edukasis as $edukasi)
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-card rounded-xl h-100 overflow-hidden transition-hover">
            <!-- Placeholder Image/Thumbnail -->
            <div class="ratio ratio-16x9 bg-peka-primary-pale d-flex align-items-center justify-content-center overflow-hidden">
                @if($edukasi->thumbnail)
                    <img src="{{ $edukasi->thumbnail }}" class="object-fit-cover w-100 h-100" alt="{{ $edukasi->judul }}">
                @else
                    <div class="d-flex flex-column align-items-center text-peka-primary opacity-50">
                        <i class="fas {{ $edukasi->kategori === 'Video' ? 'fa-circle-play' : 'fa-file-lines' }} fs-1 mb-2"></i>
                        <span class="small fw-bold">{{ strtoupper($edukasi->kategori) }}</span>
                    </div>
                @endif
            </div>
            
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    @php
                        $katClass = match($edukasi->kategori) {
                            'Artikel' => 'bg-info-subtle text-info border-info-subtle',
                            'Video' => 'bg-danger-subtle text-danger border-danger-subtle',
                            'FAQ' => 'bg-success-subtle text-success border-success-subtle',
                            default => 'bg-light text-dark border-secondary-subtle'
                        };
                    @endphp
                    <span class="badge {{ $katClass }} border rounded-pill px-2 py-1" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.05em;">
                        {{ strtoupper($edukasi->kategori) }}
                    </span>
                    <span class="text-muted small"><i class="far fa-clock me-1"></i> 5 mnt baca</span>
                </div>
                
                <h5 class="fw-bold text-dark mb-2 line-clamp-2" style="min-height: 3rem;">{{ $edukasi->judul }}</h5>
                <p class="text-muted small line-clamp-3 mb-4">
                    {{ \Illuminate\Support\Str::limit(strip_tags($edukasi->konten), 100) }}
                </p>
                
                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem;">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <span class="text-muted" style="font-size: 0.75rem;">Tim SIPEKA</span>
                    </div>
                    <a href="{{ route('edukasi.show', $edukasi) }}" class="btn btn-sm btn-peka-primary px-3 rounded-pill">
                        Baca Selengkapnya <i class="fas fa-arrow-right ms-1" style="font-size: 0.7rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="empty-state">
            <i class="fas fa-book-medical d-block fs-1 mb-3 opacity-25"></i>
            <h6 class="text-dark fw-bold">Materi Belum Tersedia</h6>
            <p class="text-muted">Nantikan konten edukasi bermanfaat lainnya di sini.</p>
        </div>
    </div>
    @endforelse
</div>

<style>
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .scrollbar-hidden::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hidden {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
