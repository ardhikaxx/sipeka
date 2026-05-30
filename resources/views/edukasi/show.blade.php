@extends('layouts.app')

@section('title', $edukasi->judul)
@section('page_title', 'Baca Edukasi')

@section('content')
<div id="readingProgress" class="position-fixed top-0 start-0 bg-peka-secondary" style="height: 4px; z-index: 9999; width: 0%; transition: width 0.1s;"></div>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('edukasi.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
    </a>
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-light border rounded-circle" title="Simpan Artikel"><i class="far fa-bookmark"></i></button>
        <button class="btn btn-sm btn-light border rounded-circle" title="Cetak"><i class="fas fa-print"></i></button>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <article class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <!-- Hero Image/Banner -->
            @if($edukasi->thumbnail)
                <div class="ratio ratio-21x9 bg-peka-primary-pale overflow-hidden">
                    <img src="{{ $edukasi->thumbnail }}" class="object-fit-cover" alt="{{ $edukasi->judul }}">
                </div>
            @endif

            <div class="card-body p-4 p-lg-5">
                <header class="mb-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        @php
                            $katClass = match($edukasi->kategori) {
                                'Artikel' => 'bg-info-subtle text-info border-info-subtle',
                                'Video' => 'bg-danger-subtle text-danger border-danger-subtle',
                                'FAQ' => 'bg-success-subtle text-success border-success-subtle',
                                default => 'bg-light text-dark border-secondary-subtle'
                            };
                        @endphp
                        <span class="badge {{ $katClass }} border rounded-pill px-3 py-2" style="font-weight: 700;">
                            {{ strtoupper($edukasi->kategori) }}
                        </span>
                        <span class="text-muted small"><i class="far fa-clock me-1"></i> 6 Menit Baca</span>
                    </div>
                    
                    <h1 class="fw-800 text-dark display-6 mb-3">{{ $edukasi->judul }}</h1>
                    
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
                            {{ optional($edukasi->published_at)->isoFormat('D MMMM YYYY') ?? $edukasi->created_at->isoFormat('D MMMM YYYY') }}
                        </div>
                    </div>
                </header>

                <div class="content-body" style="font-size: 1.125rem; line-height: 1.9; color: var(--gray-800);">
                    {!! nl2br(e($edukasi->konten)) !!}
                </div>

                <footer class="mt-5 pt-5 border-top">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">Bagikan Artikel:</span>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-whatsapp text-success"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-facebook text-primary"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-twitter text-info"></i></button>
                        </div>
                        <div class="text-muted small italic">
                            ID Konten: #EDU-{{ str_pad($edukasi->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </footer>
            </div>
        </article>
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
        <!-- Help Card -->
        <div class="card border-0 bg-peka-primary-pale rounded-xl mb-4">
            <div class="card-body p-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-peka-primary shadow-sm mb-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-hand-holding-heart fs-4"></i>
                </div>
                <h6 class="fw-bold text-peka-primary mb-2">Butuh Konsultasi?</h6>
                <p class="text-muted small mb-3">Jika anda mengalami gejala yang tidak biasa, segera hubungi tim medis kami melalui portal pasien.</p>
                <a href="{{ route('portal.index') }}" class="btn btn-peka-primary w-100 rounded-pill">Hubungi Bidan</a>
            </div>
        </div>

        <!-- Latest Articles -->
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0">Artikel Terbaru</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="list-item-modern p-0 bg-transparent border-0">
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small line-clamp-2">Tips Menjaga Nutrisi Selama Trimester Pertama</div>
                            <div class="text-muted small mt-1">5 Menit Lalu</div>
                        </div>
                    </div>
                    <div class="list-item-modern p-0 bg-transparent border-0">
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small line-clamp-2">Olahraga Aman untuk Ibu Hamil</div>
                            <div class="text-muted small mt-1">2 Jam Lalu</div>
                        </div>
                    </div>
                </div>
                <hr class="divider-h opacity-50">
                <a href="{{ route('edukasi.index') }}" class="btn btn-sm btn-peka-outline w-100 rounded-pill">Lihat Katalog</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.onscroll = function() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        document.getElementById("readingProgress").style.width = scrolled + "%";
    };
</script>
@endpush


<style>
    .content-body p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
