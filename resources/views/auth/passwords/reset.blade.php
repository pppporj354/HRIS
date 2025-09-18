@extends('layouts.auth')

@section('title', 'Setel Ulang Password - HRIS IGI')

@section('content')
    <div class="card-header text-center">
        <div class="d-flex justify-content-center mb-3">
            <span class="brand-badge"><i class="bi bi-shield-lock-fill"></i></span>
        </div>
        <h3 class="fw-semibold mb-1">Setel Ulang Password</h3>
        <p class="text-muted mb-0">Buat password baru untuk akun Anda</p>
    </div>
    <div class="card-body p-3 p-md-4">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-floating mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                <label for="email">Email Address</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" name="password"
                    required autocomplete="new-password">
                <label for="password">Password Baru</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="password-confirm" type="password" class="form-control"
                    name="password_confirmation" required autocomplete="new-password">
                <label for="password-confirm">Konfirmasi Password</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
            </div>
        </form>
    </div>
@endsection
