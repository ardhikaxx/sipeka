@extends('layouts.app')

@section('title', 'Detail Pemeriksaan ANC')
@section('page_title', 'Detail Kunjungan')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('pasien.show', $kunjungan->kehamilan->pasien_id) }}" class="text-decoration-none text-muted">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Profil Pasien
            </a>
            <div class="d-flex gap-2">
                <button class="btn btn-light border btn-sm" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Cetak Hasil
                </button>
                @if(in_array($kunjungan->skriningRisiko?->level_risiko, ['KUNING', 'MERAH', 'MERAH_KRITIS']))
                    <a href="{{ route('rujukan.create', ['kunjungan_id' => $kunjungan->id]) }}" class="btn btn-peka-primary btn-sm">
                        <i class="fas fa-ambulance me-1"></i> Buat Rujukan
                    </a>
                @endif
            </div>
        </div>

        <!-- Header Status Risiko -->
        @php
            $level = $kunjungan->skriningRisiko?->level_risiko ?? 'HIJAU';
            $alertClass = $level === 'HIJAU' ? 'alert-peka--success' : ($level === 'KUNING' ? 'alert-peka--warning' : 'alert-peka--danger');
            $icon = $level === 'HIJAU' ? 'check-circle' : ($level === 'KUNING' ? 'exclamation-triangle' : 'radiation');
        @endphp
        <div class="alert-peka {{ $alertClass }} mb-4 shadow-sm border-0">
            <div class="alert-peka__icon"><i class="fas fa-{{ $icon }}"></i></div>
            <div class="alert-peka__body">
                <div class="alert-peka__title">Status Hasil Pemeriksaan: {{ str_replace('_', ' ', $kunjungan->skriningRisiko?->status ?? 'NORMAL') }}</div>
                <div class="alert-peka__text">
                    @if($level === 'HIJAU')
                        Kondisi kehamilan terpantau normal. Tetap jaga pola makan dan istirahat yang cukup.
                    @else
                        Ditemukan faktor risiko preeklampsia. Harap perhatikan instruksi bidan dan lakukan pemantauan mandiri di rumah.
                        @if($kunjungan->skriningRisiko?->detail_faktor)
                            <ul class="mt-2 mb-0">
                                @foreach($kunjungan->skriningRisiko->detail_faktor as $faktor)
                                    <li>{{ $faktor }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            <div class="col-12 col-lg-4">
                <!-- Data Pasien Card -->
                <div class="card border-0 shadow-card rounded-xl mb-3 mb-lg-4 overflow-hidden">
                    <div class="card-header bg-peka-primary text-dark py-3 px-3 px-md-4 border-0">
                        <h6 class="mb-0 fw-bold small">Informasi Pasien</h6>
                    </div>
                    <div class="card-body p-3 p-md-4 text-center text-md-start">
                        <div class="d-flex flex-column align-items-center mb-3">
                            <div class="bg-peka-primary-pale text-peka-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 60px; height: 60px; font-size: 1.8rem;">
                                <i class="fas fa-person-pregnant"></i>
                            </div>
                            <h5 class="fw-bold mb-0 small fs-6">{{ $kunjungan->kehamilan->pasien->nama }}</h5>
                            <div class="text-hint x-small">NIK: {{ $kunjungan->kehamilan->pasien->nik }}</div>
                        </div>
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-hint x-small">Usia Kehamilan</span>
                                <span class="fw-bold text-primary x-small">{{ $kunjungan->usia_kehamilan_minggu }} Mg</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-hint x-small">GPA</span>
                                <span class="fw-bold x-small">G{{ $kunjungan->kehamilan->gravida }} P{{ $kunjungan->kehamilan->para }} A{{ $kunjungan->kehamilan->abortus }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="text-hint x-small">Tanggal Periksa</span>
                                <span class="fw-bold x-small">{{ $kunjungan->tanggal->format('d/m/y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bidan/Pemeriksa Card -->
                <div class="card border-0 shadow-card rounded-xl overflow-hidden">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 40px; height: 40px;">
                                <i class="fas fa-user-md small"></i>
                            </div>
                            <div class="grow overflow-hidden">
                                <div class="text-hint x-small uppercase-font">PEMERIKSA</div>
                                <div class="fw-bold text-dark text-truncate small">{{ $kunjungan->bidan->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <!-- Temuan Klinis Card -->
                <div class="card border-0 shadow-card rounded-xl mb-3 mb-lg-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex align-items-center">
                        <i class="fas fa-file-waveform text-danger me-2"></i>
                        <h6 class="mb-0 fw-bold small">Fisik & Vital</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-danger h-100">
                                    <div class="text-hint x-small uppercase-font mb-1">Tekanan Darah</div>
                                    <div class="h5 fw-extrabold text-dark mb-0">{{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }} <small class="fw-normal text-muted">mmHg</small></div>
                                    <div class="text-hint x-small mt-1">MAP: {{ $kunjungan->map }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-primary h-100">
                                    <div class="text-hint x-small uppercase-font mb-1">Berat & IMT</div>
                                    <div class="h5 fw-extrabold text-dark mb-0">{{ $kunjungan->berat_badan }} <small class="fw-normal text-muted">kg</small></div>
                                    <div class="text-hint x-small mt-1">IMT: {{ $kunjungan->imt ?? '-' }} | Naik: {{ $kunjungan->penambahan_bb ?? 0 }} kg</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="text-hint x-small mb-1">DJJ Janin</div>
                                <div class="fw-bold text-dark small">{{ $kunjungan->djj }} <small class="text-muted">x/m</small></div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="text-hint x-small mb-1">TFU</div>
                                <div class="fw-bold text-dark small">{{ $kunjungan->tinggi_fundus_uteri }} <small class="text-muted">cm</small></div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="text-hint x-small mb-1">Edema</div>
                                <div class="fw-bold small text-{{ $kunjungan->edema === 'Tidak' ? 'dark' : 'danger' }}">{{ $kunjungan->edema }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laboratorium & Gejala -->
                <div class="row g-3 mb-3 mb-lg-4">
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-card rounded-xl h-100 overflow-hidden">
                            <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex align-items-center">
                                <i class="fas fa-microscope text-warning me-2"></i>
                                <h6 class="mb-0 fw-bold small">Lab</h6>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <div class="mb-3 text-center">
                                    <div class="text-hint x-small mb-1">Protein Urine</div>
                                    <div class="badge-risk {{ $kunjungan->protein_urine === 'Negatif' ? 'badge-risk--green' : 'badge-risk--red' }} py-2 x-small w-100">
                                        {{ $kunjungan->protein_urine }}
                                    </div>
                                </div>
                                <div class="row g-2 text-center">
                                    <div class="col-4">
                                        <div class="text-hint x-small">Hb</div>
                                        <div class="fw-bold x-small">{{ $kunjungan->hb ?? '-' }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-hint x-small">Tromb.</div>
                                        <div class="fw-bold x-small">{{ $kunjungan->trombosit ?? '-' }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-hint x-small">Kreat.</div>
                                        <div class="fw-bold x-small">{{ $kunjungan->kreatinin ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-card rounded-xl h-100 overflow-hidden">
                            <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex align-items-center">
                                <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                                <h6 class="mb-0 fw-bold small">Gejala</h6>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @foreach(['nyeri_kepala_hebat' => 'Pusing', 'gangguan_penglihatan' => 'Kabur', 'nyeri_ulu_hati' => 'Ulu Hati', 'ada_riwayat_kejang' => 'Kejang'] as $field => $label)
                                        <span class="badge {{ $kunjungan->$field ? 'bg-danger' : 'bg-light text-muted border' }} x-small px-2 py-1 rounded-pill">
                                            {{ $label }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="p-2 bg-light rounded-3 x-small text-muted border-start border-3">
                                    {{ \Illuminate\Support\Str::limit($kunjungan->keluhan_subjektif ?: 'Tidak ada keluhan.', 60) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Bidan Card -->
                <div class="card border-0 shadow-card rounded-xl overflow-hidden">
                    <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex align-items-center">
                        <i class="fas fa-comment-medical text-primary me-2"></i>
                        <h6 class="mb-0 fw-bold small">Instruksi Bidan</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="p-3 bg-primary-subtle bg-opacity-10 rounded-3 border border-primary border-opacity-25 shadow-sm">
                            <p class="mb-0 text-dark x-small" style="line-height: 1.5;">{{ $kunjungan->catatan_bidan ?: 'Tidak ada catatan.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .x-small { font-size: 0.65rem; }
    .fw-extrabold { font-weight: 800; }
    @media print {
        .sipeka-sidebar, .sipeka-topbar, .btn, .nav-wrapper, .col-xl-10 > .mb-4 { display: none !important; }
        .sipeka-main { margin-left: 0 !important; padding: 0 !important; }
        .sipeka-content { padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .col-lg-4, .col-lg-8 { width: 100% !important; }
        .alert-peka { border: 1px solid #ddd !important; }
    }
</style>
@endpush
