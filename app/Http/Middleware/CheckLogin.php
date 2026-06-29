<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Izinkan halaman login dan register diakses tanpa login
        if (
            !$request->session()->has('login') &&
            !$request->is('login') &&
            !$request->is('register')
        ) {
            return redirect('/login');
        }

        return $next($request);
    }


}
