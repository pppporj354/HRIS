@extends('layouts.app')
@section('content')
    <div class="container-sm my-4">
        <div class="row justify-content-center">
            <div class="p-5 bg-light rounded-3 col-xl-8 border">
                <div class="mb-3 text-center">
                    <i class="bi-person-circle fs-1"></i>
                    <h4>Detail Data Rekrutmen</h4>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">Nama</label>
                        <h5>{{ $datarekrutmen->nama }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">Alamat</label>
                        <h5>{{ $datarekrutmen->alamat }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Nomor Telepon</label>
                        <h5>{{ $datarekrutmen->nomor_telepon }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Status Karyawan</label>
                        <h5>{{ $datarekrutmen->status_karyawan }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Keahlian</label>
                        <h5>{{ $datarekrutmen->keahlian }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Jabatan</label>
                        <h5>{{ $datarekrutmen->jabatan }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Role</label>
                        <h5>{{ $datarekrutmen->user->role }}</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 d-grid">
                        <a href="{{ route('datakaryawan.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                class="bi-arrow-left-circle me-2"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
