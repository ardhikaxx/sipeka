@php
  $role = auth()->user()?->role;
  $roleIcon = match ($role) {
      'admin' => 'fa-user-shield',
      'dokter' => 'fa-user-doctor',
      'pasien' => 'fa-person-pregnant',
      default => 'fa-user-nurse',
  };
@endphp

<aside class="sipeka-sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="sidebar-brand__logo">
      <i class="fas fa-heart-circle-plus"></i>
    </div>
    <div class="sidebar-brand__text">
      <span class="sidebar-brand__name">SIPEKA</span>
      <span class="sidebar-brand__sub">v1.0</span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="sidebar-nav__section">UTAMA</div>

    @if(in_array($role, ['admin', 'dokter', 'bidan'], true))
      <a href="{{ route('dashboard') }}" class="sidebar-nav__item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-grid-2"></i>
        <span>Dasbor</span>
      </a>
      <a href="{{ route('pasien.index') }}" class="sidebar-nav__item {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
        <i class="fas fa-users-line"></i>
        <span>{{ $role === 'dokter' ? 'Pasien Rujukan' : 'Data Pasien' }}</span>
      </a>
      <a href="{{ route('kunjungan.index') }}" class="sidebar-nav__item {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
        <i class="fas fa-stethoscope"></i>
        <span>Riwayat ANC</span>
      </a>
    @endif

    @if($role === 'pasien')
      <a href="{{ route('portal.index') }}" class="sidebar-nav__item {{ request()->routeIs('portal.*') ? 'active' : '' }}">
        <i class="fas fa-house-medical"></i>
        <span>Portal Saya</span>
      </a>
    @endif

    @if(in_array($role, ['admin', 'dokter', 'bidan'], true))
      <div class="sidebar-nav__section">LAYANAN</div>
      <a href="{{ route('rujukan.index') }}" class="sidebar-nav__item {{ request()->routeIs('rujukan.*') ? 'active' : '' }}">
        <i class="fas fa-ambulance"></i>
        <span>{{ $role === 'dokter' ? 'Rujukan Masuk' : 'Rujukan' }}</span>
      </a>
      @if(in_array($role, ['admin', 'bidan'], true))
        <a href="{{ route('darurat.index') }}" class="sidebar-nav__item {{ request()->routeIs('darurat.*') ? 'active' : '' }}">
          <i class="fas fa-triangle-exclamation"></i>
          <span>Laporan Darurat</span>
        </a>
      @endif
      <a href="{{ route('laporan.index') }}" class="sidebar-nav__item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i>
        <span>Laporan</span>
      </a>
    @endif

    @if($role === 'admin')
      <div class="sidebar-nav__section">ADMINISTRASI</div>
      <a href="{{ route('admin.users.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="fas fa-user-gear"></i>
        <span>Kelola Akun</span>
      </a>
      <a href="{{ route('admin.fasilitas.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
        <i class="fas fa-hospital"></i>
        <span>Fasilitas</span>
      </a>
      <a href="{{ route('admin.audit.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i>
        <span>Audit Log</span>
      </a>
    @endif

    <div class="sidebar-nav__section">EDUKASI</div>
    <a href="{{ route('edukasi.index') }}" class="sidebar-nav__item {{ request()->routeIs('edukasi.*') ? 'active' : '' }}">
      <i class="fas fa-book-medical"></i>
      <span>Konten Edukasi</span>
    </a>
    @if($role === 'admin')
      <a href="{{ route('admin.edukasi.create') }}" class="sidebar-nav__item {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}">
        <i class="fas fa-pen-to-square"></i>
        <span>Tambah Edukasi</span>
      </a>
    @endif
  </nav>

  <div class="sidebar-user">
    <div class="sidebar-user__avatar">
      <i class="fas {{ $roleIcon }}"></i>
    </div>
    <div class="sidebar-user__info">
      <div class="sidebar-user__name">{{ auth()->user()->name ?? 'Pengguna' }}</div>
      <div class="sidebar-user__role">{{ ucfirst($role ?? 'user') }}</div>
    </div>
  </div>
</aside>
