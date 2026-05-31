@extends('layouts.app')

@section('title', 'Portal Bunda SIPEKA')
@section('page_title', 'Dashboard Bunda')

@section('content')
<style>
    /* Custom Portal Styles */
    .portal-hero {
        background: linear-gradient(135deg, #1A6B6B 0%, #0c3d3d 100%);
        border-radius: 28px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(12, 61, 61, 0.2);
    }
    .portal-hero::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -20%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(42, 143, 143, 0.2) 0%, transparent 70%);
        z-index: 1;
        pointer-events: none;
    }
    .hero-stat {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 16px 24px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .portal-card {
        border: 1px solid rgba(0,0,0,0.02);
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .portal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.06) !important;
    }
    .timeline-modern {
        position: relative;
        padding-left: 45px;
    }
    .timeline-modern::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #F1F5F9;
        border-radius: 3px;
    }
    .timeline-modern-item {
        position: relative;
        padding-bottom: 35px;
    }
    .timeline-dot {
        position: absolute;
        left: -45px;
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #F8FAFC;
        z-index: 2;
        color: var(--peka-primary);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .timeline-dot.active { border-color: var(--peka-primary-pale); background: var(--peka-primary); color: white; }
    .timeline-dot.warning { border-color: #FEF3C7; background: #F59E0B; color: white; }
    .timeline-dot.danger { border-color: #FEE2E2; background: #EF4444; color: white; }
    
    .status-pill {
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-emergency-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        padding: 16px 28px;
        border-radius: 50px;
        font-weight: 800;
        box-shadow: 0 15px 30px rgba(220, 38, 38, 0.3);
        transition: transform 0.2s;
    }
    .btn-emergency-float:hover {
        transform: scale(1.05);
    }

    @media (min-width: 993px) {
        body.portal-mode .sipeka-sidebar { display: none !important; }
        body.portal-mode .sipeka-main { margin-left: 0 !important; }
    }
</style>

<script>
    document.body.classList.add('portal-mode');
</script>

<div class="row">
    <div class="col-12 col-xxl-10 mx-auto">
        
        <!-- Welcome Hero Section -->
        <div class="portal-hero mb-4 p-4 p-md-5">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-12 col-lg-7 text-center text-lg-start">
                    <h1 class="fw-extrabold mb-3 text-white" style="font-family: var(--font-heading); font-size: calc(1.8rem + 1vw); letter-spacing: -0.03em; line-height: 1.1;">
                        Halo, Bunda<br class="d-none d-md-block"> {{ explode(' ', $pasien->nama)[0] }}! 👋
                    </h1>
                    <p class="fs-6 opacity-90 mb-4">Mari terus pantau kesehatan Bunda dan si kecil bersama SIPEKA.</p>
                    
                    @if($kehamilanAktif)
                    <div class="row g-3 justify-content-center justify-content-lg-start">
                        <div class="col-6 col-sm-auto">
                            <div class="hero-stat">
                                <div class="x-small text-white-50 uppercase-font fw-bold mb-1">Usia Kandungan</div>
                                <div class="fs-4 fw-bold">{{ \Carbon\Carbon::parse($kehamilanAktif->hpht)->diffInWeeks(now()) }} <span class="small fw-normal">Mg</span></div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-auto">
                            <div class="hero-stat">
                                <div class="x-small text-white-50 uppercase-font fw-bold mb-1">Taksiran Lahir</div>
                                <div class="fs-4 fw-bold">{{ \Carbon\Carbon::parse($kehamilanAktif->tp)->format('d M') }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-5 d-none d-lg-block text-end pe-4">
                    <i class="fas fa-hand-holding-medical text-white opacity-25" style="font-size: 10rem; transform: rotate(-10deg);"></i>
                </div>
            </div>
        </div>

        <!-- Vital Stats Grid -->
        <div class="row g-3 g-md-4 mb-4">
            @if($kehamilanAktif && $kehamilanAktif->kunjunganAncs->isNotEmpty())
                @php 
                    $lastVisit = $kehamilanAktif->kunjunganAncs->sortByDesc('tanggal')->first(); 
                    $rawLevel = $lastVisit->skriningRisiko?->level_risiko ?? 'HIJAU';
                    $statusColor = match($rawLevel) {
                        'HIJAU' => 'success',
                        'KUNING' => 'warning',
                        'MERAH', 'MERAH_KRITIS' => 'danger',
                        default => 'success'
                    };
                @endphp
                
                <div class="col-6 col-md-4">
                    <div class="card shadow-card portal-card h-100">
                        <div class="card-body p-3 p-md-4 text-center">
                            <div class="stat-card__icon bg-primary-subtle text-primary mx-auto mb-2 mb-md-3" style="width: 44px; height: 44px; font-size: 1.2rem;">
                                <i class="fas fa-heart-pulse"></i>
                            </div>
                            <h6 class="text-muted x-small mb-1">Tensi Terakhir</h6>
                            <h3 class="fw-extrabold mb-0 small" style="font-family: var(--font-heading);">{{ $lastVisit->tekanan_darah_sistolik }}/{{ $lastVisit->tekanan_darah_diastolik }}</h3>
                            <div class="x-small text-{{ $lastVisit->tekanan_darah_sistolik < 140 ? 'success' : 'danger' }} mt-1">
                                {{ $lastVisit->tekanan_darah_sistolik < 140 ? 'Normal' : 'Tinggi' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class="card shadow-card portal-card h-100">
                        <div class="card-body p-3 p-md-4 text-center">
                            <div class="stat-card__icon bg-info-subtle text-info mx-auto mb-2 mb-md-3" style="width: 44px; height: 44px; font-size: 1.2rem;">
                                <i class="fas fa-weight-scale"></i>
                            </div>
                            <h6 class="text-muted x-small mb-1">Berat Bunda</h6>
                            <h3 class="fw-extrabold mb-0 small" style="font-family: var(--font-heading);">{{ $lastVisit->berat_badan }} <small class="x-small fw-normal">kg</small></h3>
                            <div class="text-hint x-small mt-1">+{{ $lastVisit->penambahan_bb ?? 0 }} kg</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card shadow-card portal-card h-100 border-top border-4 border-{{ $statusColor }}">
                        <div class="card-body p-3 p-md-4 text-center">
                            <h6 class="text-muted x-small mb-2">Kondisi Bunda</h6>
                            <div class="status-pill bg-{{ $statusColor }}-subtle text-{{ $statusColor }} d-inline-block mb-2 py-1 px-3" style="font-size: 0.65rem;">
                                {{ str_replace('_', ' ', $lastVisit->skriningRisiko?->status ?? 'NORMAL') }}
                            </div>
                            <p class="x-small text-muted mb-0 lh-sm">
                                {{ $rawLevel == 'HIJAU' ? 'Bunda & janin terpantau sehat.' : 'Mohon perhatikan saran bidan.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row g-3 g-md-4">
            <!-- Timeline Section -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-card portal-card h-100">
                    <div class="card-header bg-white border-bottom p-3 p-md-4 d-flex justify-content-between align-items-center">
                        <h6 class="section-title mb-0 small fw-bold">Riwayat Pemeriksaan</h6>
                        <i class="fas fa-shoe-prints text-muted opacity-25"></i>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        @if($kehamilanAktif && $kehamilanAktif->kunjunganAncs->isNotEmpty())
                            <div class="timeline-modern mt-2">
                                @foreach($kehamilanAktif->kunjunganAncs->sortByDesc('tanggal') as $index => $k)
                                    @php
                                        $rLevel = $k->skriningRisiko?->level_risiko ?? 'HIJAU';
                                        $dotClass = match($rLevel) {
                                            'HIJAU' => ($index == 0 ? 'active' : ''),
                                            'KUNING' => 'warning',
                                            default => 'danger'
                                        };
                                    @endphp
                                    <div class="timeline-modern-item">
                                        <div class="timeline-dot {{ $dotClass }}">
                                            <i class="fas {{ $index == 0 ? 'fa-check' : 'fa-calendar-check' }} x-small"></i>
                                        </div>
                                        <div class="bg-light rounded-4 p-3 border border-white shadow-sm">
                                            <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                                <h6 class="fw-bold mb-0 text-dark x-small">{{ $k->tanggal->format('d M Y') }}</h6>
                                                <span class="badge bg-white text-primary border rounded-pill x-small" style="font-size: 0.6rem;">{{ $k->usia_kehamilan_minggu }} Mg</span>
                                            </div>
                                            <div class="row g-2 mb-2 text-center text-sm-start">
                                                <div class="col-4">
                                                    <div class="x-small text-muted">Tensi</div>
                                                    <div class="x-small fw-bold">{{ $k->tekanan_darah_sistolik }}/{{ $k->tekanan_darah_diastolik }}</div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="x-small text-muted">Protein</div>
                                                    <div class="x-small fw-bold {{ $k->protein_urine == 'Negatif' ? 'text-success' : 'text-danger' }}">{{ $k->protein_urine }}</div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="x-small text-muted">DJJ</div>
                                                    <div class="x-small fw-bold">{{ $k->djj }}</div>
                                                </div>
                                            </div>
                                            @if($k->catatan_bidan)
                                                <div class="bg-white rounded-3 p-2 border-start border-3 border-primary mt-2">
                                                    <p class="x-small text-muted mb-0 italic">"{{ \Illuminate\Support\Str::limit($k->catatan_bidan, 100) }}"</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state py-5 text-center">
                                <i class="fas fa-clipboard-list fa-2x text-light mb-3 opacity-50"></i>
                                <h6 class="x-small">Belum ada riwayat.</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Info/Jadwal -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-card portal-card mb-3 mb-md-4 bg-primary text-white">
                    <div class="card-body p-4 text-center text-lg-start">
                        <h6 class="fw-bold mb-3 small"><i class="fas fa-calendar-alt me-2"></i> Jadwal Periksa</h6>
                        @php $nextJadwal = $kehamilanAktif?->jadwalKunjungans?->where('status', 'Terjadwal')->first(); @endphp
                        @if($nextJadwal)
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 mb-3 border border-white border-opacity-20 d-inline-block d-lg-block w-100 text-dark">
                                <div class="h3 fw-bold mb-0 small">{{ $nextJadwal->tanggal_rencana->format('d M Y') }}</div>
                            </div>
                            <p class="x-small mb-0 opacity-80">Siapkan buku KIA dan tetap semangat ya Bunda!</p>
                        @else
                            <div class="py-2"><p class="x-small opacity-80 mb-0">Belum ada jadwal.</p></div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-card portal-card mb-5">
                    <div class="card-header bg-white border-bottom p-3 p-md-4">
                        <h6 class="fw-bold mb-0 small">Edukasi Pilihan</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action border-0 px-4 py-3 border-bottom">
                                <h6 class="fw-bold mb-1 small">Waspada Preeklampsia</h6>
                                <p class="x-small text-muted mb-0">Kenali gejalanya sedini mungkin.</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-4 py-3 border-bottom">
                                <h6 class="fw-bold mb-1 small">Nutrisi Bumil</h6>
                                <p class="x-small text-muted mb-0">Daftar makanan super si kecil.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Support Float Button -->
<button class="btn btn-danger btn-emergency-float shadow-lg px-4 py-3" onclick="laporDarurat()">
    <i class="fas fa-phone-alt me-2"></i> DARURAT
</button>

<form id="formDarurat" method="POST" action="{{ route('portal.darurat.store') }}" class="d-none">
    @csrf
    <input type="hidden" name="deskripsi" id="daruratDeskripsi">
    <div id="daruratGejalaInputs"></div>
</form>

@endsection

@push('scripts')
<script>
    function laporDarurat() {
        const gejala = [
            'Sakit kepala hebat & menetap',
            'Pandangan kabur / gelap mendadak',
            'Nyeri ulu hati yang sangat sakit',
            'Bengkak pada muka atau tangan',
            'Sesak napas mendadak',
            'Gerakan janin terasa berkurang/hilang',
            'Keluar air-air atau darah dari jalan lahir',
            'Kejang-kejang'
        ];

        Swal.fire({
            title: 'Lapor Kondisi Darurat',
            text: 'Bunda, pilih gejala yang Bunda rasakan saat ini. Bidan akan segera mendapat notifikasi.',
            html: `
                <div class="text-start mt-3">
                    <div class="row">
                        ${gejala.map((g, i) => `
                            <div class="col-12 mb-2">
                                <div class="form-check p-3 border rounded-3 hover-bg-light">
                                    <input type="checkbox" class="form-check-input gejala-darurat" id="g${i}" value="${g}">
                                    <label class="form-check-label ms-2 fw-semibold" for="g${i}">${g}</label>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <textarea id="deskripsiDarurat" class="form-control mt-3 p-3 border-2" rows="3" placeholder="Ceritakan kondisi Bunda lainnya jika ada..."></textarea>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Kirim Laporan Segera',
            cancelButtonText: 'Batal',
            width: '600px',
            preConfirm: () => {
                const checked = Array.from(document.querySelectorAll('.gejala-darurat:checked')).map(el => el.value);
                if (!checked.length) {
                    Swal.showValidationMessage('Bunda, mohon pilih minimal satu gejala.');
                    return false;
                }
                return { checked, deskripsi: document.getElementById('deskripsiDarurat').value };
            }
        }).then((result) => {
            if (!result.isConfirmed) return;

            const inputBox = document.getElementById('daruratGejalaInputs');
            inputBox.innerHTML = '';
            result.value.checked.forEach((item) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'gejala[]';
                input.value = item;
                inputBox.appendChild(input);
            });
            document.getElementById('daruratDeskripsi').value = result.value.deskripsi;
            
            Swal.fire({
                title: 'Mengirim Laporan...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            document.getElementById('formDarurat').submit();
        });
    }
</script>
@endpush
