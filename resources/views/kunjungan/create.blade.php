@extends('layouts.app')

@section('title', 'Input Kunjungan ANC')
@section('page_title', 'Kunjungan ANC Baru')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <!-- Patient Header Card -->
        <div class="patient-card border-0 shadow-card mb-4 p-4" style="background: linear-gradient(to right, #ffffff, #f8fafc);">
            <div class="patient-card__avatar bg-peka-primary text-white shadow-sm" style="width: 60px; height: 60px; font-size: 1.5rem;">
                <i class="fas fa-person-pregnant text-danger"></i>
            </div>
            <div class="patient-card__info ms-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="patient-card__name fs-4 mb-1">{{ $kehamilan->pasien->nama }}</div>
                        <div class="patient-card__meta fs-6">
                            <span><i class="fas fa-id-card text-muted me-1"></i> NIK: {{ $kehamilan->pasien->nik }}</span>
                            <span class="ms-3"><i class="fas fa-calendar-alt text-muted me-1"></i> HPHT: {{ \Carbon\Carbon::parse($kehamilan->hpht)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-peka-primary-pale text-peka-primary px-3 py-2 rounded-pill fw-bold">
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

            <div class="row">
                <div class="col-lg-8">
                    <!-- Tanda Vital Section -->
                    <div class="card border-0 shadow-card rounded-xl mb-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-danger-subtle text-danger p-2 rounded-3 me-3">
                                    <i class="fas fa-heart-pulse"></i>
                                </span>
                                Pemeriksaan Fisik & Vital
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Tanggal Periksa</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-calendar-check input-icon"></i>
                                        <input type="date" name="tanggal" class="form-control-peka" value="{{ date('Y-m-d') }}" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Usia Kehamilan (Sistem)</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-baby input-icon"></i>
                                        <input type="text" class="form-control-peka bg-light border-0 fw-bold text-primary" value="{{ $uk_minggu }} Minggu" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Tekanan Darah (Sistolik/Diastolik)</label>
                                    <div class="d-flex gap-2">
                                        <div class="input-group-peka grow">
                                            <input type="number" name="tekanan_darah_sistolik" class="form-control-peka @error('tekanan_darah_sistolik') is-invalid @enderror" placeholder="Sistolik" value="{{ old('tekanan_darah_sistolik') }}" required>
                                            <span class="input-unit">mmHg</span>
                                        </div>
                                        <div class="align-self-center text-muted fw-bold">/</div>
                                        <div class="input-group-peka grow">
                                            <input type="number" name="tekanan_darah_diastolik" class="form-control-peka @error('tekanan_darah_diastolik') is-invalid @enderror" placeholder="Diastolik" value="{{ old('tekanan_darah_diastolik') }}" required>
                                            <span class="input-unit">mmHg</span>
                                        </div>
                                    </div>
                                    @error('tekanan_darah_sistolik') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    @error('tekanan_darah_diastolik') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Berat Badan</label>
                                    <div class="input-group-peka">
                                        <input type="number" step="0.1" name="berat_badan" class="form-control-peka @error('berat_badan') is-invalid @enderror" value="{{ old('berat_badan') }}" required>
                                        <span class="input-unit">kg</span>
                                    </div>
                                    @error('berat_badan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label form-label-required">Tinggi Fundus (TFU)</label>
                                    <div class="input-group-peka">
                                        <input type="number" name="tinggi_fundus_uteri" class="form-control-peka @error('tinggi_fundus_uteri') is-invalid @enderror" value="{{ old('tinggi_fundus_uteri') }}" required>
                                        <span class="input-unit">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label form-label-required">DJJ Janin</label>
                                    <div class="input-group-peka">
                                        <input type="number" name="djj" class="form-control-peka @error('djj') is-invalid @enderror" value="{{ old('djj') }}" required>
                                        <span class="input-unit">x/mnt</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label form-label-required">Nadi Ibu</label>
                                    <div class="input-group-peka">
                                        <input type="number" name="nadi" class="form-control-peka" value="{{ old('nadi') }}" required>
                                        <span class="input-unit">x/mnt</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light">
                                        <label class="form-label fw-bold mb-3 d-flex align-items-center">
                                            <i class="fas fa-triangle-exclamation text-warning me-2"></i> 
                                            Gejala Bahaya / Darurat
                                        </label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-check form-switch custom-switch">
                                                    <input class="form-check-input" type="checkbox" name="ada_riwayat_kejang" id="kejang">
                                                    <label class="form-check-label" for="kejang">Ada Riwayat Kejang</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch custom-switch">
                                                    <input class="form-check-input" type="checkbox" name="nyeri_kepala_hebat" id="kepala">
                                                    <label class="form-check-label" for="kepala">Nyeri Kepala Hebat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch custom-switch">
                                                    <input class="form-check-input" type="checkbox" name="gangguan_penglihatan" id="penglihatan">
                                                    <label class="form-check-label" for="penglihatan">Pandangan Kabur</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch custom-switch">
                                                    <input class="form-check-input" type="checkbox" name="nyeri_ulu_hati" id="ulu_hati">
                                                    <label class="form-check-label" for="ulu_hati">Nyeri Ulu Hati</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Laboratorium Section -->
                    <div class="card border-0 shadow-card rounded-xl mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-warning-subtle text-warning p-2 rounded-3 me-3">
                                    <i class="fas fa-microscope"></i>
                                </span>
                                Pemeriksaan Laboratorium
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Protein Urine</label>
                                    <select name="protein_urine" class="form-control-peka @error('protein_urine') is-invalid @enderror" required>
                                        <option value="Negatif">Negatif (Bersih)</option>
                                        <option value="+1">+1 (Positif Ringan)</option>
                                        <option value="+2">+2 (Positif Sedang)</option>
                                        <option value="+3">+3 (Positif Berat)</option>
                                        <option value="+4">+4 (Sangat Berat)</option>
                                    </select>
                                    <div class="form-text mt-2 text-primary" style="font-size: 0.75rem;">
                                        <i class="fas fa-info-circle me-1"></i> Parameter kunci untuk skrining PE.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Edema (Bengkak)</label>
                                    <select name="edema" class="form-control-peka">
                                        <option value="Tidak">Tidak Ada Edema</option>
                                        <option value="+1">+1 (Pitting minimal)</option>
                                        <option value="+2">+2 (Pitting sedang)</option>
                                        <option value="+3">+3 (Pitting dalam)</option>
                                    </select>
                                </div>
                                
                                <div class="col-12"><hr class="divider-h opacity-50"></div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Hemoglobin (Hb)</label>
                                    <div class="input-group-peka">
                                        <input type="number" step="0.1" name="hb" class="form-control-peka" value="{{ old('hb') }}">
                                        <span class="input-unit">g/dL</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Trombosit</label>
                                    <div class="input-group-peka">
                                        <input type="number" name="trombosit" class="form-control-peka" value="{{ old('trombosit') }}">
                                        <span class="input-unit">/μL</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kreatinin</label>
                                    <div class="input-group-peka">
                                        <input type="number" step="0.01" name="kreatinin" class="form-control-peka" value="{{ old('kreatinin') }}">
                                        <span class="input-unit">mg/dL</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Catatan & Keluhan Sidebar -->
                    <div class="card border-0 shadow-card rounded-xl mb-4 sticky-top" style="top: 80px; z-index: 10;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                    <i class="fas fa-comment-medical"></i>
                                </span>
                                Anamnesa & Catatan
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Keluhan Subjektif</label>
                                <textarea name="keluhan_subjektif" class="form-control-peka" rows="4" placeholder="Contoh: Sakit kepala, mual, janin kurang bergerak...">{{ old('keluhan_subjektif') }}</textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Rencana Tindak Lanjut</label>
                                <textarea name="catatan_bidan" class="form-control-peka" rows="4" placeholder="Tulis instruksi bidan untuk pasien...">{{ old('catatan_bidan') }}</textarea>
                            </div>

                            <div class="alert alert-info border-0 rounded-3 mb-4" style="font-size: 0.8rem;">
                                <div class="d-flex">
                                    <i class="fas fa-lightbulb me-2 mt-1"></i>
                                    <div>Sistem akan otomatis menghitung <strong>MAP (Mean Arterial Pressure)</strong> dan <strong>Status Risiko</strong> setelah disimpan.</div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-peka-primary w-100 py-3 shadow-sm">
                                    <i class="fas fa-cloud-upload-alt me-2"></i> SIMPAN PEMERIKSAAN
                                </button>
                                <a href="{{ route('pasien.show', $kehamilan->pasien_id) }}" class="btn btn-light border w-100 py-2">
                                    Batal & Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
