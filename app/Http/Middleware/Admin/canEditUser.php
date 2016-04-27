<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;

class canEditUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->hasRole('Admin|SuperAdmin')){
            return $next($request);
        }
        Flash::error('Nemate prava vidjeti ovu stranicu');
        Log::warning(Auth::user()->name. ' pokušao je pristupiti url-u '.$request->path().' za koji nema prava pristupa');
        return $next($request);
    }
}
