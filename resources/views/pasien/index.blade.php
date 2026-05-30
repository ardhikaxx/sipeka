@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page_title', 'Data Ibu Hamil')

@section('content')
<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card__icon bg-primary-subtle text-primary">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['total'] }}</div>
                <div class="stat-card__label">Total Pasien Binaan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card border-danger-subtle">
            <div class="stat-card__icon bg-danger-subtle text-danger">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['risiko_tinggi'] }}</div>
                <div class="stat-card__label">Pasien Risiko Tinggi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card border-warning-subtle">
            <div class="stat-card__icon bg-warning-subtle text-warning">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <div class="stat-card__number">{{ $stats['perlu_kunjungan'] }}</div>
                <div class="stat-card__label">Jadwal Perlu Kunjungan</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white py-4 px-4 border-bottom-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="section-title mb-1">Daftar Pasien</h5>
                <p class="text-hint mb-0">Kelola dan pantau rekam medis ibu hamil</p>
            </div>
            <div class="d-flex gap-2">
                <div class="input-group-peka" style="width: 250px;">
                    <i class="fas fa-search input-icon"></i>
                    <input type="text" class="form-control-peka" placeholder="Cari NIK atau Nama...">
                </div>
                <a href="{{ route('pasien.create') }}" class="btn btn-peka-primary shadow-sm">
                    <i class="fas fa-plus"></i> Registrasi Pasien
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($pasiens->isEmpty())
            <div class="empty-state">
                <div class="mb-3">
                    <i class="fas fa-user-slash fa-3x text-light"></i>
                </div>
                <h5>Belum Ada Data Pasien</h5>
                <p class="text-muted">Silakan registrasi pasien baru untuk memulai pemantauan kesehatan.</p>
                <a href="{{ route('pasien.create') }}" class="btn btn-peka-outline mt-2">Daftarkan Sekarang</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-4">PASIEN</th>
                            <th>USIA & KONTAK</th>
                            <th>KEHAMILAN (UK)</th>
                            <th>STATUS TERAKHIR</th>
                            <th class="pe-4 text-end">AKSI</th>
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
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm bg-peka-primary-pale text-peka-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 700;">
                                        {{ substr($pasien->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $pasien->nama }}</div>
                                        <div class="text-hint" style="font-family: var(--font-mono)">{{ $pasien->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} Thn</div>
                                <div class="text-hint"><i class="fas fa-phone-alt me-1" style="font-size: 0.7rem;"></i> {{ $pasien->no_hp ?? '-' }}</div>
                            </td>
                            <td>
                                @if($uk)
                                    <div class="fw-bold text-primary">{{ $uk }} Minggu</div>
                                    <div class="text-hint">TP: {{ \Carbon\Carbon::parse($kehamilanAktif->tp)->format('d/m/Y') }}</div>
                                @else
                                    <span class="text-muted">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($latestVisit)
                                    <span class="badge-risk badge-risk--{{ $badgeClass }}">
                                        {{ str_replace('_', ' ', $latestVisit->skriningRisiko?->status ?? 'NORMAL') }}
                                    </span>
                                    <div class="text-hint mt-1 ms-2">Terakhir: {{ $latestVisit->tanggal->format('d/m/y') }}</div>
                                @else
                                    <span class="text-muted small">Belum ada periksa</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('pasien.show', $pasien->id) }}" class="btn btn-sm btn-light border-0" title="Rekam Medis">
                                        <i class="fas fa-folder-open text-primary"></i>
                                    </a>
                                    @if($kehamilanAktif)
                                    <a href="{{ route('kunjungan.create', ['kehamilan_id' => $kehamilanAktif->id]) }}" class="btn btn-sm btn-light border-0" title="Periksa ANC">
                                        <i class="fas fa-stethoscope text-success"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-top d-flex justify-content-between align-items-center">
                <div class="text-hint">Menampilkan {{ $pasiens->count() }} dari {{ $pasiens->total() }} pasien binaan.</div>
                {{ $pasiens->links('partials.pagination-numbers') }}
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
