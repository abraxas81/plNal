<?php

namespace App\Http\Middleware;

use Closure;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HasKlijentSession
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
        if (session('klijentId') == null)
        {
            Flash::error('Klijent nije odabran');
            Log::warning(Auth::user()->name. 'nije odabrao klijenta');
            return redirect("welcome");
        }

        return $next($request);
    }
}
