@extends('layouts.auth')

@section('title', 'Verifikasi Email - HRIS IGI')

@section('content')
    <div class="card-header text-center">
        <div class="d-flex justify-content-center mb-3">
            <span class="brand-badge"><i class="bi bi-check2-circle"></i></span>
        </div>
        <h3 class="fw-semibold mb-1">Verifikasi Email Anda</h3>
        <p class="text-muted mb-0">Kami telah mengirim tautan verifikasi ke email Anda</p>
    </div>
    <div class="card-body p-3 p-md-4">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p class="mb-3">Sebelum melanjutkan, silakan periksa email Anda untuk menemukan tautan verifikasi.</p>
        <p class="mb-0">Jika Anda tidak menerima email,</p>
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary mt-3">Kirim Ulang Email Verifikasi</button>
        </form>
    </div>
@endsection
