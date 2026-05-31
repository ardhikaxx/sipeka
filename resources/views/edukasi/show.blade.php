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
                <div class="ratio ratio-16x9 ratio-md-21x9 bg-peka-primary-pale overflow-hidden">
                    <img src="{{ $edukasi->thumbnail }}" class="object-fit-cover" alt="{{ $edukasi->judul }}">
                </div>
            @endif

            <div class="card-body p-3 p-md-4 p-lg-5">
                <header class="mb-4 mb-md-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        @php
                            $katClass = match($edukasi->kategori) {
                                'Artikel' => 'bg-info-subtle text-info border-info-subtle',
                                'Video' => 'bg-danger-subtle text-danger border-danger-subtle',
                                'FAQ' => 'bg-success-subtle text-success border-success-subtle',
                                default => 'bg-light text-dark border-secondary-subtle'
                            };
                        @endphp
                        <span class="badge {{ $katClass }} border rounded-pill px-3 py-2" style="font-weight: 700; font-size: 0.7rem;">
                            {{ strtoupper($edukasi->kategori) }}
                        </span>
                        <span class="text-muted small"><i class="far fa-clock me-1"></i> 6 Mnt</span>
                    </div>
                    
                    <h1 class="fw-800 text-dark fs-3 fs-md-2 mb-3">{{ $edukasi->judul }}</h1>
                    
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3 gap-md-4 text-muted small border-top pt-4 mt-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-user-doctor" style="font-size: 0.8rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark x-small">Tim Medis SIPEKA</div>
                                <div class="x-small">Penulis Konten</div>
                            </div>
                        </div>
                        <div class="vr d-none d-sm-block opacity-25"></div>
                        <div class="x-small">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ optional($edukasi->published_at)->isoFormat('D MMMM YYYY') ?? $edukasi->created_at->isoFormat('D MMMM YYYY') }}
                        </div>
                    </div>
                </header>

                <div class="content-body" style="font-size: 1.05rem; line-height: 1.8; color: var(--gray-800);">
                    {!! nl2br(e($edukasi->konten)) !!}
                </div>

                <footer class="mt-5 pt-4 border-top">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">Bagikan:</span>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-whatsapp text-success"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-facebook text-primary"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px;"><i class="fab fa-twitter text-info"></i></button>
                        </div>
                        <div class="text-muted x-small italic">
                            ID: #EDU-{{ str_pad($edukasi->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </footer>
            </div>
        </article>
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
        <!-- Premium Help Card -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden mb-4 position-relative">
            <div class="bg-peka-primary p-4 text-white">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1rem;">
                        <i class="fas fa-comment-medical"></i>
                    </div>
                    <h6 class="fw-800 mb-0">Konsultasi Medis</h6>
                </div>
                <p class="small opacity-75 mb-4">Tim bidan kami siap membantu menjawab pertanyaan anda seputar kesehatan kehamilan.</p>
                <a href="{{ route('portal.index') }}" class="btn btn-white w-100 rounded-pill fw-800 shadow-sm py-2">
                    Tanya Bidan
                </a>
            </div>
            <div class="p-3 bg-peka-primary-pale text-center">
                <span class="text-peka-primary x-small fw-bold"><i class="fas fa-clock me-1"></i> Layanan 24 Jam Darurat</span>
            </div>
        </div>

        <!-- Latest Articles with modern list -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                <h6 class="fw-800 text-dark mb-0">Materi Terkait</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex gap-3 align-items-center">
                        <div class="bg-light rounded-lg flex-shrink-0" style="width: 44px; height: 44px;"></div>
                        <div>
                            <div class="fw-bold text-dark small line-clamp-2" style="font-size: 0.8rem;">Pola Makan Sehat Bumil</div>
                            <div class="text-muted" style="font-size: 0.65rem;">5 Mnt Baca</div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex gap-3 align-items-center">
                        <div class="bg-light rounded-lg flex-shrink-0" style="width: 44px; height: 44px;"></div>
                        <div>
                            <div class="fw-bold text-dark small line-clamp-2" style="font-size: 0.8rem;">Olahraga Ringan Hamil</div>
                            <div class="text-muted" style="font-size: 0.65rem;">3 Mnt Baca</div>
                        </div>
                    </a>
                </div>
                <div class="p-4 pt-2">
                    <hr class="divider-h opacity-25">
                    <a href="{{ route('edukasi.index') }}" class="btn btn-sm btn-peka-outline w-100 rounded-pill fw-bold py-2" style="font-size: 0.75rem;">
                        Eksplor Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .rounded-lg { border-radius: 12px; }
    .btn-white { background: white; color: var(--peka-primary); border: none; }
    .btn-white:hover { background: var(--peka-primary-pale); color: var(--peka-primary); }
</style>

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
