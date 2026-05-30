@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page_title', 'Audit Log Sistem')

@section('content')
<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-list-check"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label small">Total Aktivitas</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-info-subtle text-info">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['today'] }}</div>
                <div class="stat-card__label small">Aktivitas Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-success-subtle text-success">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['create'] }}</div>
                <div class="stat-card__label small">Data Baru</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="stat-card__icon bg-danger-subtle text-danger">
                <i class="fas fa-trash-can"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['delete'] }}</div>
                <div class="stat-card__label small">Penghapusan</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl overflow-hidden">
    <div class="card-header bg-white py-4 px-4 border-bottom-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="section-title mb-1">Jejak Digital Sistem</h5>
                <p class="text-hint mb-0">Pemantauan riwayat perubahan data oleh semua pengguna</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light border btn-sm"><i class="fas fa-filter me-1"></i> Filter</button>
                <button class="btn btn-light border btn-sm"><i class="fas fa-download me-1"></i> Export</button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-4">WAKTU</th>
                        <th>PENGGUNA</th>
                        <th>AKSI</th>
                        <th>ENTITAS / MODEL</th>
                        <th class="pe-4">DETAIL PERUBAHAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $log->created_at->isoFormat('D MMM YYYY') }}</div>
                            <div class="text-hint x-small">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-user-gear" style="font-size: 0.8rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">{{ $log->user?->name ?? 'SYSTEM' }}</div>
                                    <div class="text-hint x-small">{{ strtoupper($log->user?->role ?? 'CORE') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $aksiBadge = match(strtolower($log->aksi)) {
                                    'create', 'tambah' => 'bg-success-subtle text-success border-success-subtle',
                                    'update', 'ubah' => 'bg-warning-subtle text-warning border-warning-subtle',
                                    'delete', 'hapus' => 'bg-danger-subtle text-danger border-danger-subtle',
                                    default => 'bg-light text-dark border-secondary-subtle'
                                };
                            @endphp
                            <span class="badge {{ $aksiBadge }} border px-2 py-1 text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.05em; font-weight: 800;">
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td class="text-muted" style="font-size: 0.8rem;">
                            <span class="p-1 px-2 bg-light rounded border small">
                                <i class="fas fa-cube me-1 opacity-50"></i> {{ class_basename($log->model) ?: 'System' }}
                            </span>
                        </td>
                        <td class="pe-4 py-3">
                            <div class="json-detail-box bg-light p-2 rounded border border-white shadow-sm" style="max-width: 350px;">
                                <pre class="mb-0 x-small text-dark overflow-auto" style="max-height: 80px; font-family: var(--font-mono);">{{ json_encode($log->detail, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state py-4">
                                <i class="fas fa-shield-halved fa-3x text-light mb-3"></i>
                                <h6 class="text-muted">Belum ada log aktivitas terekam.</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-top">
            {{ $logs->links('partials.pagination-numbers') }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .x-small { font-size: 0.65rem; }
    .json-detail-box pre::-webkit-scrollbar { width: 4px; height: 4px; }
    .json-detail-box pre::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 10px; }
</style>
@endpush
