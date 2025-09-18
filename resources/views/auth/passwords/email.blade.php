@extends('layouts.auth')

@section('title', 'Reset Password - HRIS IGI')

@section('content')
    <div class="card-header text-center">
        <div class="d-flex justify-content-center mb-3">
            <span class="brand-badge"><i class="bi bi-envelope-fill"></i></span>
        </div>
        <h3 class="fw-semibold mb-1">Reset Password</h3>
        <p class="text-muted mb-0">Masukkan email Anda untuk menerima tautan reset</p>
    </div>
    <div class="card-body p-3 p-md-4">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-floating mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                <label for="email">Email</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-50">Kembali</a>
                <button type="submit" class="btn btn-primary w-50">Kirim Link</button>
            </div>
        </form>
    </div>
@endsection
