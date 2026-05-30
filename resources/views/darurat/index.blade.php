@extends('layouts.app')

@section('title', 'Laporan Darurat')
@section('page_title', 'Pusat Kendali Darurat')

@section('content')
<!-- Emergency Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card border-danger border-2" style="background: #fff5f5;">
            <div class="stat-card__icon bg-danger text-white">
                <i class="fas fa-bullhorn animate-pulse"></i>
            </div>
            <div>
                <div class="stat-card__number text-danger">{{ $stats['baru'] }}</div>
                <div class="stat-card__label fw-bold">Laporan Baru</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['proses'] }}</div>
                <div class="stat-card__label text-muted">Sedang Diproses</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-success-subtle text-success">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['selesai'] }}</div>
                <div class="stat-card__label text-muted">Sudah Ditangani</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label text-muted">Total Riwayat</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl overflow-hidden">
    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="section-title mb-1">Monitoring Gawat Darurat</h5>
            <p class="text-hint mb-0">Klik pada nomor HP untuk menghubungi pasien segera</p>
        </div>
        <button class="btn btn-light border btn-sm" onclick="window.location.reload()">
            <i class="fas fa-sync-alt me-1"></i> Refresh Data
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-4">WAKTU & IDENTITAS</th>
                        <th>GEJALA YANG DILAPORKAN</th>
                        <th>STATUS RESPONS</th>
                        <th class="pe-4 text-end">AKSI CEPAT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    @php
                        $isUrgent = $laporan->status === 'Dikirim';
                    @endphp
                    <tr class="{{ $isUrgent ? 'bg-danger-subtle bg-opacity-10' : '' }}">
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 44px; height: 44px; position: relative;">
                                    <i class="fas fa-person-pregnant"></i>
                                    @if($isUrgent)
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle animate-pulse"></span>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $laporan->pasien->nama }}</div>
                                    <div class="text-hint x-small mb-2">
                                        <i class="fas fa-clock me-1 opacity-50"></i> {{ $laporan->created_at->diffForHumans() }}
                                    </div>
                                    <a href="tel:{{ $laporan->pasien->no_hp }}" class="btn btn-sm btn-danger px-3 rounded-pill fw-bold" style="font-size: 0.7rem;">
                                        <i class="fas fa-phone-alt me-1"></i> HUBUNGI: {{ $laporan->pasien->no_hp }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                @foreach($laporan->gejala ?? [] as $gejala)
                                    <span class="badge bg-danger text-white px-2 py-1" style="font-size: 0.65rem; border-radius: 4px;">
                                        {{ $gejala }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="p-3 bg-light rounded-3 border-start border-3 border-danger small text-muted" style="max-width: 350px;">
                                <i class="fas fa-quote-left me-1 opacity-25"></i> {{ $laporan->deskripsi ?? 'Pasien tidak menyertakan pesan suara/teks tambahan.' }}
                            </div>
                        </td>
                        <td class="py-4">
                            <form method="POST" action="{{ route('darurat.update', $laporan) }}">
                                @csrf @method('PUT')
                                <div class="status-selector p-1 bg-light rounded-pill d-inline-flex border">
                                    @foreach(['Dikirim' => 'danger', 'Diproses' => 'warning', 'Ditangani' => 'success'] as $status => $color)
                                        <button type="submit" name="status" value="{{ $status }}" 
                                            class="btn btn-sm rounded-pill px-3 py-1 fw-bold {{ $laporan->status === $status ? 'btn-'.$color.' shadow-sm' : 'text-muted' }}"
                                            style="font-size: 0.65rem; transition: all 0.2s;">
                                            {{ strtoupper($status) }}
                                        </button>
                                    @endforeach
                                </div>
                            </form>
                        </td>
                        <td class="pe-4 py-4 text-end">
                            <div class="d-flex flex-column gap-2 align-items-end">
                                <a href="{{ route('pasien.show', $laporan->pasien_id) }}" class="btn btn-sm btn-peka-outline w-100" style="font-size: 0.75rem;">
                                    <i class="fas fa-folder-open me-1"></i> REKAM MEDIS
                                </a>
                                @if($isUrgent)
                                    <a href="{{ route('rujukan.create', ['kunjungan_id' => $laporan->pasien->kehamilanAktif?->kunjunganAncs?->first()?->id]) }}" class="btn btn-sm btn-peka-primary w-100" style="font-size: 0.75rem;">
                                        <i class="fas fa-ambulance me-1"></i> BUAT RUJUKAN
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state">
                                <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-shield-heart fa-3x"></i>
                                </div>
                                <h5 class="text-dark fw-bold">Situasi Kondusif</h5>
                                <p class="text-muted">Tidak ada laporan darurat yang perlu ditangani saat ini.</p>
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
    .status-selector button:not(.btn-danger):not(.btn-warning):not(.btn-success):hover { background: rgba(0,0,0,0.05); }
</style>
@endsection
