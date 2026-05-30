@extends('layouts.app')

@section('title', 'Laporan Darurat')
@section('page_title', 'Laporan Darurat')

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.5rem;">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <h5 class="section-title mb-1 text-danger fw-bold">Pusat Kendali Darurat</h5>
            <p class="text-muted small mb-0">Pantau dan tindak lanjuti laporan kondisi darurat dari ibu hamil secara real-time.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h6 class="fw-bold mb-0">Daftar Laporan Terkini</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Waktu & Pasien</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Keluhan / Gejala</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Status Respons</th>
                        <th class="pe-4 py-3 border-0 text-muted small fw-bold text-uppercase text-end">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr class="{{ $laporan->status === 'Dikirim' ? 'bg-danger-subtle bg-opacity-10' : '' }}">
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; position: relative;">
                                    <i class="fas fa-person-pregnant"></i>
                                    @if($laporan->status === 'Dikirim')
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle animate-pulse"></span>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $laporan->pasien->nama }}</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-clock me-1 opacity-50"></i> {{ $laporan->created_at->isoFormat('D MMM YYYY, HH:mm') }}
                                    </div>
                                    <div class="mt-1">
                                        <a href="tel:{{ $laporan->pasien->no_hp }}" class="btn btn-sm btn-outline-danger p-0 px-2 rounded-pill" style="font-size: 0.75rem;">
                                            <i class="fas fa-phone me-1"></i> {{ $laporan->pasien->no_hp }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                @foreach($laporan->gejala ?? [] as $gejala)
                                    <span class="badge bg-white text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                        {{ $gejala }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="text-dark small" style="max-width: 300px; line-height: 1.4;">
                                {{ $laporan->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                            </div>
                        </td>
                        <td class="py-4">
                            @php
                                $statusClass = match($laporan->status) {
                                    'Dikirim' => 'bg-danger text-white',
                                    'Diproses' => 'bg-warning text-dark',
                                    'Ditangani' => 'bg-success text-white',
                                    default => 'bg-light text-dark'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-2" style="font-weight: 700; font-size: 0.75rem;">
                                <i class="fas {{ $laporan->status === 'Dikirim' ? 'fa-satellite-dish animate-pulse' : ($laporan->status === 'Diproses' ? 'fa-spinner fa-spin' : 'fa-check-circle') }} me-1"></i>
                                {{ strtoupper($laporan->status) }}
                            </span>
                        </td>
                        <td class="pe-4 py-4 text-end">
                            <form method="POST" action="{{ route('darurat.update', $laporan) }}" class="d-inline-flex flex-column gap-2 align-items-end">
                                @csrf @method('PUT')
                                <div class="input-group input-group-sm" style="width: 140px;">
                                    <select name="status" class="form-select border-danger-subtle" style="font-size: 0.8rem; font-weight: 600;">
                                        @foreach(['Dikirim','Diproses','Ditangani'] as $status)
                                            <option value="{{ $status }}" @selected($laporan->status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-danger" title="Update Status">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('pasien.show', $laporan->pasien_id) }}" class="btn btn-sm btn-light border px-2" title="Lihat Rekam Medis">
                                        <i class="fas fa-file-medical me-1"></i> Riwayat
                                    </a>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-check-double d-block fs-1 mb-3 text-success opacity-50"></i>
                                <h6 class="text-dark fw-bold">Semua Aman!</h6>
                                <p class="text-muted">Tidak ada laporan darurat yang memerlukan tindakan saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
</style>
@endsection
