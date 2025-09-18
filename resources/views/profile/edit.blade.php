@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 mt-3 mb-3">
            <div class="card">
                <div class="card-header">{{ __('Profil') }}</div>
                <div class="card-body d-flex flex-column">
                    <img src="{{ Vite::asset('resources/assets/avatar.svg') }}" alt="mdo" width="25%" height="25%"
                        class="rounded-circle align-self-center bg-light mt-2">

                    <form action="{{ route('profil.update', $datakaryawan->id_data_karyawan) }}"
                        enctype="multipart/form-data" method="POST" id="formUpdateProfil" id="formUpdateProfil">
                        @csrf
                        @method('PUT')
                        <h5 class="mt-3 text-center">Data Karyawan</h5>
                        <div class="form-group">
                            <input type="hidden" name="idDataKaryawan" id="idDataKaryawan"
                                value="{{ $datakaryawan->id_data_karyawan }}">
                        </div>
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama"
                                id="nama" value="{{ $datakaryawan->nama }}" placeholder="Masukkan nama">
                            @error('nama')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input class="form-control @error('alamat') is-invalid @enderror" type="text" name="alamat"
                                id="alamat" value="{{ $datakaryawan->alamat }}" placeholder="Masukkan alamat">
                            @error('alamat')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                            <input class="form-control @error('nomorTelepon') is-invalid @enderror" type="tel"
                                name="nomorTelepon" id="nomorTelepon" value="{{ $datakaryawan->nomor_telepon }}"
                                placeholder="Masukkan nomorTelepon">
                            @error('nomorTelepon')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="statusKaryawan" class="form-label">Status Karyawan</label>
                            <input class="form-control" type="text" id="statusKaryawan"
                                value="{{ $datakaryawan->status_karyawan }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="keahlian" class="form-label">Keahlian</label>
                            <input class="form-control @error('keahlian') is-invalid @enderror" type="text"
                                name="keahlian" id="keahlian" value="{{ $datakaryawan->keahlian }}"
                                placeholder="Masukkan keahlian">
                            @error('keahlian')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input class="form-control" type="text" id="jabatan" value="{{ $datakaryawan->jabatan }}"
                                disabled>
                        </div>
                        <h5 class="mt-3 text-center">Data Akun</h5>
                        <div class="form-group">
                            <input type="hidden" name="idUser" id="idUser" value="{{ $user->id_user }}">
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input class="form-control" type="text" id="username" value="{{ $user->username }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                id="email" value="{{ $user->email }}" placeholder="Masukkan email">
                            @error('email')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password Baru</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                name="password" id="password" value="{{ old('password') }}"
                                placeholder="Masukkan password baru (tidak wajib)">
                            @error('password')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password" name="password_confirmation" id="password_confirmation" value=""
                                placeholder="Masukkan ulang password diatas (tidak wajib jika tidak mengganti password)"
                                autocomplete>
                            @error('password_confirmation')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group-button mt-3 d-flex flex-column align-items-center">
                            <button type="submit" class="btn btn-primary col-md-8">Sunting Data</button>
                            <hr style="border-radius: 5px" class="border border-dark border-3 opacity-100 w-50">
                            <a href="{{ route('profil.index') }}" class="btn btn-secondary col-md-8 mt-2">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
