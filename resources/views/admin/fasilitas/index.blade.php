@extends('layouts.app')

@section('title', 'Fasilitas')
@section('page_title', 'Fasilitas Kesehatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="section-title mb-1">Daftar Fasilitas Kesehatan</h5>
        <p class="text-muted small mb-0">Manajemen jaringan Puskesmas, RSUD, dan RSIA dalam sistem rujukan SIPEKA.</p>
    </div>
    <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-peka-primary shadow-sm">
        <i class="fas fa-plus me-2"></i> Fasilitas Baru
    </a>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Nama Fasilitas</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Tipe</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Wilayah (Kecamatan)</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Kabupaten / Provinsi</th>
                        <th class="pe-4 py-3 border-0 text-muted small fw-bold text-uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fasilitas as $item)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-peka-secondary-light text-peka-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-hospital"></i>
                                </div>
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                            </div>
                        </td>
                        <td class="py-3">
                            @php
                                $tipeClass = match($item->tipe) {
                                    'RSUD', 'RSIA' => 'bg-danger-subtle text-danger border-danger-subtle',
                                    'Puskesmas' => 'bg-success-subtle text-success border-success-subtle',
                                    default => 'bg-light text-dark border-secondary-subtle'
                                };
                            @endphp
                            <span class="badge {{ $tipeClass }} border px-3 py-2" style="font-weight: 700;">
                                {{ strtoupper($item->tipe) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="text-dark fw-medium">{{ $item->kecamatan ?? '-' }}</span>
                        </td>
                        <td class="py-3">
                            <div class="text-dark" style="font-size: 0.9rem;">{{ $item->kabupaten ?? '-' }}</div>
                            <div class="text-muted small">{{ $item->provinsi ?? '-' }}</div>
                        </td>
                        <td class="pe-4 py-3 text-center">
                            <button class="btn btn-sm btn-light border p-1 px-2" title="Edit"><i class="fas fa-edit text-muted"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-hospital-user d-block fs-2 mb-3 opacity-25"></i>
                                <div class="text-muted">Belum ada fasilitas kesehatan yang terdaftar.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($fasilitas->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $fasilitas->links() }}
    </div>
    @endif
</div>
@endsection
