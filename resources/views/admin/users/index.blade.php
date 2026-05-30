@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Akun')

@section('content')
<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-0 shadow-sm">
            <div>
                <div class="stat-card__number fs-4">{{ $stats['total'] }}</div>
                <div class="stat-card__label small">Total Petugas</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="text-primary">
                <div class="stat-card__number fs-4">{{ $stats['dokter'] }}</div>
                <div class="stat-card__label small">Dokter/RS</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card border-0 shadow-sm">
            <div class="text-success">
                <div class="stat-card__number fs-4">{{ $stats['bidan'] }}</div>
                <div class="stat-card__label small">Bidan</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a href="{{ route('admin.users.create') }}" class="btn btn-peka-primary w-100 py-3 shadow-sm rounded-xl">
            <i class="fas fa-user-plus me-1"></i> User Baru
        </a>
    </div>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-header bg-white py-3 py-md-4 px-3 px-md-4 border-bottom-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="section-title mb-1">Daftar Akun Pengguna</h5>
                <p class="text-hint mb-0">Kelola akses petugas sistem</p>
            </div>
            <div class="input-group-peka w-100" style="max-width: 350px;">
                <i class="fas fa-search input-icon"></i>
                <input type="text" class="form-control-peka" placeholder="Cari nama atau email...">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted uppercase-font" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-3 ps-md-4">PENGGUNA</th>
                        <th>PERAN</th>
                        <th>FASILITAS</th>
                        <th class="d-none d-md-table-cell">BERGABUNG</th>
                        <th class="pe-3 pe-md-4 text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-3 ps-md-4 py-3">
                            <div class="d-flex align-items-center gap-2 gap-md-3">
                                <div class="bg-peka-primary-pale text-peka-primary rounded-circle d-none d-sm-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">{{ $user->name }}</div>
                                    <div class="text-hint x-small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $roleBadge = match($user->role) {
                                    'admin' => 'bg-dark',
                                    'dokter' => 'bg-primary',
                                    'bidan' => 'bg-success',
                                    'pasien' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $roleBadge }} rounded-pill px-2 py-1" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.02em;">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->fasilitas)
                                <div class="fw-medium text-dark x-small">{{ $user->fasilitas->nama }}</div>
                                <div class="text-hint x-small d-none d-sm-block">{{ $user->fasilitas->tipe }}</div>
                            @else
                                <span class="text-muted opacity-50">-</span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            <div class="text-dark small fw-medium">{{ $user->created_at->format('d M Y') }}</div>
                            <div class="text-hint x-small">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="pe-3 pe-md-4 text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-edit me-2 text-primary"></i> Edit Akun</a></li>
                                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-key me-2 text-warning"></i> Reset Password</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Hapus</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-users-slash fa-3x text-light mb-3"></i>
                                <h6 class="text-muted">Tidak ada data pengguna.</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-top">
            {{ $users->links('partials.pagination-numbers') }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .uppercase-font { font-family: var(--font-heading); font-weight: 700; color: var(--gray-500); }
    .x-small { font-size: 0.7rem; }
    .dropdown-item { font-size: 0.8125rem; font-weight: 500; }
</style>
@endpush
