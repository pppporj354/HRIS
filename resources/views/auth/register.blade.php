@extends('layouts.auth')

@section('title', 'Daftar Akun - HRIS IGI')

@section('content')
    <div class="card-header text-center">
        <div class="d-flex justify-content-center mb-3">
            <span class="brand-badge"><i class="bi bi-person-plus-fill"></i></span>
        </div>
        <h3 class="fw-semibold mb-1">Buat Akun</h3>
        <p class="text-muted mb-0">Daftar untuk mulai menggunakan HRIS IGI</p>
    </div>
    <div class="card-body p-3 p-md-4">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-floating mb-3">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                <label for="name">Nama</label>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email">
                <label for="email">Email Address</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                <label for="password">Password</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    required autocomplete="new-password">
                <label for="password-confirm">Konfirmasi Password</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">{{ __('Register') }}</button>
            </div>
        </form>
    </div>
    <div class="card-footer bg-transparent text-center py-3">
        <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></small>
    </div>
@endsection
