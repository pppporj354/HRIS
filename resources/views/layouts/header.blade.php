<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap shadow topbar">
    <a class="navbar-brand col-md-3 col-lg-2 fw-bold" href="{{ route('dashboard') }}">
        <i class="bi bi-grid-fill"></i>
        <span class="d-none d-sm-inline">HRIS IGI</span>
        <span class="d-inline d-sm-none">HRIS</span>
    </a>

    <!-- Mobile menu toggle with enhanced styling -->
    <button class="navbar-toggler d-md-none collapsed position-relative border-0 p-2" type="button"
            data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"
            id="sidebar-toggle">
        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle penanda-notifikasi d-none"></span>
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Enhanced date display -->
    <div class="d-none d-md-block flex-fill">
        <div class="d-flex align-items-center justify-content-center">
            <span class="text-white opacity-75 small fw-medium">
                <i class="bi bi-calendar-date me-1"></i>
                {{ now()->format('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- User navigation -->
    <div class="navbar-nav ms-auto me-2">
        <div class="nav-item text-nowrap d-flex align-items-center">
            <!-- Quick notifications for mobile -->
            <div class="d-md-none me-2">
                <a href="{{ route('notifikasi.index') }}" class="btn btn-sm btn-outline-light border-0 position-relative">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-notifikasi d-none">
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
            </div>

            <div class="dropdown avatar-container position-relative">
                <span class="position-absolute top-0 start-0 translate-middle p-1 bg-danger border border-light rounded-circle penanda-notifikasi d-none"></span>
                <a href="#" class="d-block text-decoration-none rounded-pill p-1" id="dropdownUser1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar">
                        <img src="{{ Vite::asset('resources/assets/avatar.svg') }}" alt="User Avatar" width="24"
                            height="24" class="rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="dropdownUser1">
                    <li class="px-3 py-2 bg-light">
                        <small class="text-muted fw-medium d-block">Selamat datang,</small>
                        <span class="fw-bold">{{ auth()->user()->username ?? 'User' }}</span>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('profil.index') }}">
                            <i class="bi bi-person-badge text-primary me-3"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li class="d-md-none">
                        <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('notifikasi.index') }}">
                            <i class="bi bi-bell text-warning me-3"></i>
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <span>Notifikasi</span>
                                <span class="badge bg-danger badge-notifikasi ms-auto"></span>
                            </div>
                        </a>
                    </li>
                    <li class="d-none d-md-block">
                        <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('notifikasi.index') }}">
                            <i class="bi bi-bell text-warning me-3"></i>
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <span>Notifikasi</span>
                                <span class="badge bg-danger badge-notifikasi ms-auto"></span>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="post" id="form-logout" class="mb-0">
                            @csrf
                            <button class="dropdown-item py-2 text-danger d-flex align-items-center w-100 border-0 bg-transparent" type="submit" id="logout-button">
                                <i class="bi bi-box-arrow-right me-3"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
