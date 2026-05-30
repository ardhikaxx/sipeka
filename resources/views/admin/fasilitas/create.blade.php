@extends('layouts.app')

@section('title', 'Registrasi Fasilitas Baru')
@section('page_title', 'Registrasi Fasilitas')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <div class="mb-4">
            <a href="{{ route('admin.fasilitas.index') }}" class="text-decoration-none text-muted">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Fasilitas
            </a>
        </div>

        <div class="card border-0 shadow-card rounded-xl overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-3 px-md-4">
                <h5 class="section-title mb-1 d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary p-2 rounded-3 me-2 me-md-3">
                        <i class="fas fa-hospital-plus"></i>
                    </span>
                    Form Registrasi Fasilitas
                </h5>
                <p class="text-hint mb-0 ms-0 ms-md-5 ps-0 ps-md-2 small">Daftarkan unit pelayanan kesehatan baru</p>
            </div>
            
            <form method="POST" action="{{ route('admin.fasilitas.store') }}">
                @csrf
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3 g-md-4">
                        <!-- Informasi Dasar -->
                        <div class="col-12">
                            <h6 class="text-uppercase small fw-bold text-muted mb-3" style="letter-spacing: 0.1em;">Informasi Pelayanan</h6>
                            <div class="row g-3 g-md-4">
                                <div class="col-12 col-lg-7">
                                    <label class="form-label form-label-required fw-bold small">Nama Fasilitas Kesehatan</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-clinic-medical input-icon"></i>
                                        <input name="nama" class="form-control-peka @error('nama') is-invalid @enderror" placeholder="Contoh: RSUD Dr. Soebandi" value="{{ old('nama') }}" required>
                                    </div>
                                    @error('nama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-lg-5">
                                    <label class="form-label form-label-required fw-bold small">Tipe Fasilitas</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-tags input-icon"></i>
                                        <select name="tipe" class="form-control-peka @error('tipe') is-invalid @enderror" required>
                                            <option value="" disabled selected>Pilih tipe unit...</option>
                                            <option @selected(old('tipe') == 'Puskesmas')>Puskesmas</option>
                                            <option @selected(old('tipe') == 'Polindes')>Polindes</option>
                                            <option @selected(old('tipe') == 'Poskesdes')>Poskesdes</option>
                                            <option @selected(old('tipe') == 'RSUD')>RSUD</option>
                                            <option @selected(old('tipe') == 'RSIA')>RSIA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12"><hr class="divider-h opacity-50 my-2"></div>
                        
                        <!-- Lokasi -->
                        <div class="col-12">
                            <h6 class="text-uppercase small fw-bold text-muted mb-3" style="letter-spacing: 0.1em;">Lokasi & Wilayah Kerja</h6>
                            <div class="row g-3 g-md-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold small">Kecamatan</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-map-location-dot input-icon"></i>
                                        <input name="kecamatan" class="form-control-peka" placeholder="Wilayah kecamatan" value="{{ old('kecamatan') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold small">Kabupaten / Kota</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-city input-icon"></i>
                                        <input name="kabupaten" class="form-control-peka" placeholder="Contoh: Jember" value="{{ old('kabupaten', 'Jember') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold small">Provinsi</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-map input-icon"></i>
                                        <input name="provinsi" class="form-control-peka" placeholder="Contoh: Jawa Timur" value="{{ old('provinsi', 'Jawa Timur') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-light border-0 p-3 p-md-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                        <button type="reset" class="btn btn-light border px-4 order-2 order-sm-1">Reset</button>
                        <button type="submit" class="btn btn-peka-primary px-5 shadow-sm order-1 order-sm-2">
                            <i class="fas fa-save me-2"></i> Simpan Fasilitas
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="alert alert-info border-0 rounded-xl mt-4 d-flex align-items-center p-4">
            <i class="fas fa-info-circle fs-4 me-3"></i>
            <p class="small mb-0">Fasilitas yang didaftarkan akan muncul sebagai pilihan saat pembuatan akun tenaga medis dan formulir rujukan pasien.</p>
        </div>
    </div>
</div>
@endsection
