@extends('layouts.app')
@section('css')
    <style>
        /* Dashboard-specific overrides can be placed here if needed */
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 mt-4 mb-4">
            <div class="dashboard-header mb-4">
                <h3 class="mb-0 fw-bold">{{ __('Dashboard') }}</h3>
                <p class="text-muted mb-0">Selamat datang di Sistem Informasi Sumber Daya Manusia</p>
            </div>
            <div class="dashboard-card">
                <div class="card-body" style="overflow-x: auto;">
                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                <div>
                                    <h6 class="mb-0">{{ session('status') }}</h6>
                                    <small>Sistem diperbarui terakhir pada {{ now()->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h5 class="dashboard-section-title">Ringkasan</h5>
                    @auth
                        @if (Auth::user()->hasRole('Administrator'))
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Pengajuan Cuti</span>
                                                <span class="icon-wrap"><i class="bi bi-calendar-plus card-icon"></i></span>
                                            </div>
                                            <div class="value">{{ $totalcuti }}</div>
                                            @php
                                                $cutiPending = DB::table('cuti')->where('status_cuti', 'Menunggu Persetujuan')->count();
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="trend positive" data-bs-toggle="tooltip" data-bs-placement="top" title="Permintaan cuti yang menunggu persetujuan">
                                                    <i class="bi bi-clock"></i>
                                                    <span>{{ $cutiPending }} menunggu persetujuan</span>
                                                </div>
                                                <div class="trend-period">Bulan ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Total Gaji Dibayarkan</span>
                                                <span class="icon-wrap"><i class="bi bi-wallet2 card-icon"></i></span>
                                            </div>
                                            <div class="value">{{ $jumlahgajiterbayar }}</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="trend positive" data-bs-toggle="tooltip" data-bs-placement="top" title="Pembayaran gaji dilakukan tepat waktu">
                                                    <i class="bi bi-graph-up-arrow"></i>
                                                    <span>Tepat waktu</span>
                                                </div>
                                                <div class="trend-period">Bulan ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Jumlah Karyawan</span>
                                                <span class="icon-wrap"><i class="bi bi-people card-icon"></i></span>
                                            </div>
                                            <div class="value">{{ $totaldatakaryawan }}</div>
                                            @php
                                                $activeEmployees = DB::table('data_karyawan')->where('status_karyawan', 'Karyawan Tetap')->count();
                                                $percentActive = $totaldatakaryawan > 0 ? round(($activeEmployees / $totaldatakaryawan) * 100) : 0;
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="trend positive" data-bs-toggle="tooltip" data-bs-placement="top" title="Persentase karyawan aktif dari total karyawan">
                                                    <i class="bi bi-person-check"></i>
                                                    <span>{{ $percentActive }}% aktif</span>
                                                </div>
                                                <div class="trend-period">Status saat ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                    @auth
                        @if (Auth::user()->hasRole('Employee'))
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Jumlah Cuti yang Diajukan</span>
                                                <span class="icon-wrap"><i class="bi bi-calendar-plus card-icon"></i></span>
                                            </div>
                                            <div class="value" id="pengajuanCuti">{{ $pengajuancutiperkaryawan }}</div>
                                            @php
                                                $userId = Auth::id();
                                                $approvedCuti = DB::table('cuti')->where('user_id', $userId)->where('status_cuti', 'Disetujui')->count();
                                                $percentApproved = $pengajuancutiperkaryawan > 0 ? round(($approvedCuti / $pengajuancutiperkaryawan) * 100) : 0;
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="trend {{ $percentApproved >= 50 ? 'positive' : 'negative' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Persentase pengajuan cuti yang disetujui">
                                                    <i class="bi {{ $percentApproved >= 50 ? 'bi-check-circle' : 'bi-clock' }}"></i>
                                                    <span>{{ $percentApproved }}% disetujui</span>
                                                </div>
                                                <div class="trend-period">Tahun ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Total Gaji Diterima</span>
                                                <span class="icon-wrap"><i class="bi bi-wallet2 card-icon"></i></span>
                                            </div>
                                            <div class="value" id="totalGaji">{{ $gajiperkaryawan }}</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="trend positive" data-bs-toggle="tooltip" data-bs-placement="top" title="Status pembayaran gaji terbaru">
                                                    <i class="bi bi-calendar-check"></i>
                                                    <span>Gaji terbaru</span>
                                                </div>
                                                <div class="trend-period">Bulan ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Jumlah Kehadiran</span>
                                                <span class="icon-wrap"><i class="bi bi-calendar-date card-icon"></i></span>
                                            </div>
                                            <div class="value" id="jumlahKehadiran">{{ $absensimasukperkaryawan }} Hari</div>
                                            @php
                                                $currentMonth = date('n');
                                                $workingDays = 20; // Approximate working days per month
                                                $percentAttendance = $workingDays > 0 ? min(100, round(($absensimasukperkaryawan / $workingDays) * 100)) : 0;
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="trend {{ $percentAttendance >= 90 ? 'positive' : 'negative' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Persentase kehadiran dari total hari kerja">
                                                    <i class="bi {{ $percentAttendance >= 90 ? 'bi-graph-up-arrow' : 'bi-exclamation-circle' }}"></i>
                                                    <span>{{ $percentAttendance }}% kehadiran</span>
                                                </div>
                                                <div class="trend-period">Bulan ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    <!-- Activity Feed Section -->
                    @auth
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                <h5 class="dashboard-section-title mb-0">Aktivitas Terkini</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-clock-history me-1"></i> Semua Aktivitas
                                </a>
                            </div>
                            <div class="col-md-12">
                                <div class="dashboard-card">
                                    <div class="card-body">
                                        @php
                                            // Get recent activities based on user role
                                            $activities = [];

                                            try {
                                                if (Auth::user()->hasRole('Administrator')) {
                                                    // Admin activities

                                                    // Get latest cuti requests
                                                    $latestCuti = DB::table('cuti')
                                                        ->join('data_karyawan', 'cuti.user_id', '=', 'data_karyawan.user_id')
                                                        ->select('cuti.*', 'data_karyawan.nama')
                                                        ->orderBy('cuti.created_at', 'desc')
                                                        ->limit(2)
                                                        ->get();                                                foreach ($latestCuti as $cuti) {
                                                    $activities[] = [
                                                        'icon' => 'bi-calendar-plus',
                                                        'title' => 'Pengajuan   cuti dari ' . $cuti->nama,
                                                        'time' => \Carbon\Carbon::parse($cuti->created_at)->diffForHumans(),
                                                        'status' => 'primary'
                                                    ];
                                                }

                                                // Get latest salary payments
                                                $latestPayments = DB::table('gaji')
                                                    ->orderBy('created_at', 'desc')
                                                    ->limit(1)
                                                    ->get();

                                                foreach ($latestPayments as $payment) {
                                                    $activities[] = [
                                                        'icon' => 'bi-cash',
                                                        'title' => 'Pembayaran gaji periode ' . $payment->tanggal_pembayaran,
                                                        'time' => \Carbon\Carbon::parse($payment->created_at)->diffForHumans(),
                                                        'status' => 'success'
                                                    ];
                                                }

                                            } else {
                                                // Employee activities
                                                $userId = Auth::id();

                                                // Get employee's latest leave requests
                                                try {
                                                    $myLatestCuti = DB::table('cuti')
                                                        ->where('user_id', $userId)
                                                        ->orderBy('created_at', 'desc')
                                                        ->limit(2)
                                                        ->get();                                                foreach ($myLatestCuti as $cuti) {
                                                    $statusIcon = 'bi-hourglass';
                                                    $statusClass = 'warning';

                                                    if ($cuti->status_cuti == 'Disetujui') {
                                                        $statusIcon = 'bi-check-circle';
                                                        $statusClass = 'success';
                                                    } elseif ($cuti->status_cuti == 'Ditolak') {
                                                        $statusIcon = 'bi-x-circle';
                                                        $statusClass = 'danger';
                                                    }

                                                    $activities[] = [
                                                        'icon' => $statusIcon,
                                                        'title' => 'Pengajuan cuti anda ' . strtolower($cuti->status_cuti),
                                                        'time' => \Carbon\Carbon::parse($cuti->created_at)->diffForHumans(),
                                                        'status' => $statusClass
                                                    ];
                                                }

                                                // Get employee's latest attendance
                                                $latestAttendance = DB::table('absensi')
                                                    ->where('user_id', $userId)
                                                    ->orderBy('created_at', 'desc')
                                                    ->limit(1)
                                                    ->first();

                                                if ($latestAttendance) {
                                                    $activities[] = [
                                                        'icon' => 'bi-check2-square',
                                                        'title' => 'Anda absen pada ' . $latestAttendance->tanggal_absensi,
                                                        'time' => \Carbon\Carbon::parse($latestAttendance->created_at)->diffForHumans(),
                                                        'status' => 'info'
                                                    ];
                                                }
                                                } catch (\Exception $e) {
                                                    // Log error but don't crash the page
                                                    $activities[] = [
                                                        'icon' => 'bi-exclamation-triangle',
                                                        'title' => 'Terjadi kesalahan saat memuat aktivitas',
                                                        'time' => 'Silakan refresh halaman',
                                                        'status' => 'warning'
                                                    ];
                                                }
                                            }                                            // If no activities found, add a placeholder
                                            if (empty($activities)) {
                                                $activities[] = [
                                                    'icon' => 'bi-info-circle',
                                                    'title' => 'Belum ada aktivitas terbaru',
                                                    'time' => 'Saat ini',
                                                    'status' => 'secondary'
                                                ];
                                            }

                                            } catch (\Exception $e) {
                                                // Log error but don't crash the page
                                                // Add fallback activity item
                                                $activities[] = [
                                                    'icon' => 'bi-exclamation-triangle',
                                                    'title' => 'Terjadi kesalahan saat memuat aktivitas',
                                                    'time' => 'Silakan refresh halaman',
                                                    'status' => 'warning'
                                                ];
                                            }
                                        @endphp

                                        <ul class="activity-feed">
                                            @foreach($activities as $activity)
                                            <li class="activity-feed-item">
                                                <div class="activity-feed-icon bg-light text-{{ $activity['status'] }}">
                                                    <i class="bi {{ $activity['icon'] }}"></i>
                                                </div>
                                                <div class="activity-feed-content">
                                                    <div class="activity-feed-title">{{ $activity['title'] }}</div>
                                                    <div class="activity-feed-time">{{ $activity['time'] }}</div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>

                                        <p class="text-center text-muted mt-3 small d-md-none">
                                            <i class="bi bi-arrow-left-right me-1"></i> Geser untuk melihat lebih banyak aktivitas
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
