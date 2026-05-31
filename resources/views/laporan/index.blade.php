@extends('layouts.app')

@section('title', 'Pusat Laporan & Statistik')
@section('page_title', 'Laporan & Statistik')

@section('content')
<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-users-line"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $totalPasien }}</div>
                <div class="stat-card__label x-small">Total Pasien</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-info-subtle text-info">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $totalKunjungan }}</div>
                <div class="stat-card__label x-small">Kunjungan ANC</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-ambulance"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $totalRujukan }}</div>
                <div class="stat-card__label x-small">Total Rujukan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-danger-subtle text-danger">
                <i class="fas fa-baby"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $totalPersalinan }}</div>
                <div class="stat-card__label x-small">Persalinan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 g-lg-4 mb-4">
    <!-- Risk Distribution Chart -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-card rounded-xl h-100">
            <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                <h5 class="section-title mb-0 small fw-bold">Distribusi Risiko</h5>
            </div>
            <div class="card-body p-3 p-md-4 d-flex flex-column align-items-center justify-content-center">
                <div style="width: 160px; height: 160px; position: relative;">
                    <canvas id="riskChart"></canvas>
                </div>
                <div class="mt-4 w-100">
                    @foreach([['Rendah', 'success', $riskStats['hijau']], ['Sedang', 'warning', $riskStats['kuning']], ['Tinggi', 'danger', $riskStats['merah']]] as $item)
                    <div class="d-flex justify-content-between mb-2 x-small">
                        <span class="text-muted"><i class="fas fa-circle text-{{ $item[1] }} me-2"></i> {{ $item[0] }}</span>
                        <span class="fw-bold">{{ $item[2] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions or Trends -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-card rounded-xl h-100">
            <div class="card-header bg-white border-0 pt-4 px-3 px-md-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0 small fw-bold">Rujukan Terbaru</h5>
                <a href="{{ route('rujukan.index') }}" class="btn btn-sm btn-peka-outline py-1 px-3 x-small fw-bold">SEMUA</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light x-small uppercase-font">
                            <tr>
                                <th class="ps-3 ps-md-4 py-3">PASIEN</th>
                                <th class="d-none d-md-table-cell">TUJUAN</th>
                                <th>STATUS</th>
                                <th class="pe-3 pe-md-4 text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rujukans as $rujukan)
                            <tr>
                                <td class="ps-3 ps-md-4 py-3">
                                    <div class="fw-bold text-dark small">{{ $rujukan->kehamilan->pasien->nama }}</div>
                                    <div class="text-hint x-small">{{ $rujukan->created_at->format('d M y') }}</div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <div class="fw-medium text-dark x-small">{{ $rujukan->fasilitasTujuan->nama }}</div>
                                    <div class="text-hint x-small text-truncate" style="max-width: 150px;">{{ $rujukan->diagnosa_sementara }}</div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($rujukan->status) {
                                            'baru', 'dibuat' => 'bg-info-subtle text-info border-info-subtle',
                                            'proses', 'diterima' => 'bg-warning-subtle text-warning border-warning-subtle',
                                            'selesai' => 'bg-success-subtle text-success border-success-subtle',
                                            default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} border px-2 py-1 x-small fw-bold">{{ strtoupper($rujukan->status) }}</span>
                                </td>
                                <td class="pe-3 pe-md-4 text-end">
                                    <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-light border p-1 px-2">
                                        <i class="fas fa-eye x-small"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-5 text-center">
                                    <div class="text-muted x-small">
                                        <i class="fas fa-inbox fa-2x mb-2 opacity-25"></i>
                                        <p class="mb-0">Belum ada rujukan.</p>
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
</div>

<!-- Monthly Chart or Detailed Table could go here -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('riskChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi'],
                datasets: [{
                    data: [{{ $riskStats['hijau'] }}, {{ $riskStats['kuning'] }}, {{ $riskStats['merah'] }}],
                    backgroundColor: ['#1DB954', '#F59E0B', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        padding: 12,
                        cornerRadius: 10,
                        backgroundColor: '#1E293B',
                        titleFont: { family: 'Plus Jakarta Sans', size: 13, weight: 'bold' },
                        bodyFont: { family: 'DM Sans', size: 12 }
                    }
                },
                cutout: '75%'
            }
        });
    });
</script>
@endpush
