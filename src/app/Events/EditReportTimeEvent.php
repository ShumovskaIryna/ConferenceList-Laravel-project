<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Report;

class EditReportTimeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $report;
    public $conference;
    public $listeners;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Report $report, $conference, $listeners)
    {
        $this->report = $report;
        $this->conference = $conference;
        $this->listeners = $listeners;
    }
}
