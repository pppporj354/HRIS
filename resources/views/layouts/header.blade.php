<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap shadow topbar">
    <a class="navbar-brand col-md-3 col-lg-2" href="{{ route('dashboard') }}">
        <i class="bi bi-grid-fill"></i> HRIS IGI
    </a>
    <button class="navbar-toggler d-md-none collapsed position-relative" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span
            class="position-absolute top-10 start-100 translate-middle p-2 bg-danger border border-light rounded-circle penanda-notifikasi d-none">
        </span>
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-md-block flex-fill">
        <div class="d-flex align-items-center justify-content-center">
            <span class="text-white opacity-75 small">
                {{ now()->format('l, d F Y') }}
            </span>
        </div>
    </div>

    <div class="navbar-nav ms-auto me-3">
        <div class="nav-item text-nowrap d-flex align-items-center">
            <div class="dropdown avatar-container position-relative">
                <span
                    class="position-absolute top-0 start-0 translate-middle p-1 bg-danger border border-light rounded-circle penanda-notifikasi d-none">
                </span>
                <a href="#" class="d-block text-decoration-none dropdown-toggle" id="dropdownUser1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar">
                        <img src="{{ Vite::asset('resources/assets/avatar.svg') }}" alt="User Avatar" width="24"
                            height="24">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="{{ route('profil.index') }}">
                            <i class="bi bi-person-badge"></i>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('notifikasi.index') }}">
                            <i class="bi bi-bell"></i>
                            <span>Notifikasi</span>
                            <span class="badge bg-danger ms-auto badge-notifikasi"></span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post" id="form-logout">
                            @csrf
                            <button class="dropdown-item" type="submit" id="logout-button">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
