@extends('layouts.app')

@section('title', 'Daftar Rujukan')
@section('page_title', 'Rujukan Keluar')

@section('content')
<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-file-medical"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label">Total Rujukan</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['menunggu'] }}</div>
                <div class="stat-card__label">Menunggu</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card__icon bg-info-subtle text-info">
                <i class="fas fa-hand-holding-medical"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['diproses'] }}</div>
                <div class="stat-card__label">Diterima/Proses</div>
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
                <div class="stat-card__label">Selesai</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white py-4 px-4 border-bottom-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="section-title mb-1">Monitoring Rujukan Pasien</h5>
                <p class="text-hint mb-0">Pantau perkembangan status rujukan dan catatan balik dokter</p>
            </div>
            <div class="d-flex gap-2">
                <div class="input-group-peka" style="width: 250px;">
                    <i class="fas fa-search input-icon"></i>
                    <input type="text" class="form-control-peka" placeholder="Cari rujukan...">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($rujukans->isEmpty())
            <div class="empty-state py-5">
                <div class="mb-3">
                    <i class="fas fa-ambulance fa-3x text-light opacity-50"></i>
                </div>
                <h5>Belum Ada Data Rujukan</h5>
                <p class="text-muted px-4">Sistem belum mendeteksi adanya rujukan yang dibuat oleh Bidan atau diterima oleh Dokter.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-4">TANGGAL & PASIEN</th>
                            <th>FASILITAS TUJUAN</th>
                            <th>DIAGNOSA</th>
                            <th>STATUS</th>
                            <th class="pe-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rujukans as $rujukan)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="fw-bold text-peka-primary" style="font-size: 0.8rem; width: 45px; line-height: 1.2;">
                                        {{ $rujukan->created_at->format('d M') }}<br>
                                        <small class="text-muted fw-normal">{{ $rujukan->created_at->format('Y') }}</small>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $rujukan->kehamilan->pasien->nama }}</div>
                                        <div class="text-hint">{{ $rujukan->kehamilan->pasien->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $rujukan->fasilitasTujuan->nama }}</div>
                                <div class="text-hint">{{ $rujukan->fasilitasTujuan->tipe }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $rujukan->diagnosa_sementara }}</div>
                                <div class="text-hint text-truncate" style="max-width: 150px;">{{ $rujukan->alasan_rujukan }}</div>
                            </td>
                            <td>
                                @php
                                    $statusConfig = [
                                        'dibuat' => ['bg-warning-subtle', 'text-warning', 'clock', 'Menunggu'],
                                        'dikirim' => ['bg-warning-subtle', 'text-warning', 'clock', 'Menunggu'],
                                        'diterima' => ['bg-info-subtle', 'text-info', 'hand-holding-medical', 'Diterima/Proses'],
                                        'selesai' => ['bg-success-subtle', 'text-success', 'check-double', 'Selesai'],
                                    ][$rujukan->status] ?? ['bg-secondary-subtle', 'text-secondary', 'question', 'Unknown'];
                                @endphp
                                <span class="badge {{ $statusConfig[0] }} {{ $statusConfig[1] }} px-3 py-2 rounded-pill fw-bold border" style="font-size: 0.65rem;">
                                    <i class="fas fa-{{ $statusConfig[2] }} me-1"></i> {{ $statusConfig[3] }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('rujukan.show', $rujukan) }}" class="btn btn-sm btn-light border-0" title="Detail Rujukan">
                                    <i class="fas fa-file-pdf text-danger fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-top d-flex justify-content-between align-items-center">
                <div class="text-hint">Menampilkan {{ $rujukans->count() }} data rujukan.</div>
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
