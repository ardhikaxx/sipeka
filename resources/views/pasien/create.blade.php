@extends('layouts.app')

@section('title', 'Registrasi Pasien Baru')
@section('page_title', 'Registrasi Ibu Hamil')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            
            <!-- Identitas Pribadi -->
            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="section-title mb-0"><i class="fas fa-address-card text-primary me-2"></i>Identitas Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label form-label-required">NIK (16 Digit)</label>
                            <input type="text" name="nik" class="form-control-peka @error('nik') is-invalid @enderror" value="{{ old('nik') }}" maxlength="16" required>
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label form-label-required">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control-peka @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label form-label-required">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control-peka @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir') }}" required>
                            @error('tgl_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor HP/WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control-peka" value="{{ old('no_hp') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Golongan Darah</label>
                            <select name="golongan_darah" class="form-control-peka">
                                <option value="">-- Pilih --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tinggi Badan</label>
                            <div class="input-group-peka">
                                <input type="number" step="0.1" name="tinggi_badan" class="form-control-peka" value="{{ old('tinggi_badan') }}">
                                <span class="input-unit">cm</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status Pernikahan</label>
                            <select name="status_pernikahan" class="form-control-peka">
                                <option value="Menikah">Menikah</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Cerai">Cerai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nama Suami/Wali</label>
                            <input type="text" name="nama_suami" class="form-control-peka" value="{{ old('nama_suami') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label form-label-required">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control-peka @error('alamat') is-invalid @enderror" rows="2" required>{{ old('alamat') }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Kehamilan & Obstetri -->
            <div class="card border-0 shadow-card rounded-xl mb-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="section-title mb-0"><i class="fas fa-baby text-secondary me-2"></i>Data Kehamilan Saat Ini & Obstetri</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label form-label-required">HPHT</label>
                            <input type="date" name="hpht" class="form-control-peka @error('hpht') is-invalid @enderror" value="{{ old('hpht') }}" required>
                            @error('hpht') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="text-hint mt-1">Hari Pertama Haid Terakhir</div>
                        </div>
                        
                        <div class="col-md-8">
                            <label class="form-label form-label-required">GPA (Gravida, Para, Abortus)</label>
                            <div class="d-flex gap-2">
                                <div class="input-group-peka w-100">
                                    <span class="input-icon">G</span>
                                    <input type="number" name="gravida" class="form-control-peka" min="1" value="{{ old('gravida', 1) }}" required>
                                </div>
                                <div class="input-group-peka w-100">
                                    <span class="input-icon">P</span>
                                    <input type="number" name="para" class="form-control-peka" min="0" value="{{ old('para', 0) }}" required>
                                </div>
                                <div class="input-group-peka w-100">
                                    <span class="input-icon">A</span>
                                    <input type="number" name="abortus" class="form-control-peka" min="0" value="{{ old('abortus', 0) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <label class="form-label mb-2">Faktor Risiko Kesehatan (Centang jika ada)</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_preeklampsia" id="r_pe" value="1">
                                        <label class="form-check-label" for="r_pe">Riwayat Preeklampsia Sebelumnya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_hipertensi" id="r_ht" value="1">
                                        <label class="form-check-label" for="r_ht">Hipertensi Kronis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_diabetes" id="r_dm" value="1">
                                        <label class="form-check-label" for="r_dm">Diabetes Mellitus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_ginjal" id="r_gn" value="1">
                                        <label class="form-check-label" for="r_gn">Penyakit Ginjal</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_bblr" id="r_bblr" value="1">
                                        <label class="form-check-label" for="r_bblr">Riwayat Bayi BBLR</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keluarga_preeklampsia" id="r_kpe" value="1">
                                        <label class="form-check-label" for="r_kpe">Keluarga dengan Preeklampsia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kehamilan_kembar" id="r_kem" value="1">
                                        <label class="form-check-label" for="r_kem">Kehamilan Kembar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interval_lebih_10" id="r_int" value="1">
                                        <label class="form-check-label" for="r_int">Interval Kehamilan > 10 Tahun</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('pasien.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-peka-primary px-4">Simpan Pasien Baru</button>
            </div>
        </form>
    </div>
</div>
@endsection
