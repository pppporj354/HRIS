<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        // hapus session authenticated as master jika login ke fitur utama
        $request->session()->forget('master_authenticated');

        // validate input data (accept either email or username)
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // determine whether login input is email or username
        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // prepare credentials for authentication
        $authCredentials = [
            $loginField => $credentials['login'],
            'password' => $credentials['password'],
        ];

        // store temporary data login
        $data = $request->all();

        // attempt to authenticate user
        if (Auth::attempt($authCredentials)) {
            if (isset($data['rememberme']) && !empty($data['rememberme'])) {
                setcookie("login", $data['login'], time() + 172800);
            } else {
                setcookie("login", "", time() - 3600);
            }

            // Set pesan status ke session dan regenerate session
            $request->session()->flash('status', 'Anda telah berhasil login!');
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login' => 'Data login yang masukkan tidak valid, cek email / username dan password yang anda masukkan.',
        ])->onlyInput('login');
    }
}
