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
            <div class="card-header bg-white border-0 pt-4 pb-0 px-3 px-md-4">
                <h5 class="section-title mb-1 d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary p-2 rounded-3 me-2 me-md-3">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    Form Registrasi Pengguna
                </h5>
                <p class="text-hint mb-0 ms-0 ms-md-5 ps-0 ps-md-2 small">Tambahkan tenaga medis atau admin baru</p>
            </div>
            
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="card-body p-3 p-md-4">
                    <div class="row g-4">
                        <!-- Informasi Akun -->
                        <div class="col-12 col-lg-7">
                            <div class="row g-3 g-md-4">
                                <div class="col-12">
                                    <label class="form-label form-label-required fw-bold small">Nama Lengkap & Gelar</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-user-md input-icon"></i>
                                        <input name="name" class="form-control-peka @error('name') is-invalid @enderror" placeholder="Contoh: dr. Budi Santoso, Sp.OG" value="{{ old('name') }}" required>
                                    </div>
                                    @error('name') <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label form-label-required fw-bold small">Alamat Email (User ID)</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" name="email" class="form-control-peka @error('email') is-invalid @enderror" placeholder="email@sipeka.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email') <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label form-label-required fw-bold small">Password</label>
                                    <div class="input-group-peka position-relative">
                                        <i class="fas fa-key input-icon"></i>
                                        <input type="password" id="password" name="password" class="form-control-peka @error('password') is-invalid @enderror" placeholder="Min. 8 karakter" style="padding-right: 45px;" required>
                                        <span class="toggle-password" onclick="togglePassword('password', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94A3B8; z-index: 10;">
                                          <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    @error('password') <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label form-label-required fw-bold small">Role / Peran</label>
                                    <div class="input-group-peka">
                                        <i class="fas fa-user-tag input-icon"></i>
                                        <select name="role" class="form-control-peka @error('role') is-invalid @enderror" required>
                                            <option value="" disabled selected>Pilih hak akses...</option>
                                            <option value="admin" @selected(old('role') == 'admin')>Administrator Sistem</option>
                                            <option value="dokter" @selected(old('role') == 'dokter')>Dokter Spesialis</option>
                                            <option value="bidan" @selected(old('role') == 'bidan')>Bidan / Nakes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penempatan -->
                        <div class="col-12 col-lg-5 border-lg-start">
                            <div class="ps-lg-4">
                                <label class="form-label fw-bold small">Fasilitas Kesehatan Terkait</label>
                                <div class="input-group-peka mb-3">
                                    <i class="fas fa-hospital input-icon"></i>
                                    <select name="fasilitas_id" class="form-control-peka">
                                        <option value="">-- Tanpa Fasilitas (Admin Only) --</option>
                                        @foreach($fasilitas as $item)
                                        <option value="{{ $item->id }}" @selected(old('fasilitas_id') == $item->id)>{{ $item->nama }} ({{ $item->tipe }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="alert alert-info border-0 rounded-3 small py-2 px-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Fasilitas membatasi akses data sesuai wilayah kerja.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-light border-0 p-3 p-md-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <div class="text-hint small text-center text-sm-start"><i class="fas fa-shield-halved me-1"></i> Data aman & terenkripsi.</div>
                        <div class="d-flex gap-2 w-100 w-sm-auto">
                            <button type="reset" class="btn btn-light border px-3 flex-fill flex-sm-grow-0">Reset</button>
                            <button type="submit" class="btn btn-peka-primary px-4 shadow-sm flex-fill flex-sm-grow-0">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconSpan) {
      const input = document.getElementById(inputId);
      const icon = iconSpan.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
</script>
@endpush
