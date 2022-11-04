<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conference;

class AddListenerEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $listener;
    public $conference;
    public $announcers;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conference $conference, $listener, $announcers)
    {
        $this->conference = $conference;
        $this->listener = $listener;
        $this->announcers = $announcers;
    }
}
