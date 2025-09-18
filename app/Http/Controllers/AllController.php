<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\DataKaryawan;
use App\Models\Gaji;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AllController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // Get employee data based on user_id
        $datakaryawan = DataKaryawan::where('user_id', $user->id_user)->first();

        if ($datakaryawan) {
            // Employee-specific calculations
            $gajiperkaryawan = Gaji::where('status_gaji', 'Terbayar')
                ->where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->sum('total_gaji');

            $pengajuancutiperkaryawan = Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)->count();
            $absensimasukperkaryawan = Absensi::where('status_absensi', 'Masuk')
                ->where('data_karyawan_id', $datakaryawan->id_data_karyawan)->count();
        } else {
            $gajiperkaryawan = 0;
            $pengajuancutiperkaryawan = 0;
            $absensimasukperkaryawan = 0;
        }

        // Basic statistics
        $totaldatakaryawan = DataKaryawan::count();
        $totalcuti = Cuti::count();
        $jumlahgajiterbayar = Gaji::where('status_gaji', 'Terbayar')->sum('total_gaji');

        // Enhanced Analytics for Admin Dashboard
        $adminAnalytics = [];
        $employeeAnalytics = [];

        // Replace hasRole with role attribute check
        if (Auth::user()->role === 'Administrator') {
            $adminAnalytics = $this->getAdminAnalytics();
        }

        if (Auth::user()->role === 'Employee') {
            $employeeAnalytics = $this->getEmployeeAnalytics($datakaryawan);
        }

        return view('index', compact(
            'totaldatakaryawan',
            'totalcuti',
            'jumlahgajiterbayar',
            'gajiperkaryawan',
            'pengajuancutiperkaryawan',
            'absensimasukperkaryawan',
            'adminAnalytics',
            'employeeAnalytics'
        ));
    }

    private function getAdminAnalytics()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return [
            // Employee distribution by status
            'employeeByStatus' => DataKaryawan::select('status_karyawan', DB::raw('count(*) as count'))
                ->groupBy('status_karyawan')
                ->get(),

            // Monthly attendance trends (last 6 months)
            'attendanceTrends' => Absensi::select(
                DB::raw('strftime("%m", tanggal) as month'),
                DB::raw('COUNT(CASE WHEN status_absensi = "Masuk" THEN 1 END) as present'),
                DB::raw('COUNT(CASE WHEN status_absensi = "Tidak Masuk" THEN 1 END) as absent')
            )
                ->where(DB::raw('strftime("%Y", tanggal)'), $currentYear)
                ->where(DB::raw('strftime("%m", tanggal)'), '>=', sprintf('%02d', $currentMonth - 5))
                ->groupBy(DB::raw('strftime("%m", tanggal)'))
                ->orderBy('month')
                ->get(),

            // Leave requests by status
            'leaveByStatus' => Cuti::select('status_cuti', DB::raw('count(*) as count'))
                ->groupBy('status_cuti')
                ->get(),

            // Salary distribution by range
            'salaryDistribution' => Gaji::select(
                DB::raw('CASE
                    WHEN total_gaji < 5000000 THEN "< 5M"
                    WHEN total_gaji BETWEEN 5000000 AND 10000000 THEN "5M - 10M"
                    WHEN total_gaji BETWEEN 10000000 AND 15000000 THEN "10M - 15M"
                    ELSE "> 15M"
                END as range'),
                DB::raw('count(*) as count')
            )
                ->where('status_gaji', 'Terbayar')
                ->groupBy('range')
                ->get(),

            // Department statistics (based on jabatan)
            'departmentStats' => DataKaryawan::select('jabatan', DB::raw('count(*) as count'))
                ->groupBy('jabatan')
                ->orderBy('count', 'desc')
                ->get(),

            // Recent activities for admin
            'recentActivities' => $this->getRecentActivities(),

            // Pending approvals count
            'pendingApprovals' => [
                'leave_requests' => Cuti::where('status_cuti', 'Pending')->count(),
                'payroll_pending' => Gaji::where('status_gaji', 'Belum Dibayar')->count(),
            ],

            // Monthly payroll summary
            'monthlyPayroll' => Gaji::select(
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('SUM(total_gaji) as total'),
                DB::raw('COUNT(*) as count')
            )
                ->where('status_gaji', 'Terbayar')
                ->where(DB::raw('strftime("%Y", created_at)'), $currentYear)
                ->groupBy(DB::raw('strftime("%m", created_at)'))
                ->orderBy('month')
                ->get(),

            // Employee performance metrics
            'performanceMetrics' => [
                'top_performers' => $this->getTopPerformers(),
                'attendance_leaders' => $this->getAttendanceLeaders(),
                'average_salary' => Gaji::where('status_gaji', 'Terbayar')->avg('total_gaji'),
            ]
        ];
    }

    private function getEmployeeAnalytics($datakaryawan)
    {
        if (!$datakaryawan) {
            return [];
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Calculate leave usage for the employee
        $pengajuancutiperkaryawan = Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)->count();

        return [
            // Personal attendance history (last 6 months)
            'attendanceHistory' => Absensi::select(
                DB::raw('strftime("%m", tanggal) as month'),
                DB::raw('COUNT(CASE WHEN status_absensi = "Masuk" THEN 1 END) as present'),
                DB::raw('COUNT(CASE WHEN status_absensi = "Tidak Masuk" THEN 1 END) as absent')
            )
                ->where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->where(DB::raw('strftime("%Y", tanggal)'), $currentYear)
                ->where(DB::raw('strftime("%m", tanggal)'), '>=', sprintf('%02d', $currentMonth - 5))
                ->groupBy(DB::raw('strftime("%m", tanggal)'))
                ->orderBy('month')
                ->get(),

            // Leave balance and usage
            'leaveBalance' => [
                'total_requests' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)->count(),
                'approved' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                    ->where('status_cuti', 'Disetujui')->count(),
                'pending' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                    ->where('status_cuti', 'Pending')->count(),
                'rejected' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                    ->where('status_cuti', 'Ditolak')->count(),
            ],

            // Salary history (last 6 months)
            'salaryHistory' => Gaji::select('total_gaji', 'created_at')
                ->where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->where('status_gaji', 'Terbayar')
                ->where(DB::raw('strftime("%Y", created_at)'), $currentYear)
                ->where(DB::raw('strftime("%m", created_at)'), '>=', sprintf('%02d', $currentMonth - 5))
                ->orderBy('created_at', 'desc')
                ->get(),

            // Recent personal activities
            'recentActivities' => $this->getEmployeeRecentActivities($datakaryawan->id_data_karyawan),

            // Performance comparison
            'performanceComparison' => [
                'my_attendance_rate' => $this->getEmployeeAttendanceRate($datakaryawan->id_data_karyawan),
                'company_avg_attendance' => $this->getCompanyAverageAttendance(),
                'my_leave_usage' => $pengajuancutiperkaryawan,
                'department_avg_leave' => $this->getDepartmentAverageLeave($datakaryawan->jabatan),
            ],

            // Upcoming events
            'upcomingEvents' => [
                'pending_leave' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                    ->where('status_cuti', 'Pending')
                    ->orderBy('tanggal_mulai_cuti')
                    ->first(),
                'next_payroll' => $this->getNextPayrollDate(),
            ]
        ];
    }

    private function getRecentActivities()
    {
        $activities = [];

        try {
            // Get latest leave requests
            $latestCuti = Cuti::join('data_karyawan', 'cuti.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan')
                ->select('cuti.*', 'data_karyawan.nama')
                ->orderBy('cuti.created_at', 'desc')
                ->limit(3)
                ->get();

            foreach ($latestCuti as $cuti) {
                $activities[] = [
                    'type' => 'leave_request',
                    'icon' => 'bi-calendar-x',
                    'title' => 'Pengajuan Cuti',
                    'description' => $cuti->nama . ' mengajukan cuti dari ' .
                        Carbon::parse($cuti->tanggal_mulai_cuti)->format('d M') . ' - ' .
                        Carbon::parse($cuti->tanggal_selesai_cuti)->format('d M Y'),
                    'status' => $cuti->status_cuti,
                    'time' => Carbon::parse($cuti->created_at)->diffForHumans(),
                    'color' => $this->getStatusColor($cuti->status_cuti),
                ];
            }

            // Get latest payroll activities
            $latestPayroll = Gaji::join('data_karyawan', 'gaji.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan')
                ->select('gaji.*', 'data_karyawan.nama')
                ->orderBy('gaji.created_at', 'desc')
                ->limit(2)
                ->get();

            foreach ($latestPayroll as $gaji) {
                $activities[] = [
                    'type' => 'payroll',
                    'icon' => 'bi-wallet2',
                    'title' => 'Pembayaran Gaji',
                    'description' => 'Gaji ' . $gaji->nama . ' sebesar Rp ' . number_format($gaji->total_gaji),
                    'status' => $gaji->status_gaji,
                    'time' => Carbon::parse($gaji->created_at)->diffForHumans(),
                    'color' => $gaji->status_gaji == 'Terbayar' ? 'success' : 'warning',
                ];
            }

            // Get latest attendance records
            $latestAttendance = Absensi::join('data_karyawan', 'absensi.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan')
                ->select('absensi.*', 'data_karyawan.nama')
                ->orderBy('absensi.created_at', 'desc')
                ->limit(2)
                ->get();

            foreach ($latestAttendance as $absensi) {
                $activities[] = [
                    'type' => 'attendance',
                    'icon' => $absensi->status_absensi == 'Masuk' ? 'bi-check-circle' : 'bi-x-circle',
                    'title' => 'Absensi',
                    'description' => $absensi->nama . ' - ' . $absensi->status_absensi .
                        ' pada ' . Carbon::parse($absensi->tanggal)->format('d M Y'),
                    'status' => $absensi->status_absensi,
                    'time' => Carbon::parse($absensi->created_at)->diffForHumans(),
                    'color' => $absensi->status_absensi == 'Masuk' ? 'success' : 'danger',
                ];
            }

            // Sort activities by time and limit to 5
            usort($activities, function ($a, $b) {
                return strtotime($b['time']) <=> strtotime($a['time']);
            });

            return array_slice($activities, 0, 5);

        } catch (\Exception $e) {
            return [];
        }
    }

    private function getEmployeeRecentActivities($employeeId)
    {
        $activities = [];

        try {
            // Get employee's recent leave requests
            $recentCuti = Cuti::where('data_karyawan_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            foreach ($recentCuti as $cuti) {
                $activities[] = [
                    'type' => 'leave_request',
                    'icon' => 'bi-calendar-x',
                    'title' => 'Pengajuan Cuti',
                    'description' => 'Cuti dari ' .
                        Carbon::parse($cuti->tanggal_mulai_cuti)->format('d M') . ' - ' .
                        Carbon::parse($cuti->tanggal_selesai_cuti)->format('d M Y'),
                    'status' => $cuti->status_cuti,
                    'time' => Carbon::parse($cuti->created_at)->diffForHumans(),
                    'color' => $this->getStatusColor($cuti->status_cuti),
                ];
            }

            // Get employee's recent salary payments
            $recentGaji = Gaji::where('data_karyawan_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->limit(2)
                ->get();

            foreach ($recentGaji as $gaji) {
                $activities[] = [
                    'type' => 'salary',
                    'icon' => 'bi-wallet2',
                    'title' => 'Pembayaran Gaji',
                    'description' => 'Gaji sebesar Rp ' . number_format($gaji->total_gaji),
                    'status' => $gaji->status_gaji,
                    'time' => Carbon::parse($gaji->created_at)->diffForHumans(),
                    'color' => $gaji->status_gaji == 'Terbayar' ? 'success' : 'warning',
                ];
            }

            // Get employee's recent attendance
            $recentAttendance = Absensi::where('data_karyawan_id', $employeeId)
                ->orderBy('tanggal', 'desc')
                ->limit(3)
                ->get();

            foreach ($recentAttendance as $absensi) {
                $activities[] = [
                    'type' => 'attendance',
                    'icon' => $absensi->status_absensi == 'Masuk' ? 'bi-check-circle' : 'bi-x-circle',
                    'title' => 'Absensi',
                    'description' => $absensi->status_absensi . ' pada ' .
                        Carbon::parse($absensi->tanggal)->format('d M Y'),
                    'status' => $absensi->status_absensi,
                    'time' => Carbon::parse($absensi->tanggal)->diffForHumans(),
                    'color' => $absensi->status_absensi == 'Masuk' ? 'success' : 'danger',
                ];
            }

            // Sort activities by time and limit to 5
            usort($activities, function ($a, $b) {
                return strtotime($b['time']) <=> strtotime($a['time']);
            });

            return array_slice($activities, 0, 5);

        } catch (\Exception $e) {
            return [];
        }
    }

    private function getTopPerformers()
    {
        return DataKaryawan::select('data_karyawan.nama', 'data_karyawan.jabatan')
            ->join('absensi', 'data_karyawan.id_data_karyawan', '=', 'absensi.data_karyawan_id')
            ->select(
                'data_karyawan.nama',
                'data_karyawan.jabatan',
                DB::raw('COUNT(CASE WHEN absensi.status_absensi = "Masuk" THEN 1 END) as attendance_count'),
                DB::raw('COUNT(absensi.id_absensi) as total_days'),
                DB::raw('(COUNT(CASE WHEN absensi.status_absensi = "Masuk" THEN 1 END) / COUNT(absensi.id_absensi)) * 100 as attendance_rate')
            )
            ->groupBy('data_karyawan.id_data_karyawan', 'data_karyawan.nama', 'data_karyawan.jabatan')
            ->orderBy('attendance_rate', 'desc')
            ->limit(5)
            ->get();
    }

    private function getAttendanceLeaders()
    {
        $currentMonth = Carbon::now()->month;

        return DataKaryawan::select('data_karyawan.nama', 'data_karyawan.jabatan')
            ->join('absensi', 'data_karyawan.id_data_karyawan', '=', 'absensi.data_karyawan_id')
            ->select(
                'data_karyawan.nama',
                'data_karyawan.jabatan',
                DB::raw('COUNT(CASE WHEN absensi.status_absensi = "Masuk" THEN 1 END) as present_days')
            )
            ->where(DB::raw('strftime("%m", absensi.tanggal)'), sprintf('%02d', $currentMonth))
            ->groupBy('data_karyawan.id_data_karyawan', 'data_karyawan.nama', 'data_karyawan.jabatan')
            ->orderBy('present_days', 'desc')
            ->limit(5)
            ->get();
    }

    private function getEmployeeAttendanceRate($employeeId)
    {
        $currentMonth = Carbon::now()->month;
        $attendanceData = Absensi::where('data_karyawan_id', $employeeId)
            ->where(DB::raw('strftime("%m", tanggal)'), sprintf('%02d', $currentMonth))
            ->selectRaw('
                COUNT(CASE WHEN status_absensi = "Masuk" THEN 1 END) as present,
                COUNT(*) as total
            ')
            ->first();

        return $attendanceData->total > 0 ?
            round(($attendanceData->present / $attendanceData->total) * 100, 2) : 0;
    }

    private function getCompanyAverageAttendance()
    {
        $currentMonth = Carbon::now()->month;
        $avgData = Absensi::where(DB::raw('strftime("%m", tanggal)'), sprintf('%02d', $currentMonth))
            ->selectRaw('
                COUNT(CASE WHEN status_absensi = "Masuk" THEN 1 END) as present,
                COUNT(*) as total
            ')
            ->first();

        return $avgData->total > 0 ?
            round(($avgData->present / $avgData->total) * 100, 2) : 0;
    }

    private function getDepartmentAverageLeave($jabatan)
    {
        return DataKaryawan::where('jabatan', $jabatan)
            ->join('cuti', 'data_karyawan.id_data_karyawan', '=', 'cuti.data_karyawan_id')
            ->avg(DB::raw('1'));
    }

    private function getNextPayrollDate()
    {
        // Assuming payroll is processed monthly on the 25th
        $nextPayroll = Carbon::now()->day > 25 ?
            Carbon::now()->addMonth()->day(25) :
            Carbon::now()->day(25);

        return $nextPayroll->format('d M Y');
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Disetujui':
            case 'Terbayar':
                return 'success';
            case 'Pending':
                return 'warning';
            case 'Ditolak':
            case 'Belum Dibayar':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    public function panduan()
    {
        return view('guide');
    }

    // Dashboard API endpoints for charts and real-time data

    public function getAttendanceTrends()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $trends = Absensi::select(
            DB::raw('strftime("%m", tanggal) as month'),
            DB::raw('CASE strftime("%m", tanggal)
                WHEN "01" THEN "January"
                WHEN "02" THEN "February"
                WHEN "03" THEN "March"
                WHEN "04" THEN "April"
                WHEN "05" THEN "May"
                WHEN "06" THEN "June"
                WHEN "07" THEN "July"
                WHEN "08" THEN "August"
                WHEN "09" THEN "September"
                WHEN "10" THEN "October"
                WHEN "11" THEN "November"
                WHEN "12" THEN "December"
                END as month_name'),
            DB::raw('COUNT(CASE WHEN status_absensi = "Masuk" THEN 1 END) as present'),
            DB::raw('COUNT(CASE WHEN status_absensi = "Tidak Masuk" THEN 1 END) as absent'),
            DB::raw('COUNT(*) as total')
        )
            ->where(DB::raw('strftime("%Y", tanggal)'), $currentYear)
            ->where(DB::raw('strftime("%m", tanggal)'), '>=', sprintf('%02d', $currentMonth - 5))
            ->groupBy(DB::raw('strftime("%m", tanggal)'))
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $trends
        ]);
    }

    public function getSalaryDistribution()
    {
        $distribution = Gaji::select(
            DB::raw('CASE
                WHEN total_gaji < 5000000 THEN "< 5M"
                WHEN total_gaji BETWEEN 5000000 AND 10000000 THEN "5M - 10M"
                WHEN total_gaji BETWEEN 10000000 AND 15000000 THEN "10M - 15M"
                ELSE "> 15M"
            END as range'),
            DB::raw('count(*) as count'),
            DB::raw('AVG(total_gaji) as average')
        )
            ->where('status_gaji', 'Terbayar')
            ->groupBy('range')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $distribution
        ]);
    }

    public function getDepartmentStats()
    {
        $stats = DataKaryawan::select(
            'jabatan as department',
            DB::raw('count(*) as employee_count'),
            DB::raw('AVG((SELECT COUNT(*) FROM absensi WHERE absensi.data_karyawan_id = data_karyawan.id_data_karyawan AND status_absensi = "Masuk")) as avg_attendance'),
            DB::raw('AVG((SELECT AVG(total_gaji) FROM gaji WHERE gaji.data_karyawan_id = data_karyawan.id_data_karyawan AND status_gaji = "Terbayar")) as avg_salary')
        )
            ->groupBy('jabatan')
            ->orderBy('employee_count', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    public function getMonthlyPayroll()
    {
        $currentYear = Carbon::now()->year;

        $payroll = Gaji::select(
            DB::raw('strftime("%m", created_at) as month'),
            DB::raw('CASE strftime("%m", created_at)
                WHEN "01" THEN "January"
                WHEN "02" THEN "February"
                WHEN "03" THEN "March"
                WHEN "04" THEN "April"
                WHEN "05" THEN "May"
                WHEN "06" THEN "June"
                WHEN "07" THEN "July"
                WHEN "08" THEN "August"
                WHEN "09" THEN "September"
                WHEN "10" THEN "October"
                WHEN "11" THEN "November"
                WHEN "12" THEN "December"
                END as month_name'),
            DB::raw('SUM(total_gaji) as total_amount'),
            DB::raw('COUNT(*) as employee_count'),
            DB::raw('AVG(total_gaji) as average_salary')
        )
            ->where('status_gaji', 'Terbayar')
            ->where(DB::raw('strftime("%Y", created_at)'), $currentYear)
            ->groupBy(DB::raw('strftime("%m", created_at)'))
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payroll
        ]);
    }

    public function getLeaveStatistics()
    {
        $currentYear = Carbon::now()->year;

        $leaveStats = [
            'by_status' => Cuti::select('status_cuti as status', DB::raw('count(*) as count'))
                ->groupBy('status_cuti')
                ->get(),

            'monthly_trends' => Cuti::select(
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('CASE strftime("%m", created_at)
                    WHEN "01" THEN "January"
                    WHEN "02" THEN "February"
                    WHEN "03" THEN "March"
                    WHEN "04" THEN "April"
                    WHEN "05" THEN "May"
                    WHEN "06" THEN "June"
                    WHEN "07" THEN "July"
                    WHEN "08" THEN "August"
                    WHEN "09" THEN "September"
                    WHEN "10" THEN "October"
                    WHEN "11" THEN "November"
                    WHEN "12" THEN "December"
                    END as month_name'),
                DB::raw('COUNT(*) as total_requests'),
                DB::raw('COUNT(CASE WHEN status_cuti = "Disetujui" THEN 1 END) as approved'),
                DB::raw('COUNT(CASE WHEN status_cuti = "Pending" THEN 1 END) as pending'),
                DB::raw('COUNT(CASE WHEN status_cuti = "Ditolak" THEN 1 END) as rejected')
            )
                ->where(DB::raw('strftime("%Y", created_at)'), $currentYear)
                ->groupBy(DB::raw('strftime("%m", created_at)'))
                ->orderBy('month')
                ->get(),

            'by_department' => DataKaryawan::select(
                'jabatan as department',
                DB::raw('COUNT(cuti.id_cuti) as leave_count'),
                DB::raw('AVG(julianday(cuti.tanggal_selesai_cuti) - julianday(cuti.tanggal_mulai_cuti)) as avg_duration')
            )
                ->join('cuti', 'data_karyawan.id_data_karyawan', '=', 'cuti.data_karyawan_id')
                ->groupBy('jabatan')
                ->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $leaveStats
        ]);
    }

    public function getEmployeePerformance()
    {
        $currentMonth = Carbon::now()->month;

        $performance = DataKaryawan::select(
            'data_karyawan.nama',
            'data_karyawan.jabatan as department',
            DB::raw('COUNT(CASE WHEN absensi.status_absensi = "Masuk" THEN 1 END) as attendance_days'),
            DB::raw('COUNT(absensi.id_absensi) as total_days'),
            DB::raw('(COUNT(CASE WHEN absensi.status_absensi = "Masuk" THEN 1 END) / COUNT(absensi.id_absensi)) * 100 as attendance_rate'),
            DB::raw('COUNT(cuti.id_cuti) as leave_requests'),
            DB::raw('AVG(gaji.total_gaji) as average_salary')
        )
            ->leftJoin('absensi', 'data_karyawan.id_data_karyawan', '=', 'absensi.data_karyawan_id')
            ->leftJoin('cuti', 'data_karyawan.id_data_karyawan', '=', 'cuti.data_karyawan_id')
            ->leftJoin('gaji', 'data_karyawan.id_data_karyawan', '=', 'gaji.data_karyawan_id')
            ->where(DB::raw('strftime("%m", absensi.tanggal)'), sprintf('%02d', $currentMonth))
            ->groupBy('data_karyawan.id_data_karyawan', 'data_karyawan.nama', 'data_karyawan.jabatan')
            ->orderBy('attendance_rate', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $performance
        ]);
    }

    public function getRecentActivitiesApi()
    {
        $activities = $this->getRecentActivities();

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    public function getPendingApprovals()
    {
        $approvals = [
            'leave_requests' => [
                'count' => Cuti::where('status_cuti', 'Pending')->count(),
                'items' => Cuti::join('data_karyawan', 'cuti.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan')
                    ->select('cuti.id_cuti', 'data_karyawan.nama', 'cuti.tanggal_mulai_cuti', 'cuti.tanggal_selesai_cuti', 'cuti.keterangan_cuti')
                    ->where('status_cuti', 'Pending')
                    ->orderBy('cuti.created_at', 'desc')
                    ->limit(5)
                    ->get()
            ],
            'payroll_pending' => [
                'count' => Gaji::where('status_gaji', 'Belum Dibayar')->count(),
                'items' => Gaji::join('data_karyawan', 'gaji.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan')
                    ->select('gaji.id_gaji', 'data_karyawan.nama', 'gaji.total_gaji', 'gaji.created_at')
                    ->where('status_gaji', 'Belum Dibayar')
                    ->orderBy('gaji.created_at', 'desc')
                    ->limit(5)
                    ->get()
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $approvals
        ]);
    }

    public function getPersonalAttendance()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $datakaryawan = DataKaryawan::where('user_id', $user->id_user)->first();

        if (!$datakaryawan) {
            return response()->json(['success' => false, 'message' => 'Employee data not found']);
        }

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $attendanceHistory = Absensi::select(
            DB::raw('strftime("%m", tanggal) as month'),
            DB::raw('CASE strftime("%m", tanggal)
                WHEN "01" THEN "January"
                WHEN "02" THEN "February"
                WHEN "03" THEN "March"
                WHEN "04" THEN "April"
                WHEN "05" THEN "May"
                WHEN "06" THEN "June"
                WHEN "07" THEN "July"
                WHEN "08" THEN "August"
                WHEN "09" THEN "September"
                WHEN "10" THEN "October"
                WHEN "11" THEN "November"
                WHEN "12" THEN "December"
                END as month_name'),
            DB::raw('COUNT(CASE WHEN status_absensi = "Masuk" THEN 1 END) as present_days'),
            DB::raw('COUNT(*) as total_days')
        )
            ->where('data_karyawan_id', $datakaryawan->id_data_karyawan)
            ->where(DB::raw('strftime("%Y", tanggal)'), $currentYear)
            ->where(DB::raw('strftime("%m", tanggal)'), '>=', sprintf('%02d', $currentMonth - 5))
            ->groupBy(DB::raw('strftime("%m", tanggal)'))
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attendanceHistory
        ]);
    }

    public function getPersonalLeave()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $datakaryawan = DataKaryawan::where('user_id', $user->id_user)->first();

        if (!$datakaryawan) {
            return response()->json(['success' => false, 'message' => 'Employee data not found']);
        }

        $leaveBalance = [
            'approved' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->where('status_cuti', 'Disetujui')->count(),
            'pending' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->where('status_cuti', 'Pending')->count(),
            'rejected' => Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->where('status_cuti', 'Ditolak')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $leaveBalance
        ]);
    }
}
