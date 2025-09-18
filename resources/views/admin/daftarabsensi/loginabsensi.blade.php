<!DOCTYPE html>
<html class="w-100 h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('igi_logo.png') }}" type="image/x-icon">
    <title>Master Login</title>
    @vite('resources/js/jquery.js')
    @vite('resources/js/app.js')
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/css/dashboard.css'])

</head>

<body class="w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="card text-center" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Login absensi</h5>
            <form method="POST" action="{{ route('daftarabsensi.loginAbsensi') }}">
                @csrf
                <div class="form-group">
                    <label for="password" class="mb-2">Master Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                        id="password " required>
                </div>
                @error('password')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
                <div class="button-back-login mt-2">
                    <a href="{{ route('daftarabsensi.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary ms-2" type="submit">Login</button>
                </div>
        </div>
    </div>
    @include('sweetalert::alert')
</body>

</html>
