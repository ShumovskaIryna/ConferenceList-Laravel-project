<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conference;

class DeleteConferenceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $conference;
    public $participants;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conference $conference, $participants)
    {
        $this->conference = $conference;
        $this->participants = $participants;
    }
}
