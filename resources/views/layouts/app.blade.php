<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('igi_logo.png') }}" type="image/x-icon">
    <title>Human Resources Information System PT. IGI - Admin / Employee</title>
    @vite('resources/js/jquery.js')
    @vite('resources/js/app.js')
    @vite('resources/js/sidebar.js')
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/css/dashboard.css'])
    @yield('css')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .row {
            flex-grow: 1;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    @include('layouts.header')
    <div class="container-fluid flex-grow-1 d-flex">
        <div class="row flex-fill">
            @include('layouts.sidenav')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    @include('sweetalert::alert')
    @stack('scripts')

</body>

</html>
