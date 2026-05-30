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
      <i class="fas fa-heart-pulse"></i>
    </div>
    <div class="sidebar-brand__text">
      <span class="sidebar-brand__name">SIPEKA</span>
      <span class="sidebar-brand__sub">PREMIUM SYSTEM</span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="sidebar-nav__section">UTAMA</div>

    @if(in_array($role, ['admin', 'dokter', 'bidan'], true))
      <a href="{{ route('dashboard') }}" class="sidebar-nav__item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-pie"></i>
        <span>Dasbor Statistik</span>
      </a>
      <a href="{{ route('pasien.index') }}" class="sidebar-nav__item {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
        <i class="fas fa-user-group"></i>
        <span>{{ $role === 'dokter' ? 'Pasien Rujukan' : 'Data Ibu Hamil' }}</span>
      </a>
      <a href="{{ route('kunjungan.index') }}" class="sidebar-nav__item {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
        <i class="fas fa-notes-medical"></i>
        <span>Riwayat ANC</span>
      </a>
    @endif

    @if($role === 'pasien')
      <a href="{{ route('portal.index') }}" class="sidebar-nav__item {{ request()->routeIs('portal.*') ? 'active' : '' }}">
        <i class="fas fa-house-medical"></i>
        <span>Dashboard Bunda</span>
      </a>
    @endif

    @if(in_array($role, ['admin', 'dokter', 'bidan'], true))
      <div class="sidebar-nav__section">PELAYANAN</div>
      <a href="{{ route('rujukan.index') }}" class="sidebar-nav__item {{ request()->routeIs('rujukan.*') ? 'active' : '' }}">
        <i class="fas fa-ambulance"></i>
        <span>{{ $role === 'dokter' ? 'Rujukan Masuk' : 'Manajemen Rujukan' }}</span>
      </a>
      @if(in_array($role, ['admin', 'bidan'], true))
        <a href="{{ route('darurat.index') }}" class="sidebar-nav__item {{ request()->routeIs('darurat.*') ? 'active' : '' }}">
          <i class="fas fa-hospital-user"></i>
          <span>Laporan Darurat</span>
          @php $emergencyCount = \App\Models\LaporanDarurat::where('status', 'Dikirim')->count(); @endphp
          @if($emergencyCount > 0)
            <span class="nav-badge">{{ $emergencyCount }}</span>
          @endif
        </a>
      @endif
      <a href="{{ route('laporan.index') }}" class="sidebar-nav__item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i>
        <span>Laporan & Grafik</span>
      </a>
    @endif

    @if($role === 'admin')
      <div class="sidebar-nav__section">ADMINISTRATOR</div>
      <a href="{{ route('admin.users.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="fas fa-user-gear"></i>
        <span>Kelola Akun Staf</span>
      </a>
      <a href="{{ route('admin.fasilitas.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
        <i class="fas fa-hospital"></i>
        <span>Jaringan Fasilitas</span>
      </a>
      <a href="{{ route('admin.audit.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
        <i class="fas fa-shield-halved"></i>
        <span>Log Aktivitas</span>
      </a>
    @endif

    <div class="sidebar-nav__section">EDUKASI</div>
    <a href="{{ route('edukasi.index') }}" class="sidebar-nav__item {{ request()->routeIs('edukasi.*') ? 'active' : '' }}">
      <i class="fas fa-book-medical"></i>
      <span>Pusat Edukasi</span>
    </a>
  </nav>

  <div class="sidebar-user">
    <div class="sidebar-user__avatar">
      <i class="fas {{ $roleIcon }}"></i>
    </div>
    <div class="sidebar-user__info">
      <div class="sidebar-user__name">{{ explode(' ', auth()->user()->name ?? 'Pengguna')[0] }}</div>
      <div class="sidebar-user__role">{{ $role === 'dokter' ? 'Dr. Spesialis' : ucfirst($role ?? 'Staf') }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="ms-auto">
        @csrf
        <button type="submit" class="btn btn-link p-0 text-white opacity-50 hover-opacity-100" title="Keluar">
            <i class="fas fa-power-off"></i>
        </button>
    </form>
  </div>
</aside>
