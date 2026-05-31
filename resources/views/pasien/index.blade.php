@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page_title', 'Data Ibu Hamil')

@section('content')
<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="stat-card h-100">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label small">Total Pasien Binaan</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="stat-card border-danger-subtle h-100">
            <div class="stat-card__icon bg-danger-subtle text-danger">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="stat-card__number text-danger">{{ $stats['risiko_tinggi'] }}</div>
                <div class="stat-card__label small">Pasien Risiko Tinggi</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="stat-card border-warning-subtle h-100">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['perlu_kunjungan'] }}</div>
                <div class="stat-card__label small">Jadwal Perlu Kunjungan</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-bottom-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="section-title mb-1">Daftar Pasien</h5>
                <p class="text-hint mb-0 small">Kelola rekam medis ibu hamil</p>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                <div class="input-group-peka w-100" style="max-width: 300px;">
                    <i class="fas fa-search input-icon"></i>
                    <input type="text" class="form-control-peka" placeholder="Cari NIK atau Nama...">
                </div>
                <a href="{{ route('pasien.create') }}" class="btn btn-peka-primary shadow-sm px-3">
                    <i class="fas fa-plus me-1"></i> <span class="small fw-bold">Registrasi</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($pasiens->isEmpty())
            <div class="empty-state py-5">
                <div class="mb-3">
                    <i class="fas fa-user-slash fa-3x text-light opacity-50"></i>
                </div>
                <h6 class="fw-bold">Belum Ada Data Pasien</h6>
                <p class="text-muted small">Daftarkan pasien baru untuk memulai pemantauan.</p>
                <a href="{{ route('pasien.create') }}" class="btn btn-peka-outline btn-sm mt-2">Daftarkan Sekarang</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted uppercase-font" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-3 ps-md-4">PASIEN</th>
                            <th class="d-none d-md-table-cell">USIA & KONTAK</th>
                            <th>KEHAMILAN</th>
                            <th class="d-none d-sm-table-cell">STATUS</th>
                            <th class="pe-3 pe-md-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pasiens as $pasien)
                        @php
                            $kehamilanAktif = $pasien->kehamilans->first();
                            $uk = $kehamilanAktif ? round(\Carbon\Carbon::parse($kehamilanAktif->hpht)->diffInWeeks(now())) : null;
                            $latestVisit = $kehamilanAktif ? $kehamilanAktif->kunjunganAncs->last() : null;
                            $level = $latestVisit?->skriningRisiko?->level_risiko ?? 'HIJAU';
                            $badgeClass = $level === 'MERAH_KRITIS' ? 'critical' : ($level === 'MERAH' ? 'red' : ($level === 'KUNING' ? 'yellow' : 'green'));
                        @endphp
                        <tr>
                            <td class="ps-3 ps-md-4 py-3">
                                <div class="d-flex align-items-center gap-2 gap-md-3">
                                    <div class="avatar-sm bg-peka-primary-pale text-peka-primary rounded-circle d-none d-sm-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                        {{ substr($pasien->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">{{ $pasien->nama }}</div>
                                        <div class="text-hint x-small" style="font-family: var(--font-mono)">{{ $pasien->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="fw-medium text-dark small">{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} Thn</div>
                                <div class="text-hint x-small"><i class="fas fa-phone-alt me-1 opacity-50"></i> {{ $pasien->no_hp ?? '-' }}</div>
                            </td>
                            <td>
                                @if($uk)
                                    <div class="fw-bold text-primary small">{{ $uk }} Minggu</div>
                                    <div class="text-hint x-small">TP: {{ \Carbon\Carbon::parse($kehamilanAktif->tp)->format('d/m/y') }}</div>
                                @else
                                    <span class="text-muted x-small">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @if($latestVisit)
                                    <span class="badge-risk badge-risk--{{ $badgeClass }}" style="font-size: 0.6rem;">
                                        {{ str_replace('_', ' ', $latestVisit->skriningRisiko?->status ?? 'NORMAL') }}
                                    </span>
                                @else
                                    <span class="text-muted x-small">Belum periksa</span>
                                @endif
                            </td>
                            <td class="pe-3 pe-md-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><a class="dropdown-item py-2 small" href="{{ route('pasien.show', $pasien->id) }}"><i class="fas fa-folder-open me-2 text-primary"></i> Rekam Medis</a></li>
                                        @if($kehamilanAktif)
                                        <li><a class="dropdown-item py-2 small" href="{{ route('kunjungan.create', ['kehamilan_id' => $kehamilanAktif->id]) }}"><i class="fas fa-stethoscope me-2 text-success"></i> Periksa ANC</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 p-md-4 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                <div class="text-hint x-small">Menampilkan {{ $pasiens->count() }} dari {{ $pasiens->total() }} pasien.</div>
                <div class="pagination-wrapper overflow-auto w-100 w-sm-auto d-flex justify-content-center">
                    {{ $pasiens->links('partials.pagination-numbers') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .avatar-sm { flex-shrink: 0; }
</style>
@endpush
