@extends('layouts.app')

@section('title', 'Daftar Kunjungan ANC')
@section('page_title', 'Daftar Kunjungan ANC')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-card__icon bg-primary-subtle text-primary">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div>
                    <div class="stat-card__number">{{ $stats['total'] }}</div>
                    <div class="stat-card__label small">Total Kunjungan</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-card__icon bg-success-subtle text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="stat-card__number">{{ $stats['rendah'] }}</div>
                    <div class="stat-card__label small">Risiko Rendah</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-card__icon bg-warning-subtle text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="stat-card__number">{{ $stats['sedang'] }}</div>
                    <div class="stat-card__label small">Risiko Sedang</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-card__icon bg-danger-subtle text-danger">
                    <i class="fas fa-radiation"></i>
                </div>
                <div>
                    <div class="stat-card__number">{{ $stats['tinggi'] }}</div>
                    <div class="stat-card__label small">Risiko Tinggi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-card rounded-xl">
        <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-bottom-0">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="section-title mb-0">Riwayat Pemeriksaan</h5>
                <div class="input-group-peka w-100" style="max-width: 350px;">
                    <i class="fas fa-search input-icon"></i>
                    <input type="text" class="form-control-peka" placeholder="Cari nama pasien atau NIK...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted uppercase-font" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-3 ps-md-4">TANGGAL</th>
                            <th>PASIEN</th>
                            <th class="d-none d-lg-table-cell">VITAL & UK</th>
                            <th class="d-none d-md-table-cell">LAB & PROTEIN</th>
                            <th>RISIKO</th>
                            <th class="pe-3 pe-md-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungans as $kunjungan)
                            @php
                                $level = $kunjungan->skriningRisiko?->level_risiko ?? 'HIJAU';
                                $badgeClass = match($level) {
                                    'MERAH_KRITIS' => 'critical',
                                    'MERAH' => 'red',
                                    'KUNING' => 'yellow',
                                    default => 'green'
                                };
                            @endphp
                            <tr>
                                <td class="ps-3 ps-md-4 py-3">
                                    <div class="fw-bold text-dark small">{{ $kunjungan->tanggal->format('d/m/y') }}</div>
                                    <div class="text-hint x-small">{{ $kunjungan->tanggal->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 gap-md-3">
                                        <div class="avatar-sm bg-peka-primary-pale text-peka-primary rounded-circle d-none d-sm-flex align-items-center justify-content-center fw-bold"
                                            style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ substr($kunjungan->kehamilan->pasien->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $kunjungan->kehamilan->pasien->nama }}</div>
                                            <div class="text-hint x-small">NIK: {{ $kunjungan->kehamilan->pasien->nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <div><span class="badge bg-light text-dark fw-medium border x-small">{{ $kunjungan->usia_kehamilan_minggu }} Mg</span></div>
                                    <div class="mt-1">
                                        <span class="vital-chip vital-chip--td x-small px-2">
                                            {{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }}
                                        </span>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <div class="fw-medium text-dark x-small">Prot: {{ $kunjungan->protein_urine }}</div>
                                    <div class="text-hint x-small">MAP: {{ $kunjungan->map }} mmHg</div>
                                </td>
                                <td>
                                    <span class="badge-risk badge-risk--{{ $badgeClass }}" style="font-size: 0.6rem;">
                                        {{ str_replace('_', ' ', $kunjungan->skriningRisiko?->status ?? 'NORMAL') }}
                                    </span>
                                </td>
                                <td class="pe-3 pe-md-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item py-2 small" href="{{ route('pasien.show', $kunjungan->kehamilan->pasien) }}"><i class="fas fa-user-circle me-2 text-primary"></i> Profil Pasien</a></li>
                                            <li><a class="dropdown-item py-2 small" href="{{ route('kunjungan.show', $kunjungan) }}"><i class="fas fa-file-medical me-2 text-info"></i> Detail Periksa</a></li>
                                            @if (in_array($level, ['MERAH', 'MERAH_KRITIS']))
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item py-2 text-danger fw-bold small" href="{{ route('rujukan.create', ['kunjungan_id' => $kunjungan->id]) }}"><i class="fas fa-ambulance me-2"></i> Rujuk</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open fa-3x text-light mb-3 opacity-50"></i>
                                        <h6 class="text-muted small fw-bold">Belum Ada Riwayat Kunjungan</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 p-md-4 border-top">
                {{ $kunjungans->links('partials.pagination-numbers') }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .uppercase-font {
            font-family: var(--font-heading);
            font-weight: 700;
            color: var(--gray-500);
        }

        .avatar-sm {
            flex-shrink: 0;
        }

        .dropdown-item {
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: var(--gray-50);
        }
    </style>
@endpush
