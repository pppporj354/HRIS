@extends('layouts.auth')

@section('title', 'Masuk - HRIS IGI')

@section('content')
    <div class="card-header text-center">
        <div class="d-flex justify-content-center mb-3">
            <span class="brand-badge"><i class="bi bi-lock-fill"></i></span>
        </div>
        <h3 class="fw-semibold mb-1">Selamat datang kembali</h3>
        <p class="text-muted mb-0">Masuk untuk melanjutkan ke dashboard</p>
    </div>
    <div class="card-body p-3 p-md-4">
        @error('login')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control @error('login') is-invalid @enderror" id="login"
                    name="login" type="text" placeholder="Email or Username" required
                    autocomplete="login"
                    @if (isset($_COOKIE['login'])) value="{{ $_COOKIE['login'] }}" @else value="{{ old('login') }}" @endif>
                <label for="login">Email address or Username</label>
            </div>
            <div class="form-floating mb-2">
                <input class="form-control @error('login') is-invalid @enderror" id="password"
                    type="password" name="password" placeholder="Password"
                    autocomplete="current-password" value="{{ old('password') }}" required />
                <label for="password">Password</label>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                        name="rememberme" value="on" checked />
                    <label class="form-check-label" for="inputRememberPassword">Remember Me</label>
                </div>
                <a class="small link-muted" href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>
        </form>
    </div>
    <div class="card-footer bg-transparent text-center py-3">
        <small class="text-muted">PT. Indo Global Impex • HRIS IGI</small>
    </div>
@endsection
