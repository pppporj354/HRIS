<!DOCTYPE html>
<html class="h-100 w-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'HRIS IGI')</title>
    <link rel="shortcut icon" href="{{ asset('igi_logo.png') }}" type="image/x-icon">
    @vite(['resources/sass/app.scss','resources/sass/theme.scss','resources/css/app.css','resources/js/app.js'])
    @yield('css')
</head>

<body class="h-100 w-100">
    <main class="auth-wrapper">
        <aside class="auth-illustration">
            <div class="copy">
                <span class="brand-badge mb-3">
                    <i class="bi bi-person-badge"></i>
                </span>
                <h1 class="display-6 mb-2">Human Resource Information System</h1>
                <p class="mb-0">Kelola data karyawan, absensi, cuti dan penggajian dalam satu dasbor modern.</p>
            </div>
        </aside>
        <section class="auth-panel">
            <div class="card auth-card">
                @yield('content')
            </div>
        </section>
    </main>
    @stack('scripts')
</body>

</html>
