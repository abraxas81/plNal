<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;

class canEdit
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
        if(Auth::user()->can('edit')){
            return $next($request);
        }
        Flash::error('Nemate prava vidjeti ovu stranicu');
        Log::warning(Auth::user()->name. ' pokušao je pristupiti url-u '.$request->path().' za koji nema prava pristupa');
        return redirect('home');
    }
}
