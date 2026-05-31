@extends('layouts.app')

@section('title', 'Detail Rekam Medis')
@section('page_title', 'Rekam Medis Pasien')

@section('content')
<!-- Patient Profile Header -->
<div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="row g-0">
            <div class="col-12 col-lg-8 p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3 gap-md-4 text-center text-md-start">
                    <div class="avatar-lg bg-danger text-white rounded-4 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 70px; height: 70px; font-size: 2rem;">
                        <i class="fas fa-person-pregnant"></i>
                    </div>
                    <div class="grow w-100">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center align-items-sm-start gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold mb-1">{{ $pasien->nama }}</h4>
                                <div class="text-muted d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2 gap-md-3 small">
                                    <span><i class="fas fa-id-card me-1"></i> {{ $pasien->nik }}</span>
                                    <span class="d-none d-sm-inline opacity-25">|</span>
                                    <span><i class="fas fa-cake-candles me-1"></i> {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} Thn</span>
                                </div>
                            </div>
                            <div class="mt-1 mt-sm-0">
                                <span class="badge bg-peka-primary-pale text-peka-primary px-3 py-2 rounded-pill fw-bold small">
                                    G{{ $kehamilanAktif?->gravida ?? 0 }} P{{ $kehamilanAktif?->para ?? 0 }} A{{ $kehamilanAktif?->abortus ?? 0 }}
                                </span>
                            </div>
                        </div>
                        <div class="p-3 bg-light rounded-3">
                            <div class="row g-3">
                                <div class="col-6 col-md-4 text-center text-md-start">
                                    <div class="text-hint x-small mb-1">HPHT</div>
                                    <div class="fw-bold small">{{ $kehamilanAktif ? \Carbon\Carbon::parse($kehamilanAktif->hpht)->format('d/m/y') : '-' }}</div>
                                </div>
                                <div class="col-6 col-md-4 text-center text-md-start border-start-md">
                                    <div class="text-hint x-small mb-1">TP (Taksiran)</div>
                                    <div class="fw-bold text-primary small">{{ $kehamilanAktif ? \Carbon\Carbon::parse($kehamilanAktif->tp)->format('d/m/y') : '-' }}</div>
                                </div>
                                <div class="col-12 col-md-4 text-center text-md-start border-start-md">
                                    <div class="text-hint x-small mb-1">Wilayah / Alamat</div>
                                    <div class="fw-bold text-truncate small mx-auto mx-md-0" style="max-width: 200px;">{{ $pasien->alamat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 bg-light border-start-lg p-3 p-md-4 d-flex flex-column justify-content-center">
                <div class="d-grid gap-2">
                    @if($kehamilanAktif)
                        <a href="{{ route('kunjungan.create', ['kehamilan_id' => $kehamilanAktif->id]) }}" class="btn btn-peka-primary py-2 shadow-sm fw-bold small">
                            <i class="fas fa-plus me-2"></i> INPUT KUNJUNGAN ANC
                        </a>
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('persalinan.create', $kehamilanAktif) }}" class="btn btn-peka-outline w-100 py-2 small fw-bold">
                                    <i class="fas fa-baby me-1"></i> PERSALINAN
                                </a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-white border w-100 py-2 small fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditPasien">
                                    <i class="fas fa-edit me-1"></i> EDIT
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-2">
                            <i class="fas fa-info-circle text-muted mb-1 fs-4"></i>
                            <p class="x-small text-muted mb-0">Tidak ada kehamilan aktif.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($kehamilanAktif)
<!-- Main Tabs Navigation -->
<div class="nav-wrapper mb-4 scrollbar-hidden">
    <ul class="nav nav-pills flex-nowrap gap-2 p-1 bg-white rounded-pill shadow-sm d-inline-flex" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill px-3 px-md-4 py-2 small" id="pills-riwayat-tab" data-bs-toggle="pill" data-bs-target="#pills-riwayat" type="button" role="tab">
                <i class="fas fa-notes-medical me-1 me-md-2"></i> Riwayat
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-3 px-md-4 py-2 small" id="pills-grafik-tab" data-bs-toggle="pill" data-bs-target="#pills-grafik" type="button" role="tab">
                <i class="fas fa-chart-line me-1 me-md-2"></i> Tren
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-3 px-md-4 py-2 small" id="pills-jadwal-tab" data-bs-toggle="pill" data-bs-target="#pills-jadwal" type="button" role="tab">
                <i class="fas fa-calendar-alt me-1 me-md-2"></i> Jadwal
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-3 px-md-4 py-2 small" id="pills-rujukan-tab" data-bs-toggle="pill" data-bs-target="#pills-rujukan" type="button" role="tab">
                <i class="fas fa-ambulance me-1 me-md-2"></i> Rujukan
            </button>
        </li>
    </ul>
</div>

