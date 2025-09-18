<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar sidebar-sticky pt-1 collapse">
    <div class="position-sticky">
        @if (auth()->check() && auth()->user()->role == 'Administrator')
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
                <span>Administrator</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'datakaryawan.index') active @endif " aria-current="page"
                        href="{{ route('datakaryawan.index') }}">
                        <i class="bi bi-person-lines-fill"></i>
                        Data Karyawan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'daftarabsensi.index') active @endif"
                        href="{{ route('daftarabsensi.index') }}">
                        <i class="bi bi-calendar-week"></i>
                        Daftar Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'persetujuancuti.index') active @endif"
                        href="{{ route('persetujuancuti.index') }}">
                        <i class="bi bi-hand-thumbs-up"></i>
                        Persetujuan Cuti
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'penggajian.index' || request()->route()->getName() == 'penggajian.show') active @endif"
                        href="{{ route('penggajian.index') }}">
                        <i class="bi bi-cash-coin"></i>
                        Penggajian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'rekrutmen.index') active @endif"
                        href="{{ route('rekrutmen.index') }}">
                        <i class="bi bi-file-earmark-person"></i>
                        Rekrutmen
                    </a>
                </li>
            </ul>
        @endif

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
            <span>Karyawan</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item ">
                <a class="nav-link @if (request()->route()->getName() == 'pengajuancuti.index') active @endif"
                    href="{{ route('pengajuancuti.index') }}">
                    <i class="bi bi-person-raised-hand"></i>
                    Pengajuan Cuti
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link @if (request()->route()->getName() == 'riwayatgaji.index') active @endif"
                    href="{{ route('riwayatgaji.index') }}">
                    <i class="bi bi-cash-coin"></i>
                    Riwayat Gaji
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'riwayatabsensi.index') active @endif"
                    href="{{ route('riwayatabsensi.index') }}">
                    <i class="bi bi-calendar-check"></i>
                    Riwayat Absensi
                </a>
            </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
            <span>Panduan</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'panduan') active @endif" href="{{ route('panduan') }}">
                    <i class="bi bi-info-circle"></i>
                    Panduan Penggunaan Aplikasi
                </a>
            </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted d-md-none">
            <span>Panel Pengguna</span>
        </h6>
        <ul class="nav flex-column mb-2 d-md-none">
            <li class="nav-item">
                <a class="nav-link  @if (request()->route()->getName() == 'profil.index') active @endif" href="{{ route('profil.index') }}">
                    <i class="bi bi-person-badge"></i>
                    Profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'notifikasi.index') active @endif"
                    href="{{ route('notifikasi.index') }}">
                    <i class="bi bi-bell"></i>
                    Notifikasi <span class="badge text-bg-danger badge-notifikasi"></span>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="form-logout">
                    @csrf
                    <button class="nav-link" type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                        Log Out
                    </button>
                </form>
            </li>
        </ul>

    </div>
</nav>
