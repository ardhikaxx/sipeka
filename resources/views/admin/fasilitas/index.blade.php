@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')
@section('page_title', 'Fasilitas Kesehatan')

@section('content')
<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-hospital"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label small">Total Fasilitas</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-success-subtle text-success">
                <i class="fas fa-house-medical"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['puskesmas'] }}</div>
                <div class="stat-card__label small">Puskesmas</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-danger-subtle text-danger">
                <i class="fas fa-hospital-user"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['rs'] }}</div>
                <div class="stat-card__label small">RSUD / RSIA</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-peka-primary w-100 py-3 shadow-sm rounded-xl">
            <i class="fas fa-plus me-1"></i> Fasilitas Baru
        </a>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-bottom-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="section-title mb-1">Jaringan Fasilitas Kesehatan</h5>
                <p class="text-hint mb-0">Manajemen titik layanan dan rujukan</p>
            </div>
            <div class="input-group-peka w-100" style="max-width: 350px;">
                <i class="fas fa-search input-icon"></i>
                <input type="text" class="form-control-peka" placeholder="Cari fasilitas...">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-3 ps-md-4">NAMA FASILITAS</th>
                        <th>TIPE</th>
                        <th>WILAYAH</th>
                        <th class="d-none d-lg-table-cell">PROVINSI</th>
                        <th class="pe-3 pe-md-4 text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fasilitas as $item)
                    <tr>
                        <td class="ps-3 ps-md-4 py-3">
                            <div class="d-flex align-items-center gap-2 gap-md-3">
                                <div class="bg-peka-secondary-light text-peka-secondary rounded-3 d-none d-sm-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fas fa-clinic-medical"></i>
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $item->nama }}</div>
                            </div>
                        </td>
                        <td>
                            @php
                                $tipeBadge = match($item->tipe) {
                                    'RSUD', 'RSIA' => 'bg-danger-subtle text-danger border-danger-subtle',
                                    'Puskesmas' => 'bg-success-subtle text-success border-success-subtle',
                                    default => 'bg-warning-subtle text-warning border-warning-subtle'
                                };
                            @endphp
                            <span class="badge {{ $tipeBadge }} border px-2 py-1" style="font-size: 0.65rem; font-weight: 800;">
                                {{ strtoupper($item->tipe) }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-medium text-dark small">{{ $item->kecamatan ?? '-' }}</div>
                            <div class="text-hint x-small">{{ $item->kabupaten ?? '-' }}</div>
                        </td>
                        <td class="text-muted small d-none d-lg-table-cell">
                            {{ $item->provinsi ?? '-' }}
                        </td>
                        <td class="pe-3 pe-md-4 text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-edit me-2 text-primary"></i> Edit Data</a></li>
                                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-users-rectangle me-2 text-info"></i> Lihat Petugas</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Hapus</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data fasilitas kesehatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-top">
            {{ $fasilitas->links('partials.pagination-numbers') }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .x-small { font-size: 0.7rem; }
    .dropdown-item { font-size: 0.8125rem; font-weight: 500; }
</style>
@endpush
