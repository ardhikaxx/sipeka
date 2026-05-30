@extends('layouts.app')

@section('title', 'Audit Log')
@section('page_title', 'Audit Log Sistem')

@section('content')
<div class="mb-4">
    <h5 class="section-title mb-1">Log Aktivitas Sistem</h5>
    <p class="text-muted small mb-0">Rekaman jejak digital semua tindakan yang dilakukan pengguna dalam sistem SIPEKA.</p>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Waktu Kejadian</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Pengguna</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Tindakan</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Entitas</th>
                        <th class="pe-4 py-3 border-0 text-muted small fw-bold text-uppercase">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 py-3 text-dark fw-medium" style="font-size: 0.85rem;">
                            <div>{{ $log->created_at->isoFormat('D MMM YYYY') }}</div>
                            <div class="text-muted small">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="fw-bold">{{ $log->user?->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            @php
                                $aksiClass = match(strtolower($log->aksi)) {
                                    'create', 'tambah' => 'bg-success-subtle text-success border-success-subtle',
                                    'update', 'ubah' => 'bg-warning-subtle text-warning border-warning-subtle',
                                    'delete', 'hapus' => 'bg-danger-subtle text-danger border-danger-subtle',
                                    default => 'bg-light text-dark border-secondary-subtle'
                                };
                            @endphp
                            <span class="badge {{ $aksiClass }} border px-2 py-1 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td class="py-3 text-muted" style="font-size: 0.85rem;">
                            <i class="fas fa-cube me-1 opacity-50"></i> {{ $log->model ?? '-' }}
                        </td>
                        <td class="pe-4 py-3">
                            <div class="bg-light p-2 rounded-lg" style="max-width: 300px;">
                                <code class="small text-dark" style="word-break: break-all;">
                                    {{ json_encode($log->detail) }}
                                </code>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-list-check d-block fs-2 mb-3 opacity-25"></i>
                                <div class="text-muted">Belum ada aktivitas yang terekam.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
