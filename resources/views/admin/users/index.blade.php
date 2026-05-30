@extends('layouts.app')

@section('title', 'Kelola Akun')
@section('page_title', 'Kelola Akun')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="section-title mb-1">Daftar Akun Pengguna</h5>
        <p class="text-muted small mb-0">Kelola akses untuk admin, dokter, bidan, dan ibu hamil dalam sistem.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-peka-primary shadow-sm">
        <i class="fas fa-user-plus me-2"></i> Buat Akun Baru
    </a>
</div>

<div class="card border-0 shadow-card rounded-xl">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Pengguna</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Peran</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Fasilitas Kerja</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Tgl Bergabung</th>
                        <th class="pe-4 py-3 border-0 text-muted small fw-bold text-uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-peka-primary-pale text-peka-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            @php
                                $roleClass = match($user->role) {
                                    'admin' => 'bg-dark',
                                    'dokter' => 'bg-primary',
                                    'bidan' => 'bg-success',
                                    'pasien' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $roleClass }} rounded-pill px-3" style="font-weight: 600; font-size: 0.75rem;">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 text-muted">
                            @if($user->fasilitas)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-hospital-user small opacity-50"></i>
                                    {{ $user->fasilitas->nama }}
                                </div>
                            @else
                                <span class="text-muted opacity-50">-</span>
                            @endif
                        </td>
                        <td class="py-3 text-muted small">
                            {{ $user->created_at->isoFormat('D MMMM YYYY') }}
                        </td>
                        <td class="pe-4 py-3 text-center">
                            <button class="btn btn-sm btn-light border p-1 px-2" title="Edit"><i class="fas fa-edit text-muted"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-users-slash d-block fs-2 mb-3 opacity-25"></i>
                                <div class="text-muted">Belum ada akun pengguna yang terdaftar.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
