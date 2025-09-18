@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        @if($isAdmin)
                            Tambah Data Absensi
                        @else
                            Absen Hari Ini
                        @endif
                    </h4>
                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        
                        @if($isAdmin)
                            <div class="mb-3">
                                <label for="data_karyawan_id" class="form-label">Karyawan <span class="text-danger">*</span></label>
                                <select class="form-select" id="data_karyawan_id" name="data_karyawan_id" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id_data_karyawan }}" {{ old('data_karyawan_id') == $employee->id_data_karyawan ? 'selected' : '' }}>
                                            {{ $employee->nama }} - {{ $employee->jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" value="{{ $dataKaryawan->nama ?? 'Data karyawan tidak ditemukan' }}" readonly>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="jam_masuk" class="form-label">Jam Masuk <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk', date('H:i')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status_absensi" class="form-label">Status Absensi <span class="text-danger">*</span></label>
                            <select class="form-select" id="status_absensi" name="status_absensi" required>
                                <option value="">Pilih Status</option>
                                <option value="Masuk" {{ old('status_absensi') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="Izin" {{ old('status_absensi') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ old('status_absensi') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alpha" {{ old('status_absensi') == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endpush