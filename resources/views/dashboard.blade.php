@extends('layouts.app')

@section('title', 'Dasboard Utama')
@section('page_title', 'Dasboard Pelayanan Kesehatan Ibu')

@section('content')
<div class="premium-hero mb-3 mb-md-4 p-3 p-md-4">
    <div class="hero-glow"></div>
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-12 col-lg-8 text-center text-lg-start">
            <h1 class="fw-extrabold mb-2 text-white" style="font-family: var(--font-heading); font-size: calc(1.5rem + 1vw); letter-spacing: -0.03em; line-height: 1.1;">
                Selamat Pagi,<br class="d-none d-md-block"> {{ auth()->user()->name }}! 
            </h1>
            <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-2 mt-3">
                <a href="{{ route('pasien.create') }}" class="btn btn-premium-outline px-3 py-2 small flex-fill flex-sm-grow-0" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                    <i class="fas fa-plus-circle me-1"></i> PASIEN BARU
                </a>
                <a href="{{ route('pasien.index') }}" class="btn btn-premium-outline px-3 py-2 small flex-fill flex-sm-grow-0" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                    <i class="fas fa-clipboard-check me-1"></i> DAFTAR ANC
                </a>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block">
             <div class="hero-stats-glass p-3 rounded-4 shadow-lg border border-white border-opacity-20">
                <div class="text-white-50 small uppercase-font fw-bold mb-2 border-bottom border-white border-opacity-10 pb-2">RINGKASAN TUGAS</div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white-50 small">Kunjungan Selesai</span>
                        <span class="badge bg-white bg-opacity-10 rounded-pill px-2 fw-bold">0 / {{ $kunjungan_hari_ini }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white-50 small">Rujukan Dipantau</span>
                        <span class="badge bg-white bg-opacity-10 rounded-pill px-2 fw-bold">{{ count($rujukan_masuk) }}</span>
                    </div>
                    <div class="progress bg-white bg-opacity-10 mt-1" style="height: 4px; border-radius: 10px;">
                        <div class="progress-bar bg-warning shadow-warning" style="width: 15%"></div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

<!-- Dynamic Stats Cards -->
<div class="row g-2 g-md-3 mb-3">
    <div class="col-6 col-xl-3">
        <div class="card-stat-premium primary h-100 p-3 p-md-4">
            <div class="card-stat-premium__icon d-none d-sm-flex"><i class="fas fa-hospital-user"></i></div>
            <div class="card-stat-premium__data">
                <div class="value fs-3 fs-md-2">{{ $total_pasien }}</div>
                <div class="label x-small">PASIEN</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card-stat-premium info h-100 p-3 p-md-4">
            <div class="card-stat-premium__icon d-none d-sm-flex"><i class="fas fa-stethoscope"></i></div>
            <div class="card-stat-premium__data">
                <div class="value fs-3 fs-md-2">{{ $kunjungan_hari_ini }}</div>
                <div class="label x-small">ANC HARI INI</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card-stat-premium danger h-100 p-3 p-md-4">
            <div class="card-stat-premium__icon d-none d-sm-flex"><i class="fas fa-biohazard"></i></div>
            <div class="card-stat-premium__data">
                <div class="value text-danger fs-3 fs-md-2">{{ $pasien_risiko_tinggi }}</div>
                <div class="label x-small">RISIKO TINGGI</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card-stat-premium secondary h-100 p-3 p-md-4">
            <div class="card-stat-premium__icon d-none d-sm-flex"><i class="fas fa-baby-carriage"></i></div>
            <div class="card-stat-premium__data">
                <div class="value fs-3 fs-md-2">{{ $akan_bersalin }}</div>
                <div class="label x-small">ESTIMASI HPL</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 g-md-3">
    <!-- Center Column -->
    <div class="col-12 col-lg-8">
        <!-- Visual Intelligence Card -->
        <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
            <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="section-title mb-1 small fw-bold">Health Intelligence</h5>
                    <p class="text-hint mb-0 x-small" id="chartSubtitle">Tren kasus Preeklampsia bulanan</p>
                </div>
                <div class="btn-group shadow-sm rounded-pill p-1 bg-light">
                    <button class="btn btn-sm btn-white rounded-pill px-3 active fw-bold x-small" id="btnShowKasus" onclick="switchChart('kasus')">Kasus</button>
                    <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold x-small" id="btnShowRujukan" onclick="switchChart('rujukan')">Rujukan</button>
                </div>
            </div>
            <div class="card-body px-3 px-md-4 pb-4 pt-2">
                <div style="height: 250px;">
                    <canvas id="chartKasusBulanan"></canvas>
                </div>
            </div>
        </div>

        <!-- Action Table Card -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden mb-4 mb-lg-0">
            <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-0 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0 small fw-bold">Pasien Terbaru</h5>
                <a href="{{ route('pasien.index') }}" class="text-peka-primary text-decoration-none fw-bold x-small">LIHAT SEMUA</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-top">
                        <thead class="bg-light text-muted uppercase-font" style="font-size: 0.65rem; border-bottom: 2px solid var(--gray-200);">
                            <tr>
                                <th class="ps-3 ps-md-4 py-3 border-0">PASIEN</th>
                                <th class="d-none d-sm-table-cell border-0">USIA KANDUNGAN</th>
                                <th class="d-none d-md-table-cell border-0">TANDA VITAL & LAB</th>
                                <th class="border-0">STATUS KLINIS</th>
                                <th class="pe-3 pe-md-4 text-end border-0">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pasien_terbaru as $p)
                            @php
                                $bgAvatar = match($p['risiko']) {
                                    'kritis', 'merah_kritis' => 'bg-danger text-white border-danger-subtle',
                                    'merah' => 'bg-danger-subtle text-danger border-white',
                                    'kuning' => 'bg-warning-subtle text-warning border-white',
                                    default => 'bg-success-subtle text-success border-white'
                                };
                            @endphp
                            <tr class="clickable-row" onclick="window.location='{{ route('pasien.show', $p['id']) }}'" style="border-bottom: 1px solid var(--gray-100); transition: all 0.2s ease;">
                                <td class="ps-3 ps-md-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm {{ $bgAvatar }} rounded-circle d-none d-sm-flex align-items-center justify-content-center fw-bold shadow-sm border-2"
                                            style="width: 40px; height: 40px; font-size: 0.95rem;">
                                            {{ substr($p['nama'], 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">{{ $p['nama'] }}</div>
                                            <div class="text-hint x-small d-flex align-items-center gap-1"><i class="fas fa-map-marker-alt text-peka-primary opacity-50"></i> {{ $p['desa'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-sm-table-cell align-middle">
                                    <div class="d-inline-flex align-items-center gap-2 bg-light border rounded-pill px-3 py-1 shadow-sm">
                                        <i class="fas fa-baby text-peka-primary opacity-75 x-small"></i>
                                        <span class="text-dark fw-bold" style="font-size: 0.75rem;">{{ $p['uk'] }} <span class="fw-normal text-muted">Mg</span></span>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-heart-pulse text-danger x-small opacity-75"></i>
                                            <span class="text-dark fw-bold border-bottom border-danger-subtle border-2 pb-1" style="font-size: 0.8rem;">{{ $p['td'] }}</span>
                                        </div>
                                        <div class="vr opacity-25" style="height: 15px;"></div>
                                        <div class="d-flex align-items-center gap-1 x-small text-muted">
                                            <span>Prot:</span>
                                            <strong class="px-2 py-1 rounded-2 {{ $p['protein'] === 'Negatif' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}" style="font-size: 0.7rem;">{{ $p['protein'] }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge-risk-premium {{ $p['risiko'] }} shadow-sm" style="font-size: 0.65rem; padding: 6px 14px; letter-spacing: 0.05em;">
                                        {{ strtoupper($p['risiko_label']) }}
                                    </span>
                                </td>
                                <td class="pe-3 pe-md-4 text-end align-middle">
                                    <a href="{{ route('pasien.show', $p['id']) }}" class="btn btn-sm btn-white border shadow-sm px-3 text-primary rounded-pill hvr-icon-forward d-inline-flex align-items-center gap-2" title="Buka Rekam Medis">
                                        <span class="d-none d-xl-inline x-small fw-bold">Detail</span>
                                        <i class="fas fa-arrow-right x-small hvr-icon"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="icon-box-sm bg-light text-muted rounded-circle mx-auto mb-3" style="width: 48px; height: 48px;"><i class="fas fa-user-slash"></i></div>
                                        <p class="text-muted small fw-bold mb-0">Belum ada pasien yang diperiksa.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-12 col-lg-4">
        <!-- Distribution Dashboard -->
        <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                <h5 class="section-title mb-1 small fw-bold">Sebaran Risiko</h5>
                <p class="text-hint mb-0 x-small">Proporsi kondisi kesehatan ibu</p>
            </div>
            <div class="card-body px-3 px-md-4 pb-4 pt-3 text-center">
                <div style="height: 220px; position: relative;">
                    <canvas id="chartDistribusiRisiko"></canvas>
                </div>
            </div>
        </div>

        <!-- Command Emergency Center -->
        @if(count($laporan_darurat) > 0)
        <div class="emergency-center-card mb-4 overflow-hidden">
            <div class="card-header bg-danger bg-opacity-90 text-white py-3 px-4 d-flex justify-content-between align-items-center border-0 shadow-lg">
                <div class="d-flex align-items-center gap-2">
                    <div class="spinner-grow spinner-grow-sm text-white" role="status"></div>
                    <h6 class="mb-0 fw-bold uppercase-font">PANEL DARURAT</h6>
                </div>
                <span class="badge bg-white text-danger fw-extrabold rounded-pill px-3">{{ count($laporan_darurat) }} AKTIF</span>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush bg-white">
                    @foreach($laporan_darurat as $darurat)
                    <a href="{{ route('darurat.index') }}" class="list-group-item list-group-item-action p-4 border-0 border-bottom border-danger border-opacity-10">
                        <div class="d-flex align-items-start gap-3">
                            <div class="avatar-emergency bg-danger text-white shadow-danger">
                                <i class="fas fa-phone-flip"></i>
                            </div>
                            <div class="grow">
                                <div class="fw-extrabold text-dark mb-1">{{ $darurat->pasien->nama }}</div>
                                <div class="badge bg-danger bg-opacity-10 text-danger small fw-bold px-2 py-1 mb-2">{{ $darurat->jenis_darurat }}</div>
                                <div class="text-hint x-small d-flex align-items-center gap-1 mt-1">
                                    <i class="far fa-clock"></i> <span>Diterima {{ $darurat->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="p-3 text-center bg-danger bg-opacity-5">
                    <a href="{{ route('darurat.index') }}" class="small text-white fw-bold text-decoration-none hvr-icon-forward">
                        RESPON SEMUA DARURAT <i class="fas fa-arrow-right ms-2 hvr-icon"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Premium Dashboard Styles */
    .premium-hero { background: linear-gradient(135deg, #1A6B6B 0%, #0c3d3d 100%); padding: 55px; border-radius: 30px; position: relative; overflow: hidden; color: white; box-shadow: 0 20px 40px rgba(12, 61, 61, 0.2); }
    .hero-glow { position: absolute; top: -50%; left: -20%; width: 100%; height: 200%; background: radial-gradient(circle, rgba(42, 143, 143, 0.2) 0%, transparent 70%); z-index: 1; pointer-events: none; }
    .hero-stats-glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15); }
    
    .btn-premium-white { background: white; color: var(--peka-primary); border-radius: 50px; padding: 12px 32px; font-weight: 800; font-size: 0.85rem; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: all 0.3s; }
    .btn-premium-white:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); background: #f8f9fa; }
    
    .btn-premium-outline { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; padding: 12px 32px; font-weight: 800; font-size: 0.85rem; backdrop-filter: blur(5px); transition: all 0.3s; }
    .btn-premium-outline:hover { background: rgba(255,255,255,0.2); border-color: white; transform: translateY(-3px); }

    .card-stat-premium { background: white; padding: 24px; border-radius: 24px; display: flex; align-items: center; gap: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid rgba(0,0,0,0.02); }
    .card-stat-premium:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); }
    .card-stat-premium__icon { width: 58px; height: 58px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
    .card-stat-premium__data .value { font-size: 2.2rem; font-weight: 900; line-height: 1; color: var(--gray-900); font-family: var(--font-heading); letter-spacing: -0.02em; }
    .card-stat-premium__data .label { font-size: 0.65rem; font-weight: 800; color: var(--gray-400); letter-spacing: 0.1em; margin-top: 4px; }
    .card-stat-premium__trend { margin-left: auto; font-weight: 800; font-size: 0.75rem; align-self: flex-start; }

    .card-stat-premium.primary .card-stat-premium__icon { background: #E8F5F5; color: var(--peka-primary); }
    .card-stat-premium.info .card-stat-premium__icon { background: #EEF2FF; color: #3B5BDB; }
    .card-stat-premium.danger .card-stat-premium__icon { background: #FEF2F2; color: #EF4444; }
    .card-stat-premium.secondary .card-stat-premium__icon { background: #FDEEF6; color: var(--peka-secondary); }

    .pulse-indicator { width: 10px; height: 10px; background: #2A8F8F; border-radius: 50%; animation: pulse-green 2s infinite; }
    @keyframes pulse-green { 0% { box-shadow: 0 0 0 0 rgba(42, 143, 143, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(42, 143, 143, 0); } 100% { box-shadow: 0 0 0 0 rgba(42, 143, 143, 0); } }

    .avatar-stat { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
    .clickable-row { cursor: pointer; transition: background 0.15s; }
    .clickable-row:hover { background-color: var(--gray-50) !important; }

    .badge-risk-premium { padding: 6px 14px; border-radius: 50px; font-weight: 800; font-size: 0.65rem; display: inline-block; }
    .badge-risk-premium.hijau { background: #E8F8EE; color: #0D7A35; }
    .badge-risk-premium.kuning { background: #FFFBEB; color: #9A6202; }
    .badge-risk-premium.merah { background: #FEF2F2; color: #C41212; }
    .badge-risk-premium.merah_kritis { background: #7C0000; color: white; }

    .emergency-center-card { border-radius: 24px; box-shadow: 0 15px 40px rgba(220, 38, 38, 0.15); border: 1px solid rgba(220, 38, 38, 0.1); }
    .avatar-emergency { width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .shadow-warning { box-shadow: 0 0 15px rgba(245, 158, 11, 0.4); }
    .shadow-danger { box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2); }
</style>
@endsection

@push('scripts')
<script>
let mainChart;
const chartLabels = @json($monthly_labels);
const dataKasus = {
    labels: chartLabels,
    datasets: [
        {
            label: 'Waspada (Kuning)',
            data: @json($monthly_yellow),
            backgroundColor: '#F59E0B',
            borderRadius: 50,
            barThickness: 10,
        },
        {
            label: 'Preeklampsia (Merah)',
            data: @json($monthly_red),
            backgroundColor: '#EF4444',
            borderRadius: 50,
            barThickness: 10,
        }
    ]
};

const dataRujukan = {
    labels: chartLabels,
    datasets: [{
        label: 'Total Rujukan',
        data: @json($monthly_rujukan),
        backgroundColor: '#1A6B6B',
        borderRadius: 50,
        barThickness: 20,
    }]
};

function switchChart(type) {
    const subtitle = document.getElementById('chartSubtitle');
    const btnKasus = document.getElementById('btnShowKasus');
    const btnRujukan = document.getElementById('btnShowRujukan');

    if (type === 'kasus') {
        mainChart.data = dataKasus;
        subtitle.innerText = 'Visualisasi tren kasus Preeklampsia bulanan';
        btnKasus.classList.add('btn-white', 'active');
        btnKasus.classList.remove('btn-light');
        btnRujukan.classList.remove('btn-white', 'active');
        btnRujukan.classList.add('btn-light');
    } else {
        mainChart.data = dataRujukan;
        subtitle.innerText = 'Visualisasi tren rujukan pasien ke Rumah Sakit';
        btnRujukan.classList.add('btn-white', 'active');
        btnRujukan.classList.remove('btn-light');
        btnKasus.classList.remove('btn-white', 'active');
        btnKasus.classList.add('btn-light');
    }
    mainChart.update();
}

document.addEventListener('DOMContentLoaded', function() {
    // Chart Settings Global
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = "#94A3B8";

    // Main Trend Chart
    const ctxMain = document.getElementById('chartKasusBulanan').getContext('2d');
    mainChart = new Chart(ctxMain, {
        type: 'bar',
        data: dataKasus,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', align: 'end', labels: { boxWidth: 8, boxHeight: 8, usePointStyle: true, pointStyle: 'circle', font: { weight: '800', size: 11 } } },
                tooltip: { backgroundColor: '#1E293B', padding: 12, cornerRadius: 10, usePointStyle: true }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { weight: '700', size: 11 } } },
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.02)', drawBorder: false }, ticks: { stepSize: 2 } }
            }
        }
    });

    // Chart Distribusi Risiko
    const ctxRisiko = document.getElementById('chartDistribusiRisiko').getContext('2d');
    new Chart(ctxRisiko, {
        type: 'doughnut',
        data: {
            labels: ['Normal', 'Waspada', 'Tinggi', 'Kritis'],
            datasets: [{
                data: @json($risk_counts),
                backgroundColor: ['#1DB954', '#F59E0B', '#EF4444', '#7C0000'],
                borderWidth: 0,
                hoverOffset: 25,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '82%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 25, usePointStyle: true, pointStyle: 'circle', font: { weight: '800', size: 11 } } },
                tooltip: { backgroundColor: '#1E293B', padding: 12, cornerRadius: 10 }
            }
        }
    });
});
</script>
@endpush
