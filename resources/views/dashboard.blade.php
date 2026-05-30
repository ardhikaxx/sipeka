@extends('layouts.app')

@section('title', 'Dasbor Utama')
@section('page_title', 'Dasbor')

@section('content')
<!-- Welcome Section -->
<div class="welcome-card">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-2">Selamat Pagi, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
            <p class="mb-4 opacity-75">Ini adalah ringkasan kesehatan ibu hamil dan aktivitas sistem anda hari ini. Tetap semangat menjaga kesehatan generasi!</p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('pasien.create') }}" class="btn btn-light rounded-pill px-4 fw-bold">
                    <i class="fas fa-plus me-2"></i> Tambah Pasien
                </a>
                <a href="{{ route('pasien.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">
                    <i class="fas fa-stethoscope me-2"></i> Catat ANC
                </a>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-end">
            <div class="bg-white bg-opacity-10 rounded-pill d-inline-block px-4 py-2 backdrop-blur">
                <i class="far fa-calendar-alt me-2"></i> {{ now()->isoFormat('dddd, D MMMM YYYY') }}
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card__icon" style="background: #E8F5F5; color: var(--peka-primary);">
                <i class="fas fa-users-line"></i>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__number">{{ $total_pasien }}</div>
                <div class="stat-card__label">Total Ibu Hamil</div>
                <div class="stat-card__sub">
                    <i class="fas fa-arrow-trend-up text-success"></i>
                    <span class="text-success fw-semibold">+8</span>
                    <span class="text-muted"> bulan ini</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card__icon" style="background: #EEF2FF; color: #3B5BDB;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__number">{{ $kunjungan_hari_ini }}</div>
                <div class="stat-card__label">Kunjungan Hari Ini</div>
                <div class="stat-card__sub">
                    <span class="text-muted">Perlu tindak lanjut</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card" style="border-left: 4px solid var(--risk-red)">
            <div class="stat-card__icon" style="background: var(--risk-red-bg); color: var(--risk-red);">
                <i class="fas fa-circle-exclamation"></i>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__number text-danger">{{ $pasien_risiko_tinggi }}</div>
                <div class="stat-card__label">Risiko Tinggi / PE</div>
                <div class="stat-card__sub">
                    <span class="badge bg-danger rounded-pill">Prioritas Pantauan</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card__icon" style="background: var(--peka-secondary-light); color: var(--peka-secondary);">
                <i class="fas fa-baby"></i>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__number">{{ $akan_bersalin }}</div>
                <div class="stat-card__label">HPL Mendatang</div>
                <div class="stat-card__sub">
                    <span class="text-muted">Dalam 4 minggu</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Main Content: Charts and Recent Patients -->
    <div class="col-12 col-lg-8">
        <!-- Trend Chart -->
        <div class="card border-0 shadow-card rounded-xl mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">Tren Kasus Preeklampsia (6 Bulan Terakhir)</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Tahun 2026
                    </button>
                </div>
            </div>
            <div class="card-body px-4 pb-4 pt-3">
                <canvas id="chartKasusBulanan" height="280"></canvas>
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">Pasien Kunjungan Terbaru</h5>
                <a href="{{ route('pasien.index') }}" class="btn btn-sm btn-peka-outline">Lihat Semua</a>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @forelse($pasien_terbaru as $p)
                    <div class="col-12 col-xl-6">
                        <div class="patient-card risk-{{ $p['risiko'] }} h-100 mb-0">
                            <div class="patient-card__avatar">
                                <i class="fas fa-person-pregnant"></i>
                            </div>
                            <div class="patient-card__info">
                                <div class="patient-card__name">{{ $p['nama'] }}</div>
                                <div class="patient-card__meta">
                                    <span><i class="fas fa-calendar-days me-1"></i> UK {{ $p['uk'] }} Mgg</span>
                                    <span><i class="fas fa-map-marker-alt me-1"></i> {{ $p['desa'] }}</span>
                                </div>
                                <div class="patient-card__vitals">
                                    <span class="vital-chip vital-chip--td">{{ $p['td'] }}</span>
                                    @if($p['protein'] !== 'Negatif')
                                        <span class="vital-chip vital-chip--protein">Protein {{ $p['protein'] }}</span>
                                    @else
                                        <span class="vital-chip vital-chip--normal">Protein (-)</span>
                                    @endif
                                </div>
                            </div>
                            <div class="patient-card__actions text-end">
                                <span class="badge-risk badge-risk--{{ $p['risiko'] }} mb-2">{{ $p['risiko_label'] }}</span>
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('pasien.show', $p['id']) }}" class="btn btn-sm btn-light border p-1 px-2" title="Detail"><i class="fas fa-eye"></i></a>
                                    @if($p['kehamilan_id'])
                                    <a href="{{ route('kunjungan.create', ['kehamilan_id' => $p['kehamilan_id']]) }}" class="btn btn-sm btn-peka-primary p-1 px-2" title="Kunjungan Baru"><i class="fas fa-plus"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4 text-muted">
                        <i class="fas fa-user-slash d-block fs-2 mb-2 opacity-25"></i>
                        Belum ada data pasien terbaru.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar: Risk Distribution and Urgent Info -->
    <div class="col-12 col-lg-4">
        <!-- Distribution Chart -->
        <div class="card border-0 shadow-card rounded-xl mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="section-title mb-0">Distribusi Risiko</h5>
            </div>
            <div class="card-body px-4 pb-4 pt-3">
                <div style="height: 240px;">
                    <canvas id="chartDistribusiRisiko"></canvas>
                </div>
            </div>
        </div>

        <!-- Emergency Alerts -->
        @if(count($laporan_darurat) > 0)
        <div class="card border-0 shadow-card rounded-xl mb-4" style="border-top: 4px solid var(--risk-red) !important;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0 text-danger"><i class="fas fa-triangle-exclamation me-2"></i>Laporan Darurat</h5>
                <span class="badge bg-danger">{{ count($laporan_darurat) }}</span>
            </div>
            <div class="card-body p-3">
                @foreach($laporan_darurat as $darurat)
                <a href="{{ route('darurat.index') }}" class="list-item-modern text-decoration-none">
                    <div class="list-item-modern__icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $darurat->pasien->nama }}</div>
                        <div class="text-muted small">{{ $darurat->created_at->diffForHumans() }} • {{ $darurat->jenis_darurat }}</div>
                    </div>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Referrals -->
        @if(count($rujukan_masuk) > 0)
        <div class="card border-0 shadow-card rounded-xl mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">Rujukan Terbaru</h5>
            </div>
            <div class="card-body p-3">
                @foreach($rujukan_masuk as $rujukan)
                <div class="list-item-modern">
                    <div class="list-item-modern__icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $rujukan->kehamilan->pasien->nama }}</div>
                        <div class="text-muted small">Dari: {{ $rujukan->fasilitasAsal?->nama ?? 'Bidan' }}</div>
                    </div>
                    <a href="{{ route('rujukan.show', $rujukan->id) }}" class="btn btn-sm btn-light border p-1 px-2"><i class="fas fa-eye"></i></a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Help / Tips -->
        <div class="card border-0 shadow-card rounded-xl bg-light">
            <div class="card-body p-4 text-center">
                <div class="mb-3 text-peka-primary fs-3">
                    <i class="fas fa-circle-question"></i>
                </div>
                <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                <p class="text-muted small mb-3">Pelajari panduan penggunaan sistem SIPEKA untuk hasil maksimal.</p>
                <a href="#" class="btn btn-sm btn-peka-outline w-100">Buka Panduan</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Distribusi Risiko
    const ctxRisiko = document.getElementById('chartDistribusiRisiko').getContext('2d');
    new Chart(ctxRisiko, {
        type: 'doughnut',
        data: {
            labels: ['Risiko Rendah', 'Waspada', 'Preeklampsia', 'Kritis'],
            datasets: [{
                data: @json($risk_counts),
                backgroundColor: ['#1DB954', '#F59E0B', '#EF4444', '#7C0000'],
                borderWidth: 0,
                hoverOffset: 12,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, 
                        padding: 20, 
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: '#1E293B',
                    padding: 12,
                    titleFont: { family: 'Plus Jakarta Sans', size: 13 },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 13 },
                    cornerRadius: 8
                }
            }
        }
    });

    // Chart Kasus Bulanan
    const ctxBulanan = document.getElementById('chartKasusBulanan').getContext('2d');
    new Chart(ctxBulanan, {
        type: 'bar',
        data: {
            labels: @json($monthly_labels),
            datasets: [
                {
                    label: 'Waspada (Kuning)',
                    data: @json($monthly_yellow),
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: '#F59E0B',
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 15,
                },
                {
                    label: 'Preeklampsia (Merah)',
                    data: @json($monthly_red),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: '#EF4444',
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 15,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { 
                        font: { family: 'Plus Jakarta Sans', size: 12, weight: '600' }, 
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#1E293B',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: { 
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', weight: '600' } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                    ticks: { 
                        stepSize: 2,
                        font: { family: 'Plus Jakarta Sans' }
                    }
                }
            }
        }
    });
});
</script>
@endpush
