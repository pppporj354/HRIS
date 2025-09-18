@extends('layouts.app')
@section('css')
    <style>
        .card-icon {
            font-size: 2rem;
            color: #ffffff;
        }

        .card {
            margin-bottom: 1rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
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
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div>Pengajuan Cuti</div>
                                                <i class="bi bi-file-earmark-text card-icon"></i>
                                            </div>
                                            <h3>{{ $totalcuti }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div>Total Gaji Dibayarkan</div>
                                                <i class="bi bi-cash-coin card-icon"></i>
                                            </div>
                                            <h3>{{ $jumlahgajiterbayar }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div>Jumlah Karyawan</div>
                                                <i class="bi bi-calendar-check card-icon"></i>
                                            </div>
                                            <h3>{{ $totaldatakaryawan }}</h3>
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
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div>Jumlah Cuti yang Diajukan</div>
                                                <i class="bi bi-file-earmark-text card-icon"></i>
                                            </div>
                                            <h3 id="pengajuanCuti">{{ $pengajuancutiperkaryawan }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div>Total Gaji Diterima</div>
                                                <i class="bi bi-cash-coin card-icon"></i>
                                            </div>
                                            <h3 id="totalGaji">{{ $gajiperkaryawan }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div>Jumlah Kehadiran</div>
                                                <i class="bi bi-calendar-check card-icon"></i>
                                            </div>
                                            <h3 id="jumlahKehadiran">{{ $absensimasukperkaryawan }} Hari</h3>
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
