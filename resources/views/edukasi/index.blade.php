@extends('layouts.app')

@section('title', 'Edukasi')
@section('page_title', 'Pusat Edukasi')

@section('content')
    <!-- Search & Header Section -->
    <div class="row align-items-center mb-4 mb-lg-5 g-3">
        <div class="col-12 col-lg-6">
            <h2 class="fw-800 text-dark mb-1">Pusat Pengetahuan <span class="text-peka-primary">SIPEKA</span></h2>
            <p class="text-muted small mb-0">Temukan informasi terpercaya seputar kehamilan dan preeklampsia.</p>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-3 justify-content-lg-end align-items-sm-center">
                <div class="input-group-peka w-100" style="max-width: 400px;">
                    <div class="position-relative w-100">
                        <i class="fas fa-search input-icon" style="top: 50%; transform: translateY(-50%);"></i>
                        <input type="text" class="form-control-peka ps-5 rounded-pill border-0"
                            placeholder="Cari topik kesehatan..." style="height: 46px; font-size: 0.9rem;">
                    </div>
                </div>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.edukasi.create') }}" class="btn btn-peka-primary shadow-sm rounded-pill px-4 py-2 flex-shrink-0">
                        <i class="fas fa-plus me-1"></i> Materi Baru
                    </a>
                @endif
            </div>
        </div>
    </div>

    <style>
        .rounded-xxl {
            border-radius: 28px;
        }

        .featured-hero {
            min-height: 380px;
            background: #114b4b;
        }

        .btn-white {
            background: white;
            color: var(--peka-primary);
            border: none;
        }

        .btn-white:hover {
            background: var(--peka-primary-pale);
            transform: scale(1.05);
            color: var(--peka-primary);
        }
    </style>

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
                <div class="card border-0 shadow-card rounded-xl h-100 overflow-hidden premium-card">
                    <!-- Image Area -->
                    <div class="position-relative overflow-hidden ratio ratio-16x9">
                        @if ($edukasi->thumbnail)
                            <img src="{{ $edukasi->thumbnail }}"
                                class="object-fit-cover w-100 h-100 card-img-top transition-transform"
                                alt="{{ $edukasi->judul }}">
                        @else
                            <div
                                class="w-100 h-100 d-flex align-items-center justify-content-center bg-gradient-premium text-white card-img-top">
                                <i
                                    class="fas {{ $edukasi->kategori === 'Video' ? 'fa-circle-play' : 'fa-file-lines' }} display-4 opacity-50"></i>
                            </div>
                        @endif

                        <!-- Floating Category Badge -->
                        <div class="position-absolute top-0 inset-e-0 p-3">
                            @php
                                $katClass = match ($edukasi->kategori) {
                                    'Artikel' => 'bg-info',
                                    'Video' => 'bg-danger',
                                    'FAQ' => 'bg-success',
                                    default => 'bg-primary',
                                };
                            @endphp
                            <span
                                class="badge {{ $katClass }} bg-opacity-75 backdrop-blur border-0 rounded-pill px-3 py-2 fw-800 shadow-sm"
                                style="font-size: 0.65rem; letter-spacing: 0.05em;">
                                {{ strtoupper($edukasi->kategori) }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center gap-2 mb-3 text-muted small">
                            <span class="d-flex align-items-center gap-1"><i class="far fa-calendar-alt"></i>
                                {{ $edukasi->created_at->format('d M Y') }}</span>
                            <span class="opacity-25">•</span>
                            <span class="d-flex align-items-center gap-1"><i class="far fa-clock"></i> 5 mnt</span>
                        </div>

                        <h5 class="fw-800 text-dark mb-3 line-clamp-2 title-link"
                            style="min-height: 3rem; line-height: 1.4;">
                            <a href="{{ route('edukasi.show', $edukasi) }}"
                                class="text-decoration-none text-dark">{{ $edukasi->judul }}</a>
                        </h5>

                        <p class="text-muted small line-clamp-3 mb-4 grow" style="line-height: 1.6;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($edukasi->konten), 120) }}
                        </p>

                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-peka-primary-pale text-peka-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    SP
                                </div>
                                <span class="text-dark fw-semibold" style="font-size: 0.75rem;">Tim SIPEKA</span>
                            </div>
                            <a href="{{ route('edukasi.show', $edukasi) }}" class="btn-read-more">
                                <span class="me-1">Baca</span>
                                <i class="fas fa-chevron-right"></i>
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
        .fw-800 {
            font-weight: 800;
        }

        .backdrop-blur {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .bg-gradient-premium {
            background: linear-gradient(135deg, var(--peka-primary) 0%, #114b4b 100%);
        }

        .premium-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid rgba(0, 0, 0, 0.03) !important;
        }

        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .premium-card:hover .transition-transform {
            transform: scale(1.08);
        }

        .transition-transform {
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .title-link a {
            transition: color 0.2s;
        }

        .premium-card:hover .title-link a {
            color: var(--peka-primary) !important;
        }

        .btn-read-more {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--peka-primary);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 5px 12px;
            border-radius: 20px;
            background: var(--peka-primary-pale);
            transition: all 0.3s;
        }

        .btn-read-more:hover {
            background: var(--peka-primary);
            color: white;
            padding-right: 15px;
        }

        .btn-read-more i {
            font-size: 0.7rem;
            transition: transform 0.3s;
        }

        .btn-read-more:hover i {
            transform: translateX(3px);
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
