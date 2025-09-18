<!DOCTYPE html>
<html class="h-100 w-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HRIS IGI</title>
    <link rel="shortcut icon" href="{{ asset('igi_logo.png') }}" type="image/x-icon">
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" w-100 h-100">
    <main class="h-100 w-100">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Human Resource Information System PT.
                                Indo Global Impex</h3>
                        </div>
                        <div class="card-body">
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
                                {{-- password div --}}
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('login') is-invalid @enderror" id="password"
                                        type="password" name="password" placeholder="Password"
                                        autocomplete="current-password" value="{{ old('password') }}" required />
                                    <label for="password">Password</label>
                                </div>
                                {{-- end password div --}}
                                <div class="form-check mb-3">
                                    <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                        name="rememberme" value="on" checked />
                                    <label class="form-check-label" for="inputRememberPassword">Remember
                                        Me</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>