<div class="tab-content" id="pills-tabContent">
    <!-- Riwayat Kunjungan Tab -->
    <div class="tab-pane fade show active" id="pills-riwayat" role="tabpanel">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
                <h6 class="section-title mb-0">Riwayat ANC</h6>
                <span class="badge bg-light text-dark border small">{{ $kehamilanAktif->kunjunganAncs->count() }} Kunjungan</span>
            </div>
            <div class="card-body p-0">
                @if($kehamilanAktif->kunjunganAncs->isEmpty())
                    <div class="empty-state py-5">
                        <i class="fas fa-stethoscope fa-2x text-light mb-3 opacity-50"></i>
                        <h6 class="small fw-bold">Belum Ada Kunjungan</h6>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted x-small fw-bold">
                                <tr>
                                    <th class="ps-3 ps-md-4">TANGGAL</th>
                                    <th>UK</th>
                                    <th class="d-none d-md-table-cell">BB & IMT</th>
                                    <th>VITAL</th>
                                    <th class="d-none d-sm-table-cell text-center">PROT.</th>
                                    <th>RISIKO</th>
                                    <th class="pe-3 pe-md-4 text-end">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kehamilanAktif->kunjunganAncs->sortByDesc('tanggal') as $kunjungan)
                                @php
                                    $level = $kunjungan->skriningRisiko?->level_risiko ?? 'HIJAU';
                                    $badge = $level === 'MERAH_KRITIS' ? 'critical' : ($level === 'MERAH' ? 'red' : ($level === 'KUNING' ? 'yellow' : 'green'));
                                @endphp
                                <tr>
                                    <td class="ps-3 ps-md-4 py-3">
                                        <div class="fw-bold small">{{ $kunjungan->tanggal->format('d/m/y') }}</div>
                                        <div class="text-hint x-small">{{ $kunjungan->tanggal->diffForHumans() }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border small">{{ $kunjungan->usia_kehamilan_minggu }} Mg</span></td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="fw-medium text-dark small">{{ $kunjungan->berat_badan }} kg</div>
                                        <div class="text-hint x-small">IMT: {{ $kunjungan->imt ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="vital-chip vital-chip--td small px-2 py-1">
                                            {{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }}
                                        </span>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center">
                                        <span class="vital-chip {{ $kunjungan->protein_urine === 'Negatif' ? 'vital-chip--normal' : 'vital-chip--protein' }} x-small px-2">
                                            {{ $kunjungan->protein_urine }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-risk badge-risk--{{ $badge }}" style="font-size: 0.6rem;">
                                            {{ str_replace('_', ' ', $kunjungan->skriningRisiko?->status ?? 'NORMAL') }}
                                        </span>
                                    </td>
                                    <td class="pe-3 pe-md-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li><a class="dropdown-item py-2 small" href="{{ route('kunjungan.show', $kunjungan) }}"><i class="fas fa-file-invoice text-muted me-2"></i> Detail</a></li>
                                                @if(in_array($level, ['KUNING','MERAH','MERAH_KRITIS']))
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item py-2 text-danger fw-bold small" href="{{ route('rujukan.create', ['kunjungan_id' => $kunjungan->id]) }}"><i class="fas fa-ambulance me-2"></i> Rujukan</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Grafik Tren Tab -->
    <div class="tab-pane fade" id="pills-grafik" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-card rounded-xl">
                    <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between">
                        <h5 class="section-title mb-0">Tren Tekanan Darah</h5>
                        <div class="small text-muted">Berdasarkan riwayat kunjungan ANC</div>
                    </div>
                    <div class="card-body p-4">
                        <div style="height: 350px;">
                            <canvas id="chartTekananDarah"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Tab -->
    <div class="tab-pane fade" id="pills-jadwal" role="tabpanel">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">Rencana Kunjungan Berikutnya</h5>
                <button class="btn btn-sm btn-peka-primary" data-bs-toggle="collapse" data-bs-target="#collapseAddJadwal">
                    <i class="fas fa-plus me-1"></i> Tambah Jadwal
                </button>
            </div>
            <div class="collapse border-bottom" id="collapseAddJadwal">
                <div class="p-4 bg-light">
                    <form method="POST" action="{{ route('jadwal.store', $kehamilanAktif) }}" class="row g-3 align-items-end">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tanggal Rencana</label>
                            <input type="date" name="tanggal_rencana" class="form-control-peka" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status Awal</label>
                            <input type="text" class="form-control-peka bg-white" value="Terjadwal" readonly>
                            <input type="hidden" name="status" value="Terjadwal">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-peka-primary w-100 py-2" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small fw-bold">
                            <tr>
                                <th class="ps-4">TANGGAL RENCANA</th>
                                <th>STATUS</th>
                                <th>REALISASI</th>
                                <th class="pe-4 text-end">UPDATE STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kehamilanAktif->jadwalKunjungans->sortByDesc('tanggal_rencana') as $jadwal)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $jadwal->tanggal_rencana->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $statusColor = [
                                            'Terjadwal' => 'bg-info',
                                            'Selesai' => 'bg-success',
                                            'Terlewat' => 'bg-danger',
                                            'Perlu Follow-up' => 'bg-warning'
                                        ][$jadwal->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusColor }} px-3 rounded-pill">{{ $jadwal->status }}</span>
                                </td>
                                <td>{{ $jadwal->tanggal_realisasi?->format('d M Y') ?? '-' }}</td>
                                <td class="pe-4 text-end">
                                    <form method="POST" action="{{ route('jadwal.update', $jadwal) }}" class="d-inline-flex gap-2">
                                        @csrf @method('PATCH')
                                        <div class="input-group input-group-sm">
                                            <input type="date" name="tanggal_realisasi" class="form-control" value="{{ optional($jadwal->tanggal_realisasi)->format('Y-m-d') }}">
                                            <select name="status" class="form-select border-start-0">
                                                @foreach(['Terjadwal','Selesai','Terlewat','Perlu Follow-up'] as $status)
                                                    <option value="{{ $status }}" @selected($jadwal->status === $status)>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-peka-primary" type="submit"><i class="fas fa-save"></i></button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-5 text-center text-muted">Belum ada jadwal yang direncanakan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rujukan Tab -->
    <div class="tab-pane fade" id="pills-rujukan" role="tabpanel">
        <div class="card border-0 shadow-card rounded-xl">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">Riwayat Rujukan</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    @forelse($kehamilanAktif->rujukans as $rujukan)
                        <div class="col-md-6">
                            <div class="patient-card shadow-sm border p-3 rounded-3 position-relative overflow-hidden">
                                <div class="position-absolute top-0 inset-e-0 p-3">
                                    <span class="badge bg-warning text-dark rounded-pill px-3">{{ ucfirst($rujukan->status) }}</span>
                                </div>
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="stat-card__icon bg-warning-subtle text-warning rounded-circle" style="width: 48px; height: 48px;">
                                        <i class="fas fa-ambulance"></i>
                                    </div>
                                    <div class="grow">
                                        <div class="fw-bold text-dark fs-5 mb-1">{{ $rujukan->fasilitasTujuan->nama }}</div>
                                        <div class="text-hint mb-3"><i class="fas fa-calendar-day me-1"></i> {{ $rujukan->created_at->format('d M Y, H:i') }}</div>
                                        <div class="p-2 bg-light rounded small mb-3 border-start border-4 border-warning">
                                            <strong>Diagnosa:</strong><br>
                                            {{ $rujukan->diagnosa_sementara }}
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-peka-primary grow">Lihat Detail Rujukan</a>
                                            <button class="btn btn-sm btn-light border"><i class="fas fa-print"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-ambulance fa-3x text-light mb-3"></i>
                            <h6>Tidak Ada Data Rujukan</h6>
                            <p class="text-muted">Pasien ini belum pernah dirujuk selama masa kehamilan ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .nav-pills .nav-link { color: var(--text-secondary); font-weight: 600; font-size: 0.875rem; border: 1px solid transparent; }
    .nav-pills .nav-link.active { background-color: var(--peka-primary); color: white; box-shadow: 0 4px 10px rgba(26,107,107,0.2); }
    .nav-pills .nav-link:not(.active):hover { background-color: var(--gray-50); border-color: var(--gray-200); }
    .avatar-lg { flex-shrink: 0; }
    .vital-chip--normal { background: #EBFBEE; color: #2B8A3E; }
    .nav-wrapper { white-space: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    const canvas = document.getElementById('chartTekananDarah');
    if (!canvas) return;

    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                { 
                    label: 'Sistolik', 
                    data: chartData.sistolik, 
                    borderColor: '#EF4444', 
                    backgroundColor: 'rgba(239,68,68, 0.1)', 
                    borderWidth: 3, 
                    pointBackgroundColor: '#EF4444',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3, 
                    fill: true 
                },
                { 
                    label: 'Diastolik', 
                    data: chartData.diastolik, 
                    borderColor: '#3B5BDB', 
                    backgroundColor: 'rgba(59,91,219, 0.05)', 
                    borderWidth: 3, 
                    pointBackgroundColor: '#3B5BDB',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3, 
                    fill: true 
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, font: { weight: 'bold' } } },
                tooltip: { padding: 12, cornerRadius: 10, backgroundColor: '#1E293B' }
            },
            scales: { 
                y: { 
                    min: 50, 
                    max: 200, 
                    ticks: { stepSize: 20, callback: v => v + ' mmHg' },
                    grid: { borderDash: [5, 5] }
                }, 
                x: { grid: { display: false } } 
            }
        }
    });
});
</script>
@endpush
