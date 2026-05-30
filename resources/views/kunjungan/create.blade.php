@extends('layouts.app')

@section('title', 'Input Kunjungan ANC')
@section('page_title', 'Kunjungan ANC Baru')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        
        <div class="patient-card border-start-0 mb-4" style="border-left: 4px solid var(--peka-primary) !important;">
            <div class="patient-card__avatar">
                <i class="fas fa-person-pregnant"></i>
            </div>
            <div class="patient-card__info">
                <div class="patient-card__name">{{ $kehamilan->pasien->nama }}</div>
                <div class="patient-card__meta">
                    <span><i class="fas fa-id-card"></i> NIK: {{ $kehamilan->pasien->nik }}</span>
                    <span><i class="fas fa-calendar-alt"></i> HPHT: {{ \Carbon\Carbon::parse($kehamilan->hpht)->format('d M Y') }}</span>
                    <span><i class="fas fa-baby"></i> G{{ $kehamilan->gravida }} P{{ $kehamilan->para }} A{{ $kehamilan->abortus }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('kunjungan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kehamilan_id" value="{{ $kehamilan->id }}">
            
            @php
                $uk_minggu = \Carbon\Carbon::parse($kehamilan->hpht)->diffInWeeks(now());
            @endphp
            <input type="hidden" name="usia_kehamilan_minggu" value="{{ $uk_minggu }}">

            <!-- Tanda Vital -->
            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="section-title mb-0"><i class="fas fa-heart-pulse text-danger me-2"></i>Pemeriksaan Tanda Vital</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="form-label form-label-required">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control-peka" value="{{ date('Y-m-d') }}" required readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Usia Kehamilan</label>
                            <input type="text" class="form-control-peka bg-light" value="{{ $uk_minggu }} Minggu" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label form-label-required">Berat Badan</label>
                            <div class="input-group-peka">
                                <input type="number" step="0.1" name="berat_badan" class="form-control-peka @error('berat_badan') is-invalid @enderror" value="{{ old('berat_badan') }}" required>
                                <span class="input-unit">kg</span>
                            </div>
                            @error('berat_badan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label form-label-required">Tinggi Fundus (TFU)</label>
                            <div class="input-group-peka">
                                <input type="number" name="tinggi_fundus_uteri" class="form-control-peka @error('tinggi_fundus_uteri') is-invalid @enderror" value="{{ old('tinggi_fundus_uteri') }}" required>
                                <span class="input-unit">cm</span>
                            </div>
                            @error('tinggi_fundus_uteri') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-12"><hr class="divider-h my-2"></div>
                        
                        <div class="col-md-4">
                            <label class="form-label form-label-required text-danger fw-bold">Sistolik</label>
                            <div class="input-group-peka">
                                <input type="number" name="tekanan_darah_sistolik" class="form-control-peka border-danger @error('tekanan_darah_sistolik') is-invalid @enderror" value="{{ old('tekanan_darah_sistolik') }}" required>
                                <span class="input-unit">mmHg</span>
                            </div>
                            @error('tekanan_darah_sistolik') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label form-label-required text-primary fw-bold">Diastolik</label>
                            <div class="input-group-peka">
                                <input type="number" name="tekanan_darah_diastolik" class="form-control-peka border-primary @error('tekanan_darah_diastolik') is-invalid @enderror" value="{{ old('tekanan_darah_diastolik') }}" required>
                                <span class="input-unit">mmHg</span>
                            </div>
                            @error('tekanan_darah_diastolik') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label form-label-required">Nadi</label>
                            <div class="input-group-peka">
                                <input type="number" name="nadi" class="form-control-peka @error('nadi') is-invalid @enderror" value="{{ old('nadi') }}" required>
                                <span class="input-unit">x/m</span>
                            </div>
                            @error('nadi') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Suhu</label>
                            <div class="input-group-peka">
                                <input type="number" step="0.1" name="suhu" class="form-control-peka" value="{{ old('suhu') }}">
                                <span class="input-unit">C</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Respirasi</label>
                            <div class="input-group-peka">
                                <input type="number" name="respirasi" class="form-control-peka" value="{{ old('respirasi') }}">
                                <span class="input-unit">x/m</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label form-label-required">DJJ (Denyut Jantung Janin)</label>
                            <div class="input-group-peka">
                                <input type="number" name="djj" class="form-control-peka @error('djj') is-invalid @enderror" value="{{ old('djj') }}" required>
                                <span class="input-unit">x/m</span>
                            </div>
                            @error('djj') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label form-label-required">Edema (Bengkak)</label>
                            <select name="edema" class="form-control-peka">
                                <option value="Tidak">Tidak</option>
                                <option value="+1">+1</option>
                                <option value="+2">+2</option>
                                <option value="+3">+3</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label mb-2">Gejala Berat / Darurat</label>
                            <div class="row g-2">
                                <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="ada_riwayat_kejang" id="kejang"><label class="form-check-label" for="kejang">Kejang</label></div></div>
                                <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="nyeri_kepala_hebat" id="kepala"><label class="form-check-label" for="kepala">Nyeri kepala hebat</label></div></div>
                                <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="gangguan_penglihatan" id="penglihatan"><label class="form-check-label" for="penglihatan">Gangguan penglihatan</label></div></div>
                                <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="nyeri_ulu_hati" id="ulu_hati"><label class="form-check-label" for="ulu_hati">Nyeri ulu hati</label></div></div>
                                <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="edema_paru" id="edema_paru"><label class="form-check-label" for="edema_paru">Sesak/edema paru</label></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laboratorium -->
            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="section-title mb-0"><i class="fas fa-flask text-warning me-2"></i>Pemeriksaan Lab (Penting untuk Skrining PE)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label form-label-required">Protein Urine</label>
                            <select name="protein_urine" class="form-control-peka @error('protein_urine') is-invalid @enderror" required>
                                <option value="Negatif">Negatif</option>
                                <option value="+1">+1</option>
                                <option value="+2">+2</option>
                                <option value="+3">+3</option>
                                <option value="+4">+4</option>
                            </select>
                            @error('protein_urine') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Glukosa Urine</label>
                            <select name="glukosa_urine" class="form-control-peka">
                                <option value="">Tidak diperiksa</option>
                                <option value="Negatif">Negatif</option>
                                <option value="Positif">Positif</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <p class="text-muted mb-2" style="font-size: 0.8rem;">Data lab lanjutan (opsional, jika dilakukan pemeriksaan lab lengkap)</p>
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
                                <input type="number" step="0.1" name="kreatinin" class="form-control-peka" value="{{ old('kreatinin') }}">
                                <span class="input-unit">mg/dL</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hemoglobin</label>
                            <div class="input-group-peka">
                                <input type="number" step="0.1" name="hb" class="form-control-peka" value="{{ old('hb') }}">
                                <span class="input-unit">g/dL</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SGOT</label>
                            <div class="input-group-peka">
                                <input type="number" name="sgot" class="form-control-peka" value="{{ old('sgot') }}">
                                <span class="input-unit">U/L</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SGPT</label>
                            <div class="input-group-peka">
                                <input type="number" name="sgpt" class="form-control-peka" value="{{ old('sgpt') }}">
                                <span class="input-unit">U/L</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-body p-4">
                     <label class="form-label">Keluhan Subjektif</label>
                     <textarea name="keluhan_subjektif" class="form-control-peka mb-3" rows="2" placeholder="Sakit kepala, pandangan kabur, nyeri ulu hati..."></textarea>
                     
                     <label class="form-label">Catatan Bidan</label>
                     <textarea name="catatan_bidan" class="form-control-peka" rows="2" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('pasien.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-peka-primary px-4"><i class="fas fa-save me-2"></i>Simpan Kunjungan</button>
            </div>
        </form>
    </div>
</div>
@endsection
