@extends('layouts.app')

@section('title', 'Registrasi Pasien Baru')
@section('page_title', 'Registrasi Ibu Hamil')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <div class="mb-4">
            <a href="{{ route('pasien.index') }}" class="text-decoration-none text-muted">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pasien
            </a>
        </div>

        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-lg-7">
                    <!-- Identitas Pribadi -->
                    <div class="card border-0 shadow-card rounded-xl mb-4">
                        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                    <i class="fas fa-address-card"></i>
                                </span>
                                Identitas Pribadi
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label form-label-required">Nama Lengkap Pasien</label>
                                    <input type="text" name="nama" class="form-control-peka @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Siti Aminah" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">NIK (16 Digit)</label>
                                    <input type="text" name="nik" class="form-control-peka @error('nik') is-invalid @enderror" value="{{ old('nik') }}" maxlength="16" placeholder="320..." required>
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-required">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control-peka @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir') }}" required>
                                    @error('tgl_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Nomor HP/WhatsApp</label>
                                    <div class="input-group-peka">
                                        <i class="fab fa-whatsapp input-icon"></i>
                                        <input type="text" name="no_hp" class="form-control-peka" value="{{ old('no_hp') }}" placeholder="0812...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Suami/Wali</label>
                                    <input type="text" name="nama_suami" class="form-control-peka" value="{{ old('nama_suami') }}" placeholder="Nama pendamping">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Golongan Darah</label>
                                    <select name="golongan_darah" class="form-control-peka">
                                        <option value="">-- Pilih --</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tinggi Badan</label>
                                    <div class="input-group-peka">
                                        <input type="number" step="0.1" name="tinggi_badan" class="form-control-peka" value="{{ old('tinggi_badan') }}">
                                        <span class="input-unit">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Nikah</label>
                                    <select name="status_pernikahan" class="form-control-peka">
                                        <option value="Menikah">Menikah</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Cerai">Cerai</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label form-label-required">Alamat Domisili</label>
                                    <textarea name="alamat" class="form-control-peka @error('alamat') is-invalid @enderror" rows="3" placeholder="Jl. Raya No. 123, RT/RW..." required>{{ old('alamat') }}</textarea>
                                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <!-- Data Kehamilan Section -->
                    <div class="card border-0 shadow-card rounded-xl mb-4">
                        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                            <h5 class="section-title mb-0 d-flex align-items-center">
                                <span class="bg-secondary-subtle text-secondary p-2 rounded-3 me-3">
                                    <i class="fas fa-baby"></i>
                                </span>
                                Kondisi Kehamilan Saat Ini
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label form-label-required">HPHT (Hari Pertama Haid Terakhir)</label>
                                    <input type="date" name="hpht" class="form-control-peka @error('hpht') is-invalid @enderror" value="{{ old('hpht') }}" required>
                                    @error('hpht') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label form-label-required">Status Obstetri (GPA)</label>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <div class="input-group-peka">
                                                <span class="input-icon fw-bold text-primary">G</span>
                                                <input type="number" name="gravida" class="form-control-peka ps-4" min="1" value="{{ old('gravida', 1) }}" required>
                                            </div>
                                            <div class="text-center small text-muted mt-1">Kehamilan</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group-peka">
                                                <span class="input-icon fw-bold text-success">P</span>
                                                <input type="number" name="para" class="form-control-peka ps-4" min="0" value="{{ old('para', 0) }}" required>
                                            </div>
                                            <div class="text-center small text-muted mt-1">Persalinan</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group-peka">
                                                <span class="input-icon fw-bold text-danger">A</span>
                                                <input type="number" name="abortus" class="form-control-peka ps-4" min="0" value="{{ old('abortus', 0) }}" required>
                                            </div>
                                            <div class="text-center small text-muted mt-1">Keguguran</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 pt-2">
                                    <label class="form-label mb-3 fw-bold border-bottom pb-2 w-100">Faktor Risiko Awal</label>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input" type="checkbox" name="riwayat_preeklampsia" id="r_pe" value="1">
                                                <label class="form-check-label" for="r_pe">Riwayat Preeklampsia</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input" type="checkbox" name="riwayat_hipertensi" id="r_ht" value="1">
                                                <label class="form-check-label" for="r_ht">Hipertensi Kronis</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input" type="checkbox" name="riwayat_diabetes" id="r_dm" value="1">
                                                <label class="form-check-label" for="r_dm">Diabetes Mellitus</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input" type="checkbox" name="kehamilan_kembar" id="r_kem" value="1">
                                                <label class="form-check-label" for="r_kem">Kehamilan Kembar</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-light btn-sm w-100 border-dashed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#moreRisks">
                                                <i class="fas fa-plus me-1"></i> Tampilkan Faktor Lainnya
                                            </button>
                                        </div>
                                        <div class="collapse col-12" id="moreRisks">
                                            <div class="p-3 bg-light rounded-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="riwayat_ginjal" id="r_gn" value="1">
                                                    <label class="form-check-label" for="r_gn">Penyakit Ginjal</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="riwayat_bblr" id="r_bblr" value="1">
                                                    <label class="form-check-label" for="r_bblr">Riwayat Bayi BBLR</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="keluarga_preeklampsia" id="r_kpe" value="1">
                                                    <label class="form-check-label" for="r_kpe">Keluarga dengan PE</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="interval_lebih_10" id="r_int" value="1">
                                                    <label class="form-check-label" for="r_int">Interval Hamil > 10 Thn</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-card rounded-xl bg-peka-primary text-white p-4 mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-info-circle fs-4 me-3"></i>
                            <h6 class="mb-0 fw-bold">Penting</h6>
                        </div>
                        <p class="small mb-4 opacity-75">Pastikan NIK dan Tanggal HPHT sudah benar karena akan digunakan sebagai basis perhitungan risiko dan akun portal pasien.</p>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-light fw-bold text-peka-primary py-3">
                                <i class="fas fa-save me-2"></i> SIMPAN & DAFTARKAN
                            </button>
                            <a href="{{ route('pasien.index') }}" class="btn btn-link text-white text-decoration-none small opacity-75">Batalkan Registrasi</a>
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
    .custom-switch .form-check-input { width: 2.5rem; height: 1.25rem; margin-right: 12px; cursor: pointer; }
    .custom-switch .form-check-label { padding-top: 2px; cursor: pointer; }
    .border-dashed { border-style: dashed !important; }
</style>
@endpush
