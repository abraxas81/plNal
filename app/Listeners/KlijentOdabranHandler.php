<?php

namespace App\Listeners;

use App\Events\KlijentOdabran;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;

class KlijentOdabranHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  KlijentOdabran  $event
     * @return void
     */
    public function handle(KlijentOdabran $event)
    {
        Session::put('klijentId', $event->klijent->id);
        Flash::success('Klijent je odabran');
    }
}
