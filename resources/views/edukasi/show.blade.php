@extends('layouts.app')

@section('title', $edukasi->judul)
@section('page_title', 'Baca Edukasi')

@section('content')
<div class="mb-4">
    <a href="{{ route('edukasi.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <article class="card border-0 shadow-card rounded-xl overflow-hidden">
            <!-- Hero Image/Banner -->
            @if($edukasi->thumbnail)
                <div class="ratio ratio-21x9 bg-peka-primary-pale overflow-hidden">
                    <img src="{{ $edukasi->thumbnail }}" class="object-fit-cover" alt="{{ $edukasi->judul }}">
                </div>
            @endif

            <div class="card-body p-4 p-lg-5">
                <header class="mb-5">
                    @php
                        $katClass = match($edukasi->kategori) {
                            'Artikel' => 'bg-info-subtle text-info border-info-subtle',
                            'Video' => 'bg-danger-subtle text-danger border-danger-subtle',
                            'FAQ' => 'bg-success-subtle text-success border-success-subtle',
                            default => 'bg-light text-dark border-secondary-subtle'
                        };
                    @endphp
                    <span class="badge {{ $katClass }} border rounded-pill px-3 py-2 mb-3" style="font-weight: 700;">
                        {{ strtoupper($edukasi->kategori) }}
                    </span>
                    
                    <h1 class="fw-bold text-dark display-6 mb-3">{{ $edukasi->judul }}</h1>
                    
                    <div class="d-flex align-items-center gap-4 text-muted small border-top pt-4 mt-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fas fa-user-doctor"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Tim Medis SIPEKA</div>
                                <div>Penulis Konten</div>
                            </div>
                        </div>
                        <div class="vr opacity-25"></div>
                        <div>
                            <i class="far fa-calendar-alt me-1"></i>
                            Diterbitkan pada {{ optional($edukasi->published_at)->isoFormat('D MMMM YYYY') ?? $edukasi->created_at->isoFormat('D MMMM YYYY') }}
                        </div>
                        <div class="vr opacity-25"></div>
                        <div>
                            <i class="far fa-eye me-1"></i> 1.2k Kali Dibaca
                        </div>
                    </div>
                </header>

                <div class="content-body" style="font-size: 1.1rem; line-height: 1.8; color: var(--gray-800);">
                    {!! nl2br(e($edukasi->konten)) !!}
                </div>

                <footer class="mt-5 pt-5 border-top">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">Bagikan:</span>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-whatsapp text-success"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-facebook text-primary"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-twitter text-info"></i></button>
                        </div>
                        <div class="text-muted small italic">
                            Terakhir diperbarui: {{ $edukasi->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </footer>
            </div>
        </article>
        
        <!-- Related Info/Next Steps -->
        <div class="card border-0 bg-peka-primary-pale rounded-xl mt-4">
            <div class="card-body p-4 d-flex align-items-center gap-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-peka-primary shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0;">
                    <i class="fas fa-hand-holding-heart fs-3"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-peka-primary mb-1">Punya Pertanyaan Medis?</h6>
                    <p class="text-muted small mb-0">Jika anda merasakan gejala yang dijelaskan dalam materi ini, segera hubungi bidan atau fasilitas kesehatan terdekat.</p>
                </div>
                <a href="{{ route('portal.index') }}" class="btn btn-peka-primary rounded-pill px-4 ms-auto">Hubungi Bidan</a>
            </div>
        </div>
    </div>
</div>

<style>
    .content-body p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
