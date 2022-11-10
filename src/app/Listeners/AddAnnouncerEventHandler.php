<?php

namespace App\Listeners;

use App\Mail\NewAnnouncerAdded;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\AddAnnouncerEvent;

class AddAnnouncerEventHandler implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AddAnnouncerEvent  $event
     * @return void
     */
    public function handle(AddAnnouncerEvent $event)
    {
        foreach($event->listeners as $listener) {
            Mail::to($listener->email)
            ->send(new NewAnnouncerAdded(
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
