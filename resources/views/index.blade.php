@extends('layouts.app')
@section('css')
    <style>
        .card-icon { font-size: 1.25rem; color: #fff; }
        .stat-card .card-body { padding: 1.25rem 1.25rem; }
        .stat-card .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: .25rem; }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 mt-3 mb-3">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body" style="overflow-x: auto;">
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            <h6>Selamat Datang di Sistem Informasi Sumber Daya Manusia PT. Indo Global Impex </h6>
                            {{ session('status') }}
                        </div>
                    @endif
                    @auth
                        @if (Auth::user()->hasRole('Administrator'))
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Pengajuan Cuti</span>
                                                <span class="icon-wrap"><i class="bi bi-file-earmark-text card-icon"></i></span>
                                            </div>
                                            <div class="value">{{ $totalcuti }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Total Gaji Dibayarkan</span>
                                                <span class="icon-wrap"><i class="bi bi-cash-coin card-icon"></i></span>
                                            </div>
                                            <div class="value">{{ $jumlahgajiterbayar }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Jumlah Karyawan</span>
                                                <span class="icon-wrap"><i class="bi bi-calendar-check card-icon"></i></span>
                                            </div>
                                            <div class="value">{{ $totaldatakaryawan }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                    @auth
                        @if (Auth::user()->hasRole('Employee'))
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Jumlah Cuti yang Diajukan</span>
                                                <span class="icon-wrap"><i class="bi bi-file-earmark-text card-icon"></i></span>
                                            </div>
                                            <div class="value" id="pengajuanCuti">{{ $pengajuancutiperkaryawan }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Total Gaji Diterima</span>
                                                <span class="icon-wrap"><i class="bi bi-cash-coin card-icon"></i></span>
                                            </div>
                                            <div class="value" id="totalGaji">{{ $gajiperkaryawan }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-accent"></span>
                                        <div class="card-body">
                                            <div class="header">
                                                <span class="label">Jumlah Kehadiran</span>
                                                <span class="icon-wrap"><i class="bi bi-calendar-check card-icon"></i></span>
                                            </div>
                                            <div class="value" id="jumlahKehadiran">{{ $absensimasukperkaryawan }} Hari</div>
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
