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

        <div class="row g-4">
            <div class="col-lg-4">
                <!-- Data Pasien Card -->
                <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
                    <div class="card-header bg-peka-primary text-white py-3 px-4 border-0">
                        <h6 class="mb-0 fw-bold">Informasi Pasien</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="bg-peka-primary-pale text-peka-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 70px; height: 70px; font-size: 2rem;">
                                <i class="fas fa-person-pregnant"></i>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $kunjungan->kehamilan->pasien->nama }}</h5>
                            <div class="text-hint small">NIK: {{ $kunjungan->kehamilan->pasien->nik }}</div>
                        </div>
                        <div class="border-top pt-3 mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-hint small">Usia / Tgl Lahir</span>
                                <span class="fw-bold small">{{ \Carbon\Carbon::parse($kunjungan->kehamilan->pasien->tgl_lahir)->age }} Thn / {{ \Carbon\Carbon::parse($kunjungan->kehamilan->pasien->tgl_lahir)->format('d-m-y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-hint small">Usia Kehamilan</span>
                                <span class="fw-bold text-primary small">{{ $kunjungan->usia_kehamilan_minggu }} Minggu</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-hint small">GPA</span>
                                <span class="fw-bold small text-dark">G{{ $kunjungan->kehamilan->gravida }} P{{ $kunjungan->kehamilan->para }} A{{ $kunjungan->kehamilan->abortus }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="text-hint small">HPHT / TP</span>
                                <span class="fw-bold small text-dark">{{ \Carbon\Carbon::parse($kunjungan->kehamilan->hpht)->format('d/m/y') }} / {{ \Carbon\Carbon::parse($kunjungan->kehamilan->tp)->format('d/m/y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bidan/Pemeriksa Card -->
                <div class="card border-0 shadow-card rounded-xl overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div>
                                <div class="text-hint x-small uppercase-font">PEMERIKSA</div>
                                <div class="fw-bold text-dark">{{ $kunjungan->bidan->name }}</div>
                                <div class="text-hint small">{{ $kunjungan->bidan->fasilitas?->nama ?? 'Faskes' }}</div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top d-flex justify-content-between">
                            <span class="text-hint small">Tanggal Periksa</span>
                            <span class="fw-bold small">{{ $kunjungan->tanggal->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Temuan Klinis Card -->
                <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center">
                        <i class="fas fa-file-waveform text-danger me-2"></i>
                        <h6 class="mb-0 fw-bold">Temuan Fisik & Vital</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-danger">
                                    <div class="text-hint x-small uppercase-font mb-1">Tekanan Darah</div>
                                    <div class="h4 fw-extrabold text-dark mb-0">{{ $kunjungan->tekanan_darah_sistolik }}/{{ $kunjungan->tekanan_darah_diastolik }} <small class="fw-normal text-muted">mmHg</small></div>
                                    <div class="text-hint x-small mt-1">MAP: {{ $kunjungan->map }} mmHg</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-primary">
                                    <div class="text-hint x-small uppercase-font mb-1">Berat Badan & IMT</div>
                                    <div class="h4 fw-extrabold text-dark mb-0">{{ $kunjungan->berat_badan }} <small class="fw-normal text-muted">kg</small></div>
                                    <div class="text-hint x-small mt-1">IMT: {{ $kunjungan->imt ?? '-' }} | Naik: {{ $kunjungan->penambahan_bb ?? 0 }} kg</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="text-hint small mb-1">Nadi</div>
                                <div class="fw-bold text-dark">{{ $kunjungan->nadi }} <small class="text-muted">x/mnt</small></div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="text-hint small mb-1">Pernapasan</div>
                                <div class="fw-bold text-dark">{{ $kunjungan->respirasi ?? '-' }} <small class="text-muted">x/mnt</small></div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="text-hint small mb-1">Suhu Tubuh</div>
                                <div class="fw-bold text-dark">{{ $kunjungan->suhu ?? '-' }} <small class="text-muted">°C</small></div>
                            </div>
                            <div class="col-md-4 col-6 border-top pt-3">
                                <div class="text-hint small mb-1">Tinggi Fundus (TFU)</div>
                                <div class="fw-bold text-dark">{{ $kunjungan->tinggi_fundus_uteri }} <small class="text-muted">cm</small></div>
                            </div>
                            <div class="col-md-4 col-6 border-top pt-3">
                                <div class="text-hint small mb-1">DJJ Janin</div>
                                <div class="fw-bold text-dark">{{ $kunjungan->djj }} <small class="text-muted">x/mnt</small></div>
                            </div>
                            <div class="col-md-4 col-6 border-top pt-3">
                                <div class="text-hint small mb-1">Edema (Bengkak)</div>
                                <div class="fw-bold text-{{ $kunjungan->edema === 'Tidak' ? 'dark' : 'danger' }}">{{ $kunjungan->edema }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laboratorium & Gejala -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-card rounded-xl h-100 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center">
                                <i class="fas fa-microscope text-warning me-2"></i>
                                <h6 class="mb-0 fw-bold">Pemeriksaan Lab</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <div class="text-hint small mb-1">Protein Urine</div>
                                    <div class="badge-risk {{ $kunjungan->protein_urine === 'Negatif' ? 'badge-risk--green' : 'badge-risk--red' }} w-100 py-2 fs-6">
                                        {{ $kunjungan->protein_urine }}
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="text-hint x-small">Hemoglobin (Hb)</div>
                                        <div class="fw-bold small">{{ $kunjungan->hb ?? '-' }} g/dL</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-hint x-small">Trombosit</div>
                                        <div class="fw-bold small">{{ $kunjungan->trombosit ?? '-' }} /μL</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-hint x-small">Kreatinin</div>
                                        <div class="fw-bold small">{{ $kunjungan->kreatinin ?? '-' }} mg/dL</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-hint x-small">Glukosa Urine</div>
                                        <div class="fw-bold small">{{ $kunjungan->glukosa_urine ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-card rounded-xl h-100 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center">
                                <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                                <h6 class="mb-0 fw-bold">Gejala Subjektif</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge {{ $kunjungan->nyeri_kepala_hebat ? 'bg-danger' : 'bg-light text-muted border' }} px-3 rounded-pill small">Sakit Kepala</span>
                                    <span class="badge {{ $kunjungan->gangguan_penglihatan ? 'bg-danger' : 'bg-light text-muted border' }} px-3 rounded-pill small">Pandangan Kabur</span>
                                    <span class="badge {{ $kunjungan->nyeri_ulu_hati ? 'bg-danger' : 'bg-light text-muted border' }} px-3 rounded-pill small">Nyeri Ulu Hati</span>
                                    <span class="badge {{ $kunjungan->ada_riwayat_kejang ? 'bg-danger' : 'bg-light text-muted border' }} px-3 rounded-pill small">Kejang</span>
                                    <span class="badge {{ $kunjungan->edema_paru ? 'bg-danger' : 'bg-light text-muted border' }} px-3 rounded-pill small">Sesak Napas</span>
                                </div>
                                <div class="text-hint x-small uppercase-font mb-1">Keluhan Lainnya</div>
                                <div class="p-3 bg-light rounded-3 small text-dark border-start border-3 border-secondary">
                                    {{ $kunjungan->keluhan_subjektif ?: 'Tidak ada keluhan subjektif lainnya.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Bidan Card -->
                <div class="card border-0 shadow-card rounded-xl overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center">
                        <i class="fas fa-comment-medical text-primary me-2"></i>
                        <h6 class="mb-0 fw-bold">Rencana Tindak Lanjut & Instruksi</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="p-4 bg-primary-subtle bg-opacity-10 rounded-4 border border-primary border-opacity-25 shadow-sm">
                            <p class="mb-0 text-dark" style="line-height: 1.6;">{{ $kunjungan->catatan_bidan ?: 'Belum ada catatan tindak lanjut khusus dari bidan.' }}</p>
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
