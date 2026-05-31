@extends('layouts.app')

@section('title', 'Input Kunjungan ANC')
@section('page_title', 'Kunjungan ANC Baru')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <!-- Patient Header Card -->
        <div class="patient-card d-flex flex-column flex-md-row justify-content-start align-items-center gap-2 gap-md-3 border-0 shadow-card mb-4 p-3 p-md-4 text-center text-md-start" style="background: linear-gradient(to right, #ffffff, #f8fafc);">
            <div class="patient-card__avatar bg-danger d-flex justify-content-center align-items-center text-white shadow-sm rounded-4 flex-shrink-0" style="width: 54px; height: 54px; font-size: 1.4rem;">
                <i class="fas fa-person-pregnant text-white"></i>
            </div>
            <div class="patient-card__info grow w-100">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center align-items-sm-start gap-2">
                    <div>
                        <div class="patient-card__name fw-bold text-dark fs-5 mb-1">{{ $kehamilan->pasien->nama }}</div>
                        <div class="patient-card__meta x-small text-muted">
                            <span><i class="fas fa-id-card me-1"></i> {{ $kehamilan->pasien->nik }}</span>
                            <span class="mx-2 opacity-25">|</span>
                            <span><i class="fas fa-calendar-alt me-1"></i> HPHT: {{ \Carbon\Carbon::parse($kehamilan->hpht)->format('d/m/y') }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-peka-primary-pale text-peka-primary px-3 py-2 rounded-pill fw-bold small">
                            G{{ $kehamilan->gravida }} P{{ $kehamilan->para }} A{{ $kehamilan->abortus }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('kunjungan.store') }}" method="POST" id="form-kunjungan">
            @csrf
            <input type="hidden" name="kehamilan_id" value="{{ $kehamilan->id }}">
            
            @php
                $uk_minggu = \Carbon\Carbon::parse($kehamilan->hpht)->diffInWeeks(now());
            @endphp
            <input type="hidden" name="usia_kehamilan_minggu" value="{{ $uk_minggu }}">

            <div class="row g-3 g-lg-4">
                <div class="col-12 col-lg-8">
                    <!-- Tanda Vital Section -->
                    <div class="card border-0 shadow-card rounded-xl mb-3 mb-lg-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                            <h5 class="section-title mb-0 d-flex align-items-center fs-6">
                                <span class="bg-danger-subtle text-danger p-2 rounded-3 me-3">
                                    <i class="fas fa-heart-pulse"></i>
                                </span>
                                Fisik & Vital
                            </h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-6 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control-peka" value="{{ date('Y-m-d') }}" required readonly>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label class="form-label small fw-bold">UK (Sistem)</label>
                                    <input type="text" class="form-control-peka bg-light border-0 fw-bold text-primary small" value="{{ $uk_minggu }} Mg" readonly>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">Tekanan Darah (S/D)</label>
                                    <div class="d-flex gap-2">
                                        <div class="input-group-peka grow">
                                            <input type="number" name="tekanan_darah_sistolik" class="form-control-peka @error('tekanan_darah_sistolik') is-invalid @enderror px-2" placeholder="Sistolik" required>
                                            <span class="input-unit d-none d-sm-block">mmHg</span>
                                        </div>
                                        <div class="align-self-center text-muted fw-bold">/</div>
                                        <div class="input-group-peka grow">
                                            <input type="number" name="tekanan_darah_diastolik" class="form-control-peka @error('tekanan_darah_diastolik') is-invalid @enderror px-2" placeholder="Diastolik" required>
                                            <span class="input-unit d-none d-sm-block">mmHg</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <label class="form-label form-label-required small fw-bold">Berat (kg)</label>
                                    <input type="number" step="0.1" name="berat_badan" class="form-control-peka px-2" required>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label form-label-required small fw-bold">TFU (cm)</label>
                                    <input type="number" name="tinggi_fundus_uteri" class="form-control-peka px-2" required>
                                </div>

                                <div class="col-6 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">DJJ Janin (x/m)</label>
                                    <input type="number" name="djj" class="form-control-peka px-2" required>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">Nadi Ibu (x/m)</label>
                                    <input type="number" name="nadi" class="form-control-peka px-2" required>
                                </div>

                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light border">
                                        <label class="form-label fw-bold mb-3 d-flex align-items-center small">
                                            <i class="fas fa-triangle-exclamation text-warning me-2"></i> 
                                            Gejala Bahaya / Darurat
                                        </label>
                                        <div class="row g-2">
                                            @foreach(['kejang' => 'Riwayat Kejang', 'kepala' => 'Sakit Kepala', 'penglihatan' => 'Pandangan Kabur', 'ulu_hati' => 'Nyeri Ulu Hati'] as $id => $label)
                                            <div class="col-6 col-sm-6">
                                                <div class="form-check form-switch custom-switch-sm">
                                                    <input class="form-check-input" type="checkbox" name="{{ $id === 'kejang' ? 'ada_riwayat_kejang' : ($id === 'kepala' ? 'nyeri_kepala_hebat' : ($id === 'penglihatan' ? 'gangguan_penglihatan' : 'nyeri_ulu_hati')) }}" id="{{ $id }}">
                                                    <label class="form-check-label x-small" for="{{ $id }}">{{ $label }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Laboratorium Section -->
                    <div class="card border-0 shadow-card rounded-xl mb-3 mb-lg-4">
                        <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                            <h5 class="section-title mb-0 d-flex align-items-center fs-6">
                                <span class="bg-warning-subtle text-warning p-2 rounded-3 me-3">
                                    <i class="fas fa-microscope"></i>
                                </span>
                                Lab & Penunjang
                            </h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label form-label-required small fw-bold">Protein Urine</label>
                                    <select name="protein_urine" class="form-control-peka small" required>
                                        <option value="Negatif">Negatif (Bersih)</option>
                                        <option value="+1">+1 (Ringan)</option>
                                        <option value="+2">+2 (Sedang)</option>
                                        <option value="+3">+3 (Berat)</option>
                                        <option value="+4">+4 (Sangat Berat)</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Edema (Bengkak)</label>
                                    <select name="edema" class="form-control-peka small">
                                        <option value="Tidak">Tidak Ada</option>
                                        <option value="+1">+1 (Minimal)</option>
                                        <option value="+2">+2 (Sedang)</option>
                                        <option value="+3">+3 (Berat)</option>
                                    </select>
                                </div>
                                
                                <div class="col-4 col-md-4">
                                    <label class="form-label x-small fw-bold">Hb</label>
                                    <input type="number" step="0.1" name="hb" class="form-control-peka px-2" placeholder="g/dL">
                                </div>
                                <div class="col-4 col-md-4">
                                    <label class="form-label x-small fw-bold">Trombosit</label>
                                    <input type="number" name="trombosit" class="form-control-peka px-2" placeholder="/μL">
                                </div>
                                <div class="col-4 col-md-4">
                                    <label class="form-label x-small fw-bold">Kreatinin</label>
                                    <input type="number" step="0.01" name="kreatinin" class="form-control-peka px-2" placeholder="mg/dL">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <!-- Catatan & Keluhan Sidebar -->
                    <div class="card border-0 shadow-card rounded-xl mb-4 sticky-top-lg">
                        <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                            <h5 class="section-title mb-0 d-flex align-items-center fs-6">
                                <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                    <i class="fas fa-comment-medical"></i>
                                </span>
                                Catatan Bidan
                            </h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Keluhan Pasien</label>
                                <textarea name="keluhan_subjektif" class="form-control-peka x-small" rows="3" placeholder="Sakit kepala, mual..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Tindak Lanjut</label>
                                <textarea name="catatan_bidan" class="form-control-peka x-small" rows="3" placeholder="Instruksi untuk pasien..."></textarea>
                            </div>

                            <div class="alert alert-info border-0 rounded-3 mb-4 x-small py-2 px-3">
                                <i class="fas fa-lightbulb me-1"></i> Sistem akan menghitung <strong>MAP</strong> & <strong>Risiko</strong> otomatis.
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-peka-primary w-100 py-3 shadow-sm fw-bold">
                                    <i class="fas fa-cloud-upload-alt me-2"></i> SIMPAN HASIL
                                </button>
                                <a href="{{ route('pasien.show', $kehamilan->pasien_id) }}" class="btn btn-light border w-100 py-2 small">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    @media (min-width: 992px) { .sticky-top-lg { position: sticky; top: 80px; z-index: 10; } }
    .custom-switch-sm .form-check-input { width: 2.2rem; height: 1.1rem; cursor: pointer; }
    .custom-switch-sm .form-check-label { padding-top: 2px; cursor: pointer; }
</style>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-switch .form-check-input { width: 3rem; height: 1.5rem; margin-right: 12px; cursor: pointer; }
    .custom-switch .form-check-label { padding-top: 4px; cursor: pointer; font-weight: 500; }
    .form-control-peka::placeholder { color: var(--gray-400); font-size: 0.8rem; }
    .sticky-top { transition: top 0.3s; }
</style>
@endpush
