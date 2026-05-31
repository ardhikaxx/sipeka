<header class="sipeka-topbar shadow-sm">
  <div class="d-flex align-items-center gap-3">
    <button class="btn btn-light rounded-circle d-lg-none border-0 shadow-sm d-flex align-items-center justify-content-center btn-sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
      <i class="fas fa-bars text-peka-primary"></i>
    </button>
    <div class="d-flex flex-column">
      <h4 class="page-title mb-0">@yield('page_title', 'Dasbor')</h4>
      <span class="text-hint d-none d-md-block" style="font-size: 0.75rem;">Sistem Skrining Preeklampsia Terintegrasi</span>
    </div>
  </div>
  
  <div class="d-flex align-items-center gap-3 gap-md-4">
    <div class="topbar-action-btn topbar-notif position-relative" role="button" tabindex="0" title="Notifikasi">
      <i class="far fa-bell fs-5 text-gray-600"></i>
      <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle animate-pulse">
        <span class="visually-hidden">Notifikasi Baru</span>
      </span>
    </div>

    <div class="vr d-none d-sm-block opacity-25" style="height: 24px;"></div>
    
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark user-dropdown-toggle p-1 rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="d-none d-sm-flex flex-column text-end pe-1">
          <span class="fw-bold text-dark small" style="line-height: 1.2;">{{ auth()->user()->name ?? 'Pengguna' }}</span>
          <span class="text-muted" style="font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ auth()->user()->role ?? 'Akses Terbatas' }}</span>
        </div>
        <div class="avatar-circle bg-gradient-premium text-white shadow-sm d-flex align-items-center justify-content-center fw-bold border border-2 border-white" style="width: 38px; height: 38px; font-size: 1rem;">
          {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </div>
        <i class="fas fa-chevron-down text-muted ms-1 d-none d-sm-block" style="font-size: 0.7rem;"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-card border-0 mt-3 rounded-4 p-2 overflow-hidden" style="min-width: 220px;">
        <li class="p-3 bg-light rounded-3 mb-2 d-sm-none">
            <div class="fw-bold text-dark small">{{ auth()->user()->name ?? 'Pengguna' }}</div>
            <div class="text-muted" style="font-size: 0.65rem; font-weight: 600; text-transform: uppercase;">{{ auth()->user()->role ?? 'Akses Terbatas' }}</div>
        </li>
        <li>
            <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center gap-2 mb-1" href="#">
                <div class="icon-box-sm bg-primary-subtle text-primary rounded-circle"><i class="far fa-user"></i></div>
                <span class="small fw-medium">Profil Saya</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center gap-2 mb-2" href="#">
                <div class="icon-box-sm bg-secondary-subtle text-secondary rounded-circle"><i class="fas fa-sliders"></i></div>
                <span class="small fw-medium">Pengaturan</span>
            </a>
        </li>
        <li><hr class="dropdown-divider opacity-50 my-2"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item py-2 px-3 rounded-3 text-danger d-flex align-items-center gap-2 fw-bold">
                    <div class="icon-box-sm bg-danger-subtle text-danger rounded-circle"><i class="fas fa-arrow-right-from-bracket"></i></div>
                    <span class="small">Keluar Sistem</span>
                </button>
            </form>
        </li>
      </ul>
    </div>
  </div>
</header>
