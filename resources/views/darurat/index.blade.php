@extends('layouts.app')

@section('title', 'Laporan Darurat')
@section('page_title', 'Pusat Kendali Darurat')

@section('content')
<!-- Emergency Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-danger border-2 h-100" style="background: #fff5f5;">
            <div class="stat-card__icon bg-danger text-white">
                <i class="fas fa-bullhorn animate-pulse"></i>
            </div>
            <div>
                <div class="stat-card__number text-danger">{{ $stats['baru'] }}</div>
                <div class="stat-card__label fw-bold small">Laporan Baru</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['proses'] }}</div>
                <div class="stat-card__label text-muted small">Sedang Diproses</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-success-subtle text-success">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['selesai'] }}</div>
                <div class="stat-card__label text-muted small">Sudah Ditangani</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label text-muted small">Total Riwayat</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl overflow-hidden">
    <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-bottom-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="section-title mb-1">Monitoring Gawat Darurat</h5>
            <p class="text-hint mb-0 small">Klik nomor HP untuk menghubungi pasien segera</p>
        </div>
        <button class="btn btn-light border btn-sm w-100 w-md-auto" onclick="window.location.reload()">
            <i class="fas fa-sync-alt me-1"></i> Refresh Data
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-3 ps-md-4">IDENTITAS</th>
                        <th class="d-none d-md-table-cell">GEJALA</th>
                        <th>RESPONS</th>
                        <th class="pe-3 pe-md-4 text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    @php
                        $isUrgent = $laporan->status === 'Dikirim';
                    @endphp
                    <tr class="{{ $isUrgent ? 'bg-danger-subtle bg-opacity-10' : '' }}">
                        <td class="ps-3 ps-md-4 py-3 py-md-4">
                            <div class="d-flex align-items-center gap-2 gap-md-3">
                                <div class="avatar-sm bg-danger text-white rounded-circle d-none d-sm-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 44px; height: 44px; position: relative;">
                                    <i class="fas fa-person-pregnant"></i>
                                    @if($isUrgent)
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle animate-pulse"></span>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small fs-md-6">{{ $laporan->pasien->nama }}</div>
                                    <div class="text-hint x-small mb-2">
                                        <i class="fas fa-clock me-1 opacity-50"></i> {{ $laporan->created_at->diffForHumans() }}
                                    </div>
                                    <a href="tel:{{ $laporan->pasien->no_hp }}" class="btn btn-sm btn-danger px-2 px-md-3 rounded-pill fw-bold" style="font-size: 0.65rem; font-weight: 800;">
                                        <i class="fas fa-phone-alt me-1"></i> {{ $laporan->pasien->no_hp }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 py-md-4 d-none d-md-table-cell">
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                @foreach($laporan->gejala ?? [] as $gejala)
                                    <span class="badge bg-danger text-white px-2 py-1" style="font-size: 0.6rem; border-radius: 4px;">
                                        {{ $gejala }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="p-2 bg-light rounded-3 border-start border-3 border-danger small text-muted" style="max-width: 250px;">
                                <div class="text-truncate-2 x-small">{{ $laporan->deskripsi ?? 'Tidak ada pesan tambahan.' }}</div>
                            </div>
                        </td>
                        <td class="py-3 py-md-4">
                            <form method="POST" action="{{ route('darurat.update', $laporan) }}">
                                @csrf @method('PUT')
                                <div class="status-selector p-1 bg-light rounded-pill d-inline-flex border">
                                    @foreach(['Dikirim' => 'danger', 'Diproses' => 'warning', 'Ditangani' => 'success'] as $status => $color)
                                        <button type="submit" name="status" value="{{ $status }}" 
                                            class="btn btn-sm rounded-pill px-1 px-md-3 py-1 fw-bold {{ $laporan->status === $status ? 'btn-'.$color.' shadow-sm' : 'text-muted' }}"
                                            style="font-size: 0.6rem; transition: all 0.2s;">
                                            {{ strtoupper(substr($status, 0, 1)) }}<span class="d-none d-md-inline">{{ substr($status, 1) }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </form>
                        </td>
                        <td class="pe-3 pe-md-4 py-3 py-md-4 text-end">
                            <div class="dropdown d-md-none">
                                <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item py-2 small" href="{{ route('pasien.show', $laporan->pasien_id) }}"><i class="fas fa-folder-open me-2 text-primary"></i> Rekam Medis</a></li>
                                    @if($isUrgent)
                                    <li><a class="dropdown-item py-2 small" href="{{ route('rujukan.create', ['kunjungan_id' => $laporan->pasien->kehamilanAktif?->kunjunganAncs?->first()?->id]) }}"><i class="fas fa-ambulance me-2 text-danger"></i> Buat Rujukan</a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="d-none d-md-flex flex-column gap-2 align-items-end">
                                <a href="{{ route('pasien.show', $laporan->pasien_id) }}" class="btn btn-sm btn-peka-outline w-100" style="font-size: 0.7rem; font-weight: 700;">
                                    REKAM MEDIS
                                </a>
                                @if($isUrgent)
                                    <a href="{{ route('rujukan.create', ['kunjungan_id' => $laporan->pasien->kehamilanAktif?->kunjunganAncs?->first()?->id]) }}" class="btn btn-sm btn-peka-primary w-100" style="font-size: 0.7rem; font-weight: 700;">
                                        RUJUKAN
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state py-4">
                                <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <i class="fas fa-shield-heart fa-2x"></i>
                                </div>
                                <h6 class="text-dark fw-bold">Situasi Kondusif</h6>
                                <p class="text-muted small">Tidak ada laporan darurat saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-top">
            {{ $laporans->links('partials.pagination-numbers') }}
        </div>
    </div>
</div>

<style>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
    }
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .x-small { font-size: 0.7rem; }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .status-selector button:not(.btn-danger):not(.btn-warning):not(.btn-success):hover { background: rgba(0,0,0,0.05); }
</style>
@endsection
