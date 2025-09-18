@extends('layouts.auth')

@section('title', 'Konfirmasi Password - HRIS IGI')

@section('content')
    <div class="card-header text-center">
        <div class="d-flex justify-content-center mb-3">
            <span class="brand-badge"><i class="bi bi-key-fill"></i></span>
        </div>
        <h3 class="fw-semibold mb-1">Konfirmasi Password</h3>
        <p class="text-muted mb-0">Silakan konfirmasi password Anda untuk melanjutkan</p>
    </div>
    <div class="card-body p-3 p-md-4">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                <label for="password">Password</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                @if (Route::has('password.request'))
                    <a class="small link-muted" href="{{ route('password.request') }}">Lupa Password?</a>
                @endif
                <button type="submit" class="btn btn-primary">Konfirmasi</button>
            </div>
        </form>
    </div>
@endsection
