@extends('layouts.app')

@section('title', 'Pusat Laporan & Statistik')
@section('page_title', 'Laporan & Statistik')

@section('content')
<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-users-line"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $totalPasien }}</div>
                <div class="stat-card__label">Total Pasien</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-info-subtle text-info">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $totalKunjungan }}</div>
                <div class="stat-card__label">Kunjungan ANC</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-ambulance"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $totalRujukan }}</div>
                <div class="stat-card__label">Rujukan</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-danger-subtle text-danger">
                <i class="fas fa-baby"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $totalPersalinan }}</div>
                <div class="stat-card__label">Persalinan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Risk Distribution Chart -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-card rounded-xl h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="section-title mb-0">Distribusi Risiko</h5>
            </div>
            <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                <div style="width: 200px; height: 200px; position: relative;">
                    <canvas id="riskChart"></canvas>
                </div>
                <div class="mt-4 w-100">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-circle text-success me-2"></i> Rendah</span>
                        <span class="fw-bold">{{ $riskStats['hijau'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-circle text-warning me-2"></i> Sedang</span>
                        <span class="fw-bold">{{ $riskStats['kuning'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-circle text-danger me-2"></i> Tinggi</span>
                        <span class="fw-bold">{{ $riskStats['merah'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions or Trends -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-card rounded-xl h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">Rujukan Terbaru</h5>
                <a href="{{ route('rujukan.index') }}" class="btn btn-sm btn-peka-outline">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">Tanggal</th>
                                <th>Pasien</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rujukans as $rujukan)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $rujukan->created_at->format('d M Y') }}</div>
                                    <div class="text-hint">{{ $rujukan->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $rujukan->kehamilan->pasien->nama }}</div>
                                    <div class="text-hint">NIK: {{ $rujukan->kehamilan->pasien->nik }}</div>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $rujukan->fasilitasTujuan->nama }}</div>
                                    <div class="text-hint text-truncate" style="max-width: 150px;">{{ $rujukan->diagnosa_sementara }}</div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'baru' => 'bg-info',
                                            'proses' => 'bg-warning',
                                            'selesai' => 'bg-success',
                                            'dibatalkan' => 'bg-danger'
                                        ][$rujukan->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3">{{ ucfirst($rujukan->status) }}</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-light border">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                        <p>Belum ada rujukan tercatat.</p>
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
