@extends('layouts.app')

@section('title', 'Akun Baru')
@section('page_title', 'Registrasi Akun')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
    </a>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h5 class="section-title mb-1"><i class="fas fa-user-plus me-2 text-peka-primary"></i>Form Registrasi Akun</h5>
        <p class="text-muted small">Lengkapi data di bawah ini untuk menambahkan pengguna baru ke sistem.</p>
    </div>
    
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Nama Lengkap</label>
                        <div class="position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input name="name" class="form-control-peka" placeholder="Contoh: Bdn. Siti Aminah" value="{{ old('name') }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Alamat Email</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control-peka" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Password</label>
                        <div class="position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="form-control-peka" placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group-peka">
                        <label class="form-label form-label-required">Peran (Role)</label>
                        <div class="position-relative">
                            <i class="fas fa-user-tag input-icon"></i>
                            <select name="role" class="form-control-peka" required>
                                <option value="" disabled selected>Pilih peran...</option>
                                <option value="admin">Administrator</option>
                                <option value="dokter">Dokter Spesialis / RS</option>
                                <option value="bidan">Bidan / Nakes</option>
                                <option value="pasien">Pasien (Ibu Hamil)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group-peka">
                        <label class="form-label">Fasilitas Kesehatan Terkait</label>
                        <div class="position-relative">
                            <i class="fas fa-hospital input-icon"></i>
                            <select name="fasilitas_id" class="form-control-peka">
                                <option value="">Tanpa Fasilitas (Hanya untuk Admin)</option>
                                @foreach($fasilitas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->tipe }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-hint mt-2">Pilih fasilitas kesehatan tempat pengguna ini bertugas.</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-light border-0 p-4 text-end">
            <button type="reset" class="btn btn-light border px-4 me-2 rounded-pill">Reset</button>
            <button type="submit" class="btn btn-peka-primary px-5 rounded-pill shadow-sm">
                <i class="fas fa-save me-2"></i> Simpan Akun
            </button>
        </div>
    </form>
</div>
@endsection
