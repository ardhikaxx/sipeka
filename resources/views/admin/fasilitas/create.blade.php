@extends('layouts.app')

@section('title', 'Fasilitas Baru')
@section('page_title', 'Registrasi Fasilitas')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
    </a>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h5 class="section-title mb-1"><i class="fas fa-hospital-plus me-2 text-peka-primary"></i>Form Registrasi Fasilitas</h5>
        <p class="text-muted small">Tambahkan Puskesmas atau Rumah Sakit baru ke dalam jaringan SIPEKA.</p>
    </div>
    
    <form method="POST" action="{{ route('admin.fasilitas.store') }}">
        @csrf
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Nama Fasilitas Kesehatan</label>
                        <div class="position-relative">
                            <i class="fas fa-hospital-user input-icon"></i>
                            <input name="nama" class="form-control-peka" placeholder="Contoh: Puskesmas Jember Lor" value="{{ old('nama') }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Tipe Fasilitas</label>
                        <div class="position-relative">
                            <i class="fas fa-tags input-icon"></i>
                            <select name="tipe" class="form-control-peka" required>
                                <option value="" disabled selected>Pilih tipe...</option>
                                <option>Puskesmas</option>
                                <option>Polindes</option>
                                <option>Poskesdes</option>
                                <option>RSUD</option>
                                <option>RSIA</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-12"><hr class="divider-h opacity-50"></div>
                
                <div class="col-md-4">
                    <div class="input-group-peka">
                        <label class="form-label">Kecamatan</label>
                        <div class="position-relative">
                            <i class="fas fa-map-location-dot input-icon"></i>
                            <input name="kecamatan" class="form-control-peka" placeholder="Contoh: Patrang" value="{{ old('kecamatan') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group-peka">
                        <label class="form-label">Kabupaten / Kota</label>
                        <div class="position-relative">
                            <i class="fas fa-city input-icon"></i>
                            <input name="kabupaten" class="form-control-peka" placeholder="Contoh: Jember" value="{{ old('kabupaten', 'Jember') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group-peka">
                        <label class="form-label">Provinsi</label>
                        <div class="position-relative">
                            <i class="fas fa-map input-icon"></i>
                            <input name="provinsi" class="form-control-peka" placeholder="Contoh: Jawa Timur" value="{{ old('provinsi', 'Jawa Timur') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-light border-0 p-4 text-end">
            <button type="reset" class="btn btn-light border px-4 me-2 rounded-pill">Reset</button>
            <button type="submit" class="btn btn-peka-primary px-5 rounded-pill shadow-sm">
                <i class="fas fa-save me-2"></i> Simpan Fasilitas
            </button>
        </div>
    </form>
</div>
@endsection
