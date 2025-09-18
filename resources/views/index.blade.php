@extends('layouts.app')

@section('css')
    {{-- This section contains all the custom CSS for this page. --}}
    <style>
        .main-content {
            overflow-x: hidden !important;
            padding: 1.5rem !important;
        }
        .dashboard-container {
            width: 100%;
        }
        .avatar {
            width: 48px;
            height: 48px;
            margin: 0;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 0.875rem;
        }
        .card {
            transition: all 0.2s ease-in-out;
            border: none;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
    </style>
@endsection

@section('content')
<div class="dashboard-container">
    {{-- Dashboard Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">{{ __('Dashboard') }}</h4>
            <p class="text-muted small mb-0">Selamat datang di HRIS PT. IGI</p>
        </div>
        <div class="text-end">
            <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>

    {{-- Session Status Alert --}}
    @if (session('status'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>
                    <strong>{{ session('status') }}</strong>
                    <small class="d-block">Sistem diperbarui terakhir pada {{ now()->format('d M Y, H:i') }}</small>
                </div>
            </div>
        </div>
    @endif

    @auth
        {{-- Check user role to display the correct dashboard view --}}
        @if (Auth::user()->role === 'Administrator')
            {{-- ============================================= --}}
            {{-- =========== ADMINISTRATOR DASHBOARD =========== --}}
            {{-- ============================================= --}}

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                {{-- Total Karyawan --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-primary bg-opacity-10 text-primary rounded">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $totaldatakaryawan ?? 0 }}</h3>
                                    <p class="text-muted small mb-0">Total Karyawan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pengajuan Cuti --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-success bg-opacity-10 text-success rounded">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $totalcuti ?? 0 }}</h3>
                                    <p class="text-muted small mb-0">Pengajuan Cuti</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Gaji Terbayar --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-info bg-opacity-10 text-info rounded">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">Rp {{ number_format($jumlahgajiterbayar ?? 0, 0, ',', '.') }}</h3>
                                    <p class="text-muted small mb-0">Total Gaji Terbayar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cuti Pending --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-warning bg-opacity-10 text-warning rounded">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                        // Calculates the number of pending leave requests
                                        $pendingCuti = \App\Models\Cuti::where('status_cuti', 'Menunggu Persetujuan')->count();
                                    @endphp
                                    <h3 class="mb-0">{{ $pendingCuti }}</h3>
                                    <p class="text-muted small mb-0">Cuti Pending</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('datakaryawan.index') }}" class="btn btn-outline-primary w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-person-plus d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Kelola Karyawan</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('persetujuancuti.index') }}" class="btn btn-outline-success w-100 p-3 position-relative d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-calendar-check d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Persetujuan Cuti</span>
                                @if($pendingCuti > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $pendingCuti }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                @endif
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('penggajian.index') }}" class="btn btn-outline-info w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-wallet2 d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Penggajian</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('absensi.index') }}" class="btn btn-outline-warning w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-clock d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Kelola Absensi</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- ======================================== --}}
            {{-- ============ EMPLOYEE DASHBOARD ============ --}}
            {{-- ======================================== --}}

            <!-- Employee Statistics -->
            <div class="row g-4 mb-4">
                {{-- Pengajuan Cuti Saya --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-success bg-opacity-10 text-success rounded">
                                    <i class="bi bi-calendar-plus"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0">{{ $pengajuancutiperkaryawan ?? 0 }}</h4>
                                    <small class="text-muted">Pengajuan Cuti Saya</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Total Gaji Diterima --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-info bg-opacity-10 text-info rounded">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0">Rp {{ number_format($gajiperkaryawan ?? 0, 0, ',', '.') }}</h4>
                                    <small class="text-muted">Total Gaji Diterima</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Hari Kehadiran --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary bg-opacity-10 text-primary rounded">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0">{{ $absensimasukperkaryawan ?? 0 }}</h4>
                                    <small class="text-muted">Hari Kehadiran</small>
                                    <div><small class="text-primary">Bulan ini</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Quick Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Menu Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('cuti.index') }}" class="btn btn-outline-primary w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-calendar-plus d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Ajukan Cuti</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('absensi.create') }}" class="btn btn-outline-success w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-clock-history d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Absensi</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('gaji.index') }}" class="btn btn-outline-info w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-wallet2 d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Riwayat Gaji</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning w-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-person-gear d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span>Profil Saya</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- ========================================= --}}
    {{-- =========== COMMON SECTION ============ --}}
    {{-- ========================================= --}}
    <!-- Recent Activities -->
    <div class="card shadow-sm">
        <div class="card-header bg-transparent border-0 pt-3">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru</h5>
        </div>
        <div class="card-body">
            @php
                // Prepare an array to hold recent activities
                $recentActivities = [];
                if (Auth::check()) {
                    if (Auth::user()->role === 'Administrator') {
                        // For Admins, fetch latest leave requests from all employees
                        $recentCuti = \App\Models\Cuti::with('dataKaryawan')->latest()->take(5)->get();
                        foreach ($recentCuti as $cuti) {
                            $recentActivities[] = [
                                'icon' => 'bi-calendar-plus',
                                'color' => $cuti->status_cuti === 'Disetujui' ? 'success' : ($cuti->status_cuti === 'Ditolak' ? 'danger' : 'warning'),
                                'title' => 'Pengajuan Cuti',
                                'description' => ($cuti->dataKaryawan->nama ?? 'Karyawan') . ' - ' . $cuti->status_cuti,
                                'time' => $cuti->created_at->diffForHumans()
                            ];
                        }
                    } else {
                        // For Employees, fetch their own activities
                        $datakaryawan = \App\Models\DataKaryawan::where('user_id', Auth::id())->first();
                        if ($datakaryawan) {
                            $myCuti = \App\Models\Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)->latest()->take(3)->get();
                            foreach ($myCuti as $cuti) {
                                $recentActivities[] = [
                                    'icon' => 'bi-calendar-plus',
                                    'color' => $cuti->status_cuti === 'Disetujui' ? 'success' : ($cuti->status_cuti === 'Ditolak' ? 'danger' : 'warning'),
                                    'title' => 'Cuti Anda',
                                    'description' => 'Status: ' . $cuti->status_cuti,
                                    'time' => $cuti->created_at->diffForHumans()
                                ];
                            }
                            $myAbsensi = \App\Models\Absensi::where('data_karyawan_id', $datakaryawan->id_data_karyawan)->latest()->take(2)->get();
                            foreach ($myAbsensi as $absensi) {
                                $recentActivities[] = [
                                    'icon' => 'bi-clock',
                                    'color' => 'info',
                                    'title' => 'Absensi',
                                    'description' => $absensi->status_absensi . ' - ' . \Carbon\Carbon::parse($absensi->tanggal_absensi)->format('d/m/Y'),
                                    'time' => $absensi->created_at->diffForHumans()
                                ];
                            }
                        }
                    }
                }
            @endphp

            {{-- Display activities if any exist, otherwise show a message --}}
            @forelse($recentActivities as $activity)
                <div class="d-flex align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="avatar-sm bg-{{ $activity['color'] }} bg-opacity-10 text-{{ $activity['color'] }} rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="bi {{ $activity['icon'] }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 small">{{ $activity['title'] }}</h6>
                        <small class="text-muted">{{ $activity['description'] }}</small>
                    </div>
                    <small class="text-muted text-nowrap">{{ $activity['time'] }}</small>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                    <h6 class="text-muted">Belum Ada Aktivitas</h6>
                    <p class="text-muted small mb-0">Aktivitas sistem akan ditampilkan di sini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
