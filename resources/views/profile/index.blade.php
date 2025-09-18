@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 mt-3 mb-3">
            <div class="card">
                <div class="card-header fs-6 d-flex justify-content-between">
                    <span class="fw-bold">{{ __('Profil') }}</span>
                    <span class="fst-italic">Logged in as : {{ $user->role }}</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <img src="{{ Vite::asset('resources/assets/avatar.svg') }}" alt="mdo" width="25%" height="25%"
                        class="rounded-circle align-self-center bg-light">
                    <h4 class="card-title mt-4 text-center">Data Karyawan</h4>
                    <h6>Nama</h6>
                    <input class="" type="text" name="alamat" id="alamat" value="{{ $datakaryawan->nama }}"
                        disabled>
                    <h6 class="mt-2">Alamat</h6>
                    <input class="" type="text" name="alamat" id="alamat" value="{{ $datakaryawan->alamat }}"
                        disabled>
                    <h6 class="mt-2">Nomor Telepon</h6>
                    <input class="" type="text" name="alamat" id="alamat"
                        value="{{ $datakaryawan->nomor_telepon }}" disabled>
                    <h6 class="mt-2">Status Karyawan</h6>
                    <input class="" type="text" name="alamat" id="alamat"
                        value="{{ $datakaryawan->status_karyawan }}" disabled>
                    <h6 class="mt-2">Keahlian</h6>
                    <input class="" type="text" name="alamat" id="alamat" value="{{ $datakaryawan->keahlian }}"
                        disabled>
                    <h6 class="mt-2">Jabatan</h6>
                    <input class="" type="text" name="alamat" id="alamat" value="{{ $datakaryawan->jabatan }}"
                        disabled>
                    <h4 class="card-title mt-4 text-center">Data Akun</h4>
                    <h6>Username</h6>
                    <input class="" type="text" name="alamat" id="alamat" value="{{ $user->username }}"
                        disabled>
                    <h6 class="mt-2">Email</h6>
                    <input class="" type="text" name="alamat" id="alamat" value="{{ $user->email }}"
                        disabled>
                    <h6 class="mt-2">Password</h6>
                    <input class="" type="password" name="password" id="password" value="password" disabled>
                    <a href="{{ route('profil.sunting') }}" class="btn btn-primary mt-3">Sunting
                        Profil</a>
                </div>
            </div>
        </div>
    </div>
@endsection
