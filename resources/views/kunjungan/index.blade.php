@extends('layouts.app')

@section('title', 'Daftar Kunjungan ANC')
@section('page_title', 'Daftar Kunjungan ANC')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card__icon bg-primary-subtle text-primary">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div>
                    <div class="stat-card__number">{{ $stats['total'] }}</div>
                    <div class="stat-card__label">Total Kunjungan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card__icon bg-success-subtle text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="stat-card__number">
                        {{ $stats['rendah'] }}
                    </div>
                    <div class="stat-card__label">Risiko Rendah</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card__icon bg-warning-subtle text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="stat-card__number">
                        {{ $stats['sedang'] }}
                    </div>
                    <div class="stat-card__label">Risiko Sedang</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card__icon bg-danger-subtle text-danger">
                    <i class="fas fa-radiation"></i>
                </div>
                <div>
                    <div class="stat-card__number">
                        {{ $stats['tinggi'] }}
                    </div>
                    <div class="stat-card__label">Risiko Tinggi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-card rounded-xl">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
            <h5 class="section-title mb-0">Riwayat Pemeriksaan Terbaru</h5>
            <div class="d-flex gap-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" placeholder="Cari pasien...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-4">TANGGAL</th>
                            <th>PASIEN</th>
                            <th>UK & VITAL</th>
                            <th>LAB & PROTEIN</th>
                            <th>STATUS RISIKO</th>
                            <th class="pe-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungans as $kunjungan)
                            @php
                                $level = $kunjungan->skriningRisiko?->level_risiko ?? 'HIJAU';
                                $badgeClass =
                                    $level === 'MERAH_KRITIS'
                                        ? 'critical'
                                        : ($level === 'MERAH'
                                            ? 'red'
                                            : ($level === 'KUNING'
                                                ? 'yellow'
                                                : 'green'));
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $kunjungan->tanggal->format('d M Y') }}</div>
                                    <div class="text-hint">{{ $kunjungan->tanggal->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm bg-peka-primary-pale text-peka-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: 700;">
                                            {{ substr($kunjungan->kehamilan->pasien->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $kunjungan->kehamilan->pasien->nama }}</div>
                                            <div class="text-hint">NIK: {{ $kunjungan->kehamilan->pasien->nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><span
                                            class="badge bg-light text-dark fw-medium border">{{ $kunjungan->usia_kehamilan_minggu }}
                                            Minggu</span></div>
                                    <div class="mt-1">
                                        <span class="vital-chip vital-chip--td" title="Tekanan Darah">
                                            <i class="fas fa-heart-pulse me-1"></i>
                                            {{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">Protein: {{ $kunjungan->protein_urine }}</div>
                                    <div class="text-hint">MAP: {{ $kunjungan->map }} mmHg</div>
                                </td>
                                <td>
                                    <span class="badge-risk badge-risk--{{ $badgeClass }}">
                                        {{ str_replace('_', ' ', $kunjungan->skriningRisiko?->status ?? 'NORMAL') }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item py-2"
                                                    href="{{ route('pasien.show', $kunjungan->kehamilan->pasien) }}"><i
                                                        class="fas fa-user-circle me-2 text-primary"></i> Profil Pasien</a>
                                            </li>
                                            <li><a class="dropdown-item py-2"
                                                    href="{{ route('kunjungan.show', $kunjungan) }}"><i
                                                        class="fas fa-file-medical me-2 text-info"></i> Detail Kunjungan</a>
                                            </li>
                                            @if (in_array($level, ['MERAH', 'MERAH_KRITIS']))
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item py-2 text-danger"
                                                        href="{{ route('rujukan.create', ['kunjungan_id' => $kunjungan->id]) }}"><i
                                                            class="fas fa-paper-plane me-2"></i> Buat Rujukan</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state__icon mb-3">
                                            <i class="fas fa-folder-open fa-3x text-light"></i>
                                        </div>
                                        <h5>Belum Ada Data</h5>
                                        <p class="text-muted">Data kunjungan akan muncul di sini setelah bidan melakukan
                                            input pemeriksaan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-top">
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
