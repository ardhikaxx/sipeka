@extends('layouts.app')

@section('title', 'Portal Bunda SIPEKA')
@section('page_title', 'Dashboard Bunda')

@section('content')
<style>
    /* Custom Portal Styles */
    .portal-hero {
        background: linear-gradient(135deg, #1A6B6B 0%, #2A8F8F 100%);
        border-radius: 24px;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(26, 107, 107, 0.15);
    }
    .portal-hero::after {
        content: '\f596';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 12rem;
        opacity: 0.1;
        transform: rotate(-15deg);
    }
    .hero-stat {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        border-radius: 16px;
        padding: 15px 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .portal-card {
        border: none;
        border-radius: 20px;
        transition: transform 0.2s;
    }
    .portal-card:hover {
        transform: translateY(-5px);
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
        background: #E2E8F0;
        border-radius: 3px;
    }
    .timeline-modern-item {
        position: relative;
        padding-bottom: 30px;
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
        border: 4px solid #F1F5F9;
        z-index: 2;
        color: var(--peka-primary);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .timeline-dot.active { border-color: var(--peka-primary); background: var(--peka-primary); color: white; }
    .timeline-dot.warning { border-color: var(--risk-yellow); color: var(--risk-yellow); }
    .timeline-dot.danger { border-color: var(--risk-red); color: var(--risk-red); }
    
    .status-pill {
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-emergency-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        padding: 15px 25px;
        border-radius: 50px;
        font-weight: 800;
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4);
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
        <div class="portal-hero">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-6 fw-bold mb-2">Halo, Bunda {{ explode(' ', $pasien->nama)[0] }}! 👋</h1>
                    <p class="fs-5 opacity-90 mb-4">Senang melihat Bunda kembali. Terus pantau kesehatan Bunda dan si kecil ya.</p>
                    
                    @if($kehamilanAktif)
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="hero-stat">
                                <div class="small opacity-75">Usia Kandungan</div>
                                <div class="fs-4 fw-bold">{{ \Carbon\Carbon::parse($kehamilanAktif->hpht)->diffInWeeks(now()) }} <span class="fs-6 fw-normal">Minggu</span></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="hero-stat">
                                <div class="small opacity-75">Taksiran Persalinan</div>
                                <div class="fs-4 fw-bold">{{ \Carbon\Carbon::parse($kehamilanAktif->tp)->format('d M') }} <span class="fs-6 fw-normal">{{ \Carbon\Carbon::parse($kehamilanAktif->tp)->format('Y') }}</span></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-5 d-none d-lg-block text-end">
                    <img src="https://img.freepik.com/free-vector/pregnant-woman-concept-illustration_114360-3103.jpg" class="img-fluid rounded-4 shadow-sm" style="max-height: 200px; mix-blend-mode: multiply; opacity: 0.8;" alt="Pregnancy Illustration">
                </div>
            </div>
        </div>

        <!-- Vital Stats Grid -->
        <div class="row g-4 mb-4">
            @if($kehamilanAktif && $kehamilanAktif->kunjunganAncs->isNotEmpty())
                @php 
                    $lastVisit = $kehamilanAktif->kunjunganAncs->first(); 
                    $rawLevel = $lastVisit->skriningRisiko?->level_risiko ?? 'HIJAU';
                    $statusColor = [
                        'HIJAU' => 'success',
                        'KUNING' => 'warning',
                        'MERAH' => 'danger',
                        'MERAH_KRITIS' => 'danger'
                    ][$rawLevel] ?? 'success';
                @endphp
                
                <div class="col-md-4">
                    <div class="card shadow-card portal-card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="stat-card__icon bg-primary-subtle text-primary mx-auto mb-3" style="width: 56px; height: 56px;">
                                <i class="fas fa-heart-pulse"></i>
                            </div>
                            <h6 class="text-muted mb-2">Tekanan Darah Terakhir</h6>
                            <h2 class="fw-extrabold mb-1" style="font-family: var(--font-heading);">{{ $lastVisit->tekanan_darah_sistolik }}/{{ $lastVisit->tekanan_darah_diastolik }} <small class="fs-6 fw-normal text-muted">mmHg</small></h2>
                            <div class="small text-{{ $lastVisit->tekanan_darah_sistolik < 140 ? 'success' : 'danger' }}">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> {{ $lastVisit->tekanan_darah_sistolik < 140 ? 'Normal' : 'Tinggi' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-card portal-card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="stat-card__icon bg-info-subtle text-info mx-auto mb-3" style="width: 56px; height: 56px;">
                                <i class="fas fa-weight-scale"></i>
                            </div>
                            <h6 class="text-muted mb-2">Berat Badan Bunda</h6>
                            <h2 class="fw-extrabold mb-1" style="font-family: var(--font-heading);">{{ $lastVisit->berat_badan }} <small class="fs-6 fw-normal text-muted">kg</small></h2>
                            <div class="text-hint">Naik {{ $lastVisit->penambahan_bb ?? 0 }} kg dari periksa lalu</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-card portal-card h-100 border-top border-4 border-{{ $statusColor }}">
                        <div class="card-body p-4 text-center">
                            <h6 class="text-muted mb-3">Kondisi Kesehatan</h6>
                            <div class="status-pill bg-{{ $statusColor }}-subtle text-{{ $statusColor }} d-inline-block mb-3">
                                {{ str_replace('_', ' ', $lastVisit->skriningRisiko?->status ?? 'NORMAL') }}
                            </div>
                            <p class="small text-muted px-2">
                                @if($rawLevel == 'HIJAU')
                                    Alhamdulillah, Bunda dalam kondisi sehat. Tetap jaga pola makan ya!
                                @else
                                    Perhatian ekstra diperlukan. Mohon ikuti saran Bidan/Dokter dengan teliti.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row g-4">
            <!-- Timeline Section -->
            <div class="col-lg-8">
                <div class="card shadow-card portal-card h-100">
                    <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">Catatan Perjalanan Bunda</h5>
                        <i class="fas fa-shoe-prints text-muted opacity-25"></i>
                    </div>
                    <div class="card-body p-4">
                        @if($kehamilanAktif && $kehamilanAktif->kunjunganAncs->isNotEmpty())
                            <div class="timeline-modern mt-3">
                                @foreach($kehamilanAktif->kunjunganAncs as $index => $k)
                                    @php
                                        $rLevel = $k->skriningRisiko?->level_risiko ?? 'HIJAU';
                                        $dotClass = $rLevel == 'HIJAU' ? ($index == 0 ? 'active' : '') : (str_contains($rLevel, 'MERAH') ? 'danger' : 'warning');
                                    @endphp
                                    <div class="timeline-modern-item">
                                        <div class="timeline-dot {{ $dotClass }}">
                                            <i class="fas {{ $index == 0 ? 'fa-check' : 'fa-calendar-check' }} small"></i>
                                        </div>
                                        <div class="bg-light rounded-4 p-3 border border-white shadow-sm">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="fw-bold mb-0 text-dark">{{ $k->tanggal->format('d F Y') }}</h6>
                                                <span class="badge bg-white text-primary border rounded-pill">{{ $k->usia_kehamilan_minggu }} Minggu</span>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-sm-4">
                                                    <div class="small text-muted">Tensi</div>
                                                    <div class="fw-bold">{{ $k->tekanan_darah_sistolik }}/{{ $k->tekanan_darah_diastolik }}</div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="small text-muted">Protein Urine</div>
                                                    <div class="fw-bold text-{{ $k->protein_urine == 'Negatif' ? 'success' : 'danger' }}">{{ $k->protein_urine }}</div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="small text-muted">Denyut Janin</div>
                                                    <div class="fw-bold">{{ $k->djj }} x/mnt</div>
                                                </div>
                                            </div>
                                            @if($k->catatan_bidan)
                                                <div class="bg-white rounded-3 p-2 border-start border-4 border-primary">
                                                    <div class="small fw-bold text-primary mb-1">Pesan Bidan:</div>
                                                    <p class="small text-muted mb-0">"{{ $k->catatan_bidan }}"</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state py-5">
                                <i class="fas fa-clipboard-list fa-3x text-light mb-3"></i>
                                <h6>Belum ada riwayat periksa.</h6>
                                <p class="text-muted">Kunjungi Bidan untuk mulai memantau perkembangan Bunda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Info/Jadwal -->
            <div class="col-lg-4">
                <div class="card shadow-card portal-card mb-4 bg-primary text-white">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-calendar-alt me-2"></i> Jadwal Berikutnya</h6>
                        @php $nextJadwal = $kehamilanAktif?->jadwalKunjungans?->where('status', 'Terjadwal')->first(); @endphp
                        @if($nextJadwal)
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 mb-3 border border-white border-opacity-20">
                                <div class="h3 fw-bold mb-1">{{ $nextJadwal->tanggal_rencana->format('d M') }}</div>
                                <div class="small opacity-80">{{ $nextJadwal->tanggal_rencana->format('l, Y') }}</div>
                            </div>
                            <p class="small mb-0">Jangan lupa untuk periksa tepat waktu demi kesehatan Bunda dan Janin.</p>
                        @else
                            <div class="text-center py-3">
                                <p class="small mb-0 opacity-80">Belum ada jadwal tersusun.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-card portal-card mb-4">
                    <div class="card-header bg-white border-bottom p-4">
                        <h6 class="fw-bold mb-0">Edukasi Bunda</h6>
                    </div>
                    <div class="card-body p-0">
                        <a href="#" class="list-group-item list-group-item-action border-0 p-4 border-bottom">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <h6 class="fw-bold mb-0">Waspadai Preeklampsia</h6>
                                <i class="fas fa-chevron-right small text-muted"></i>
                            </div>
                            <p class="small text-muted mb-0">Mengenali gejala awal tekanan darah tinggi dalam kehamilan.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 p-4 border-bottom">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <h6 class="fw-bold mb-0">Gizi Selama Hamil</h6>
                                <i class="fas fa-chevron-right small text-muted"></i>
                            </div>
                            <p class="small text-muted mb-0">Daftar makanan super untuk perkembangan otak janin.</p>
                        </a>
                        <div class="p-3 text-center">
                            <a href="#" class="btn btn-link btn-sm text-decoration-none fw-bold">Lihat Semua Edukasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Support Float Button -->
<button class="btn btn-emergency btn-emergency-float" onclick="laporDarurat()">
    <i class="fas fa-phone-alt me-2"></i> LAPOR DARURAT
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
