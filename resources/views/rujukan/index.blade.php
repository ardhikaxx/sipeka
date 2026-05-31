@extends('layouts.app')

@section('title', 'Daftar Rujukan')
@section('page_title', 'Rujukan Keluar')

@section('content')
<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-file-medical"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $stats['total'] }}</div>
                <div class="stat-card__label x-small">Total Rujukan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $stats['menunggu'] }}</div>
                <div class="stat-card__label x-small">Menunggu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-info-subtle text-info">
                <i class="fas fa-hand-holding-medical"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $stats['diproses'] }}</div>
                <div class="stat-card__label x-small">Diterima</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-success-subtle text-success">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="stat-card__number fs-4 fs-md-3">{{ $stats['selesai'] }}</div>
                <div class="stat-card__label x-small">Selesai</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-bottom-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="section-title mb-1">Rujukan Pasien</h5>
                <p class="text-hint mb-0 x-small">Pantau status rujukan dan catatan balik</p>
            </div>
            <div class="input-group-peka w-100" style="max-width: 300px;">
                <i class="fas fa-search input-icon"></i>
                <input type="text" class="form-control-peka" placeholder="Cari nama atau NIK...">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($rujukans->isEmpty())
            <div class="empty-state py-5">
                <i class="fas fa-ambulance fa-3x text-light mb-3 opacity-50"></i>
                <h6 class="text-muted small">Belum ada rujukan tercatat.</h6>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted uppercase-font" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-3 ps-md-4">PASIEN</th>
                            <th class="d-none d-lg-table-cell">TUJUAN</th>
                            <th class="d-none d-md-table-cell">DIAGNOSA</th>
                            <th>STATUS</th>
                            <th class="pe-3 pe-md-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rujukans as $rujukan)
                        <tr>
                            <td class="ps-3 ps-md-4 py-3">
                                <div class="d-flex align-items-center gap-2 gap-md-3">
                                    <div class="fw-bold text-peka-primary text-center d-none d-sm-block" style="font-size: 0.75rem; width: 40px; line-height: 1.1;">
                                        {{ $rujukan->created_at->format('d M') }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">{{ $rujukan->kehamilan->pasien->nama }}</div>
                                        <div class="text-hint x-small">{{ $rujukan->kehamilan->pasien->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <div class="fw-medium text-dark small">{{ $rujukan->fasilitasTujuan->nama }}</div>
                                <div class="text-hint x-small">{{ $rujukan->fasilitasTujuan->tipe }}</div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="fw-medium text-dark small">{{ $rujukan->diagnosa_sementara }}</div>
                                <div class="text-hint x-small text-truncate" style="max-width: 150px;">{{ $rujukan->alasan_rujukan }}</div>
                            </td>
                            <td>
                                @php
                                    $statusConfig = match($rujukan->status) {
                                        'dibuat', 'dikirim' => ['bg-warning-subtle', 'text-warning', 'Menunggu'],
                                        'diterima' => ['bg-info-subtle', 'text-info', 'Proses'],
                                        'selesai' => ['bg-success-subtle', 'text-success', 'Selesai'],
                                        default => ['bg-secondary-subtle', 'text-secondary', 'Unknown']
                                    };
                                @endphp
                                <span class="badge {{ $statusConfig[0] }} {{ $statusConfig[1] }} px-2 py-1 rounded-pill fw-bold border" style="font-size: 0.6rem;">
                                    {{ $statusConfig[2] }}
                                </span>
                            </td>
                            <td class="pe-3 pe-md-4 text-end">
                                <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-light border-0" title="Detail">
                                    <i class="fas fa-file-invoice text-danger fs-6"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 p-md-4 border-top">
                {{ $rujukans->links('partials.pagination-numbers') }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
</style>
@endpush
