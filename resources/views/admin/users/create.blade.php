@extends('layouts.app')

@section('title', 'Registrasi Akun Baru')
@section('page_title', 'Registrasi Akun')

@section('content')
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <div class="mb-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Akun
            </a>
        </div>

        <div class="card border-0 shadow-card rounded-xl overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="section-title mb-1 d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    Form Registrasi Pengguna
                </h5>
                <p class="text-hint mb-0 ms-5 ps-2">Tambahkan tenaga medis atau admin baru ke dalam sistem SIPEKA</p>
            </div>
            
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Informasi Akun -->
                        <div class="col-md-7">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label form-label-required fw-bold">Nama Lengkap & Gelar</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-user-md input-icon"></i>
                                        <input name="name" class="form-control-peka @error('name') is-invalid @enderror" placeholder="Contoh: dr. Budi Santoso, Sp.OG" value="{{ old('name') }}" required>
                                    </div>
                                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label form-label-required fw-bold">Alamat Email (User ID)</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" name="email" class="form-control-peka @error('email') is-invalid @enderror" placeholder="email@sipeka.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-required fw-bold">Password Akun</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-key input-icon"></i>
                                        <input type="password" name="password" class="form-control-peka @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                                    </div>
                                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label form-label-required fw-bold">Role / Peran</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-user-tag input-icon"></i>
                                        <select name="role" class="form-control-peka @error('role') is-invalid @enderror" required>
                                            <option value="" disabled selected>Pilih hak akses...</option>
                                            <option value="admin" @selected(old('role') == 'admin')>Administrator Sistem</option>
                                            <option value="dokter" @selected(old('role') == 'dokter')>Dokter Spesialis (RS/Klinik)</option>
                                            <option value="bidan" @selected(old('role') == 'bidan')>Bidan / Tenaga Kesehatan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penempatan -->
                        <div class="col-md-5 border-start">
                            <div class="ps-md-3">
                                <label class="form-label fw-bold">Fasilitas Kesehatan Terkait</label>
                                <div class="input-group-peka mb-3">
                                    <i class="fas fa-hospital input-icon"></i>
                                    <select name="fasilitas_id" class="form-control-peka">
                                        <option value="">-- Tanpa Fasilitas (Admin Only) --</option>
                                        @foreach($fasilitas as $item)
                                        <option value="{{ $item->id }}" @selected(old('fasilitas_id') == $item->id)>{{ $item->nama }} ({{ $item->tipe }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="alert alert-info border-0 rounded-3 small">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Pilih fasilitas untuk membatasi akses data sesuai dengan wilayah kerja tenaga medis tersebut.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-light border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-hint small"><i class="fas fa-shield-halved me-1"></i> Data disimpan secara aman dan terenkripsi.</div>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-light border px-4">Reset</button>
                            <button type="submit" class="btn btn-peka-primary px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan & Daftarkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
