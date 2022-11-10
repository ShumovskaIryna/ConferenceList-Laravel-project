<?php

namespace App\Listeners;

use App\Mail\ReportTimeEdited;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\EditReportTimeEvent;

class EditReportTimeEventHandler implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Providers\EditReportTimeEvent  $event
     * @return void
     */
    public function handle(EditReportTimeEvent $event)
    {
        foreach($event->listeners as $listener) {
            Mail::to($listener->email)
            ->send(new ReportTimeEdited(
                $listener->first_name, 
                $event->conference->title, 
                $event->report->user->first_name, 
                $event->report->topic, 
                $event->report->time_start,
                $event->report->time_finish,
            ));
        }
    }
}