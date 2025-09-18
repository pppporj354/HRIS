<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar sidebar-sticky collapse">
    <div class="position-sticky">
        @if (auth()->check() && auth()->user()->role == 'Administrator')
            <h6 class="sidebar-heading">
                <span>Administrator</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'datakaryawan.index') active @endif " aria-current="page"
                        href="{{ route('datakaryawan.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Data Karyawan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'daftarabsensi.index') active @endif"
                        href="{{ route('daftarabsensi.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>Daftar Absensi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'persetujuancuti.index') active @endif"
                        href="{{ route('persetujuancuti.index') }}">
                        <i class="bi bi-check2-circle"></i>
                        <span>Persetujuan Cuti</span>
                        @php
                            $totalPendingCuti = DB::table('cuti')->where('status_cuti', 'Menunggu Persetujuan')->count();
                        @endphp
                        @if($totalPendingCuti > 0)
                            <span class="ms-auto badge bg-danger">{{ $totalPendingCuti }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'penggajian.index' || request()->route()->getName() == 'penggajian.show') active @endif"
                        href="{{ route('penggajian.index') }}">
                        <i class="bi bi-cash"></i>
                        <span>Penggajian</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->route()->getName() == 'rekrutmen.index') active @endif"
                        href="{{ route('rekrutmen.index') }}">
                        <i class="bi bi-person-plus"></i>
                        <span>Rekrutmen</span>
                    </a>
                </li>
            </ul>
        @endif

        <h6 class="sidebar-heading">
            <span>Karyawan</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item ">
                <a class="nav-link @if (request()->route()->getName() == 'pengajuancuti.index') active @endif"
                    href="{{ route('pengajuancuti.index') }}">
                    <i class="bi bi-calendar-plus"></i>
                    <span>Pengajuan Cuti</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link @if (request()->route()->getName() == 'riwayatgaji.index') active @endif"
                    href="{{ route('riwayatgaji.index') }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Riwayat Gaji</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'riwayatabsensi.index') active @endif"
                    href="{{ route('riwayatabsensi.index') }}">
                    <i class="bi bi-calendar-date"></i>
                    <span>Riwayat Absensi</span>
                </a>
            </li>
        </ul>
        <h6 class="sidebar-heading">
            <span>Panduan</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'panduan') active @endif" href="{{ route('panduan') }}">
                    <i class="bi bi-info-circle"></i>
                    <span>Panduan Penggunaan</span>
                </a>
            </li>
        </ul>
        <h6 class="sidebar-heading d-md-none">
            <span>Panel Pengguna</span>
        </h6>
        <ul class="nav flex-column mb-2 d-md-none">
            <li class="nav-item">
                <a class="nav-link  @if (request()->route()->getName() == 'profil.index') active @endif" href="{{ route('profil.index') }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'notifikasi.index') active @endif"
                    href="{{ route('notifikasi.index') }}">
                    <i class="bi bi-bell"></i>
                    <span>Notifikasi</span>
                    <span class="ms-auto badge bg-danger badge-notifikasi"></span>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="form-logout">
                    @csrf
                    <button class="nav-link" type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </li>
        </ul>

    </div>
</nav>
