<?php

namespace App\Listeners;

use App\Events\KlijentOdabran;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class KlijentOdabran
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
        //
    }
}
