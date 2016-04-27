<?php

namespace App\Events;

use App\Klijent;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class KlijentOdabran extends Event
{
    use SerializesModels;

    public $klijent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Klijent $klijent)
    {
        $this->klijent = $klijent;
    }

}
