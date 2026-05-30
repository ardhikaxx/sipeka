<header class="sipeka-topbar">
  <div class="d-flex align-items-center gap-3">
    <button class="btn btn-light d-lg-none" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
    <h4 class="page-title mb-0">@yield('page_title', 'Dasbor')</h4>
  </div>
  
  <div class="d-flex align-items-center gap-4">
    <div class="topbar-notif">
      <i class="fas fa-bell fs-5 text-secondary"></i>
      <span class="topbar-notif__dot"></span>
    </div>
    
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600;">
          {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
        <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-fw text-muted me-2"></i> Profil</a></li>
        <li><a class="dropdown-item" href="#"><i class="fas fa-gear fa-fw text-muted me-2"></i> Pengaturan</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger"><i class="fas fa-arrow-right-from-bracket fa-fw me-2"></i> Keluar</button>
            </form>
        </li>
      </ul>
    </div>
  </div>
</header>
