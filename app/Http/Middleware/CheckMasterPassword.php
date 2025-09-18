<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMasterPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('master_authenticated')) {
            return $next($request);
        }

        if ($request->isMethod('post') && $request->password === env('MASTER_PASSWORD')) {
            $request->session()->put('master_authenticated', true);
            return redirect()->route('daftarabsensi.absensi');
        }

        return redirect()->route('daftarabsensi.loginAbsensi');
    }
}
