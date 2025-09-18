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

                    <!-- Quick Actions Section for Admin -->
                    @auth
                        @if (Auth::user()->hasRole('Administrator'))
                            <div class="row mt-4">
                                <div class="col-12 mb-3">
                                    <h5 class="dashboard-section-title mb-0">Aksi Cepat</h5>
                                    <p class="text-muted small mb-0">Tugas administrasi yang memerlukan perhatian</p>
                                </div>

                                <!-- Pending Leave Approvals -->
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="quick-action-card">
                                        <div class="card-body text-center">
                                            <div class="quick-action-icon bg-warning text-white mb-3">
                                                <i class="bi bi-calendar-check"></i>
                                            </div>
                                            <h6 class="quick-action-title">Persetujuan Cuti</h6>
                                            <div class="quick-action-count mb-2">
                                                @if(isset($adminAnalytics['pendingApprovals']['leave_requests']))
                                                    <span class="badge bg-warning fs-6">{{ $adminAnalytics['pendingApprovals']['leave_requests'] }}</span>
                                                @else
                                                    <span class="badge bg-warning fs-6" id="pendingLeaveCount">0</span>
                                                @endif
                                            </div>
                                            <p class="text-muted small mb-3">Pengajuan menunggu persetujuan</p>
                                            <a href="{{ route('persetujuancuti.index') }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-eye me-1"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payroll Processing -->
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="quick-action-card">
                                        <div class="card-body text-center">
                                            <div class="quick-action-icon bg-success text-white mb-3">
                                                <i class="bi bi-wallet2"></i>
                                            </div>
                                            <h6 class="quick-action-title">Penggajian</h6>
                                            <div class="quick-action-count mb-2">
                                                @if(isset($adminAnalytics['pendingApprovals']['payroll_pending']))
                                                    <span class="badge bg-success fs-6">{{ $adminAnalytics['pendingApprovals']['payroll_pending'] }}</span>
                                                @else
                                                    <span class="badge bg-success fs-6" id="pendingPayrollCount">0</span>
                                                @endif
                                            </div>
                                            <p class="text-muted small mb-3">Gaji belum dibayarkan</p>
                                            <a href="{{ route('penggajian.index') }}" class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-currency-dollar me-1"></i> Kelola Gaji
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Employee Management -->
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="quick-action-card">
                                        <div class="card-body text-center">
                                            <div class="quick-action-icon bg-primary text-white mb-3">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <h6 class="quick-action-title">Kelola Karyawan</h6>
                                            <div class="quick-action-count mb-2">
                                                <span class="badge bg-primary fs-6">{{ $totaldatakaryawan }}</span>
                                            </div>
                                            <p class="text-muted small mb-3">Total karyawan aktif</p>
                                            <a href="{{ route('datakaryawan.index') }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-person-plus me-1"></i> Kelola Data
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reports & Analytics -->
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="quick-action-card">
                                        <div class="card-body text-center">
                                            <div class="quick-action-icon bg-info text-white mb-3">
                                                <i class="bi bi-graph-up"></i>
                                            </div>
                                            <h6 class="quick-action-title">Laporan</h6>
                                            <div class="quick-action-count mb-2">
                                                <span class="badge bg-info fs-6"><i class="bi bi-file-earmark-text"></i></span>
                                            </div>
                                            <p class="text-muted small mb-3">Analisis & laporan</p>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-download me-1"></i> Export
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="exportReport('attendance')">
                                                        <i class="bi bi-calendar-date me-2"></i> Laporan Absensi
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="exportReport('payroll')">
                                                        <i class="bi bi-wallet2 me-2"></i> Laporan Penggajian
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="exportReport('employees')">
                                                        <i class="bi bi-people me-2"></i> Data Karyawan
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="exportReport('leave')">
                                                        <i class="bi bi-calendar-x me-2"></i> Laporan Cuti
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- System Status Cards -->
                            <div class="row mt-2">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="status-card border-start border-4 border-success">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="card-title mb-1">Tingkat Kehadiran</h6>
                                                    <p class="text-muted small mb-0">Rata-rata bulan ini</p>
                                                </div>
                                                <div class="text-end">
                                                    <div class="h5 mb-0 text-success" id="avgAttendanceRate">--%</div>
                                                    <small class="text-muted">dari target 95%</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="status-card border-start border-4 border-warning">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="card-title mb-1">Pengajuan Cuti</h6>
                                                    <p class="text-muted small mb-0">Bulan ini</p>
                                                </div>
                                                <div class="text-end">
                                                    <div class="h5 mb-0 text-warning" id="monthlyLeaveRequests">--</div>
                                                    <small class="text-muted">pengajuan</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="status-card border-start border-4 border-info">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="card-title mb-1">Pengeluaran Gaji</h6>
                                                    <p class="text-muted small mb-0">Bulan ini</p>
                                                </div>
                                                <div class="text-end">
                                                    <div class="h6 mb-0 text-info" id="monthlyPayrollAmount">Rp --</div>
                                                    <small class="text-muted">total dibayar</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    <!-- Employee Personal Dashboard -->
                    @auth
                        @if (Auth::user()->hasRole('Employee'))
                            <div class="row mt-4">
                                <div class="col-12 mb-3">
                                    <h5 class="dashboard-section-title mb-0">Dashboard Personal</h5>
                                    <p class="text-muted small mb-0">Informasi personal dan aktivitas Anda</p>
                                </div>

                                <!-- Leave Balance Card -->
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="employee-widget-card">
                                        <div class="card-body">
                                            <div class="widget-header">
                                                <div class="widget-icon bg-primary">
                                                    <i class="bi bi-calendar-heart"></i>
                                                </div>
                                                <div>
                                                    <h6 class="widget-title">Saldo Cuti</h6>
                                                    <p class="text-muted small mb-0">Tahun {{ date('Y') }}</p>
                                                </div>
                                            </div>
                                            
                                            @if(isset($employeeAnalytics['leaveBalance']))
                                                @php
                                                    $leaveBalance = $employeeAnalytics['leaveBalance'];
                                                    $annualLeave = 12; // Standard annual leave days
                                                    $usedLeave = $leaveBalance['approved'];
                                                    $remainingLeave = $annualLeave - $usedLeave;
                                                @endphp
                                                
                                                <div class="leave-progress mt-3">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="small text-muted">Tersisa</span>
                                                        <span class="small font-weight-bold">{{ $remainingLeave }}/{{ $annualLeave }} hari</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" 
                                                             style="width: {{ ($remainingLeave / $annualLeave) * 100 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="leave-stats mt-3">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="leave-stat">
                                                                <div class="stat-number text-success">{{ $leaveBalance['approved'] }}</div>
                                                                <div class="stat-label">Disetujui</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="leave-stat">
                                                                <div class="stat-number text-warning">{{ $leaveBalance['pending'] }}</div>
                                                                <div class="stat-label">Pending</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="leave-stat">
                                                                <div class="stat-number text-danger">{{ $leaveBalance['rejected'] }}</div>
                                                                <div class="stat-label">Ditolak</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center py-3">
                                                    <div class="h4 text-primary">12</div>
                                                    <p class="text-muted small mb-0">Hari cuti tersedia</p>
                                                </div>
                                            @endif

                                            <div class="mt-3">
                                                <a href="{{ route('cuti.create') }}" class="btn btn-primary btn-sm w-100">
                                                    <i class="bi bi-plus-circle me-1"></i> Ajukan Cuti Baru
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Summary Card -->
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="employee-widget-card">
                                        <div class="card-body">
                                            <div class="widget-header">
                                                <div class="widget-icon bg-success">
                                                    <i class="bi bi-clock-history"></i>
                                                </div>
                                                <div>
                                                    <h6 class="widget-title">Kehadiran Bulan Ini</h6>
                                                    <p class="text-muted small mb-0">{{ date('F Y') }}</p>
                                                </div>
                                            </div>

                                            @if(isset($employeeAnalytics['performanceComparison']))
                                                @php
                                                    $myRate = $employeeAnalytics['performanceComparison']['my_attendance_rate'];
                                                    $avgRate = $employeeAnalytics['performanceComparison']['company_avg_attendance'];
                                                @endphp
                                                
                                                <div class="attendance-summary mt-3">
                                                    <div class="text-center mb-3">
                                                        <div class="attendance-circle">
                                                            <div class="circle-progress" data-percentage="{{ $myRate }}">
                                                                <div class="circle-text">
                                                                    <span class="percentage">{{ round($myRate) }}%</span>
                                                                    <span class="label">Kehadiran</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="comparison-stats">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <span class="text-muted small">Saya</span>
                                                            <span class="small font-weight-bold text-{{ $myRate >= 90 ? 'success' : ($myRate >= 80 ? 'warning' : 'danger') }}">
                                                                {{ round($myRate) }}%
                                                            </span>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <span class="text-muted small">Rata-rata perusahaan</span>
                                                            <span class="small">{{ round($avgRate) }}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center py-3">
                                                    <div class="h4 text-success">{{ $absensimasukperkaryawan }}</div>
                                                    <p class="text-muted small mb-0">Hari hadir</p>
                                                </div>
                                            @endif

                                            <div class="mt-3">
                                                <a href="{{ route('absensi.index') }}" class="btn btn-success btn-sm w-100">
                                                    <i class="bi bi-eye me-1"></i> Lihat Riwayat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Next Payroll Card -->
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="employee-widget-card">
                                        <div class="card-body">
                                            <div class="widget-header">
                                                <div class="widget-icon bg-warning">
                                                    <i class="bi bi-wallet2"></i>
                                                </div>
                                                <div>
                                                    <h6 class="widget-title">Informasi Gaji</h6>
                                                    <p class="text-muted small mb-0">Pembayaran terakhir</p>
                                                </div>
                                            </div>

                                            <div class="payroll-info mt-3">
                                                <div class="last-salary text-center mb-3">
                                                    <div class="salary-amount h5 text-success mb-1">
                                                        Rp {{ number_format($gajiperkaryawan, 0, ',', '.') }}
                                                    </div>
                                                    <p class="text-muted small mb-0">Gaji terbaru diterima</p>
                                                </div>

                                                @if(isset($employeeAnalytics['upcomingEvents']['next_payroll']))
                                                    <div class="next-payroll-info">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <span class="text-muted small">Pembayaran berikutnya</span>
                                                            <span class="badge bg-info">{{ $employeeAnalytics['upcomingEvents']['next_payroll'] }}</span>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="payroll-countdown">
                                                    <div class="text-center">
                                                        <div id="payrollCountdown" class="countdown-timer"></div>
                                                        <p class="text-muted small mb-0">hingga gaji berikutnya</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <a href="{{ route('riwayatgaji.index') }}" class="btn btn-warning btn-sm w-100">
                                                    <i class="bi bi-clock-history me-1"></i> Riwayat Gaji
                                                </a>
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

                        <!-- Charts Section -->
                        @if (Auth::user()->hasRole('Administrator'))
                            <div class="row mt-4 dashboard-charts">
                                <div class="col-12 mb-3">
                                    <h5 class="dashboard-section-title mb-0">Analitik Dashboard</h5>
                                    <p class="text-muted small mb-0">Grafik dan visualisasi data karyawan</p>
                                </div>
                                
                                <!-- First row of charts -->
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <div style="height: 300px;">
                                                <canvas id="attendanceTrendsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <div style="height: 300px;">
                                                <canvas id="salaryDistributionChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Second row of charts -->
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <div style="height: 300px;">
                                                <canvas id="departmentStatsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <div style="height: 300px;">
                                                <canvas id="monthlyPayrollChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Third row of charts -->
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <div style="height: 300px;">
                                                <canvas id="leaveStatisticsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <div style="height: 300px;">
                                                <canvas id="employeePerformanceChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Auth::user()->hasRole('Employee'))
                            <div class="row mt-4 dashboard-charts">
                                <div class="col-12 mb-3">
                                    <h5 class="dashboard-section-title mb-0">Analitik Personal</h5>
                                    <p class="text-muted small mb-0">Grafik data pribadi Anda</p>
                                </div>
                                
                                <!-- Employee personal charts -->
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <h6 class="card-title">Riwayat Kehadiran</h6>
                                            <div style="height: 250px;">
                                                <canvas id="personalAttendanceChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-body">
                                            <h6 class="card-title">Status Cuti</h6>
                                            <div style="height: 250px;">
                                                <canvas id="personalLeaveChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
