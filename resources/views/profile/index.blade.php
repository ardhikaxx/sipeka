@extends('layouts.app')

@section('title', 'Profil Pengguna')
@section('page_title', 'Profil Pengguna')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-4">
        <!-- Profile Card -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <div class="card-header bg-gradient-premium p-5 text-center position-relative">
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge bg-white text-peka-primary rounded-pill px-3 py-2 fw-bold shadow-sm" style="font-size: 0.7rem;">
                        {{ strtoupper($user->role) }}
                    </span>
                </div>
                <div class="avatar-xxl bg-white text-peka-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg mb-3 mt-4" style="width: 100px; height: 100px; font-size: 2.5rem; border: 4px solid rgba(255,255,255,0.2);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold text-white mb-1">{{ $user->name }}</h5>
                <div class="text-white-50 small">{{ $user->email }}</div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border border-white shadow-sm">
                        <div class="icon-box-sm bg-primary-subtle text-primary rounded-circle flex-shrink-0"><i class="fas fa-hospital-user"></i></div>
                        <div class="grow">
                            <div class="text-hint x-small uppercase-font mb-1">FASILITAS KERJA</div>
                            <div class="fw-bold text-dark small">{{ $user->fasilitas?->nama ?? 'Sistem Pusat (Global)' }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border border-white shadow-sm">
                        <div class="icon-box-sm bg-success-subtle text-success rounded-circle flex-shrink-0"><i class="fas fa-calendar-check"></i></div>
                        <div class="grow">
                            <div class="text-hint x-small uppercase-font mb-1">TANGGAL BERGABUNG</div>
                            <div class="fw-bold text-dark small">{{ $user->created_at->format('d F Y') }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border border-white shadow-sm">
                        <div class="icon-box-sm bg-info-subtle text-info rounded-circle flex-shrink-0"><i class="fas fa-user-check"></i></div>
                        <div class="grow">
                            <div class="text-hint x-small uppercase-font mb-1">STATUS AKUN</div>
                            <div class="fw-bold text-dark small">Aktif & Terverifikasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <!-- Edit Profile Form -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="section-title mb-1 d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                        <i class="fas fa-user-edit"></i>
                    </span>
                    Informasi Pribadi
                </h5>
                <p class="text-hint ms-5 ps-2 mb-0">Perbarui data diri dan preferensi akun Anda.</p>
            </div>
            <div class="card-body p-4">
                <form action="#" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <div class="input-group-peka">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control-peka" value="{{ $user->name }}" placeholder="Nama Lengkap">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold small">Alamat Email</label>
                            <div class="input-group-peka">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-control-peka" value="{{ $user->email }}" readonly style="background-color: var(--gray-100); cursor: not-allowed;">
                            </div>
                            <div class="form-text x-small text-muted mt-1"><i class="fas fa-lock me-1"></i> Email digunakan untuk login, tidak dapat diubah.</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold small">Nomor Telepon</label>
                            <div class="input-group-peka">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text" class="form-control-peka" placeholder="0812...">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold small">Pekerjaan / Spesialisasi</label>
                            <div class="input-group-peka">
                                <i class="fas fa-briefcase input-icon"></i>
                                <input type="text" class="form-control-peka" value="{{ ucfirst($user->role) }}" readonly style="background-color: var(--gray-100); cursor: not-allowed;">
                            </div>
                        </div>
                        <div class="col-12 text-end mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-peka-primary px-4 py-2 rounded-pill shadow-sm" onclick="Toast.fire({icon: 'info', title: 'Fitur simpan profil segera hadir!'})">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Card -->
        <div class="card border-0 shadow-card rounded-xl overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="section-title mb-1 d-flex align-items-center">
                    <span class="bg-danger-subtle text-danger p-2 rounded-3 me-3">
                        <i class="fas fa-shield-halved"></i>
                    </span>
                    Keamanan Akun
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 border mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box-sm bg-white border shadow-sm rounded-circle"><i class="fas fa-key text-secondary"></i></div>
                        <div>
                            <div class="fw-bold text-dark small">Kata Sandi Akun</div>
                            <div class="text-hint x-small">Terakhir diubah: Belum pernah</div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="Toast.fire({icon: 'info', title: 'Fitur ubah sandi segera hadir!'})">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
