<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
{
    // Cek apakah pengguna sudah login
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Cek apakah level pengguna adalah admin
    if (Auth::user()->level !== 'admin') {
    
    
        return redirect()->route('buku.index'); // Ganti dengan route yang sesuai
    }

    return $next($request);
}
}
