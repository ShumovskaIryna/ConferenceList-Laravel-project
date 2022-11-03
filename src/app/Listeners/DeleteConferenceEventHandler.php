<?php

namespace App\Listeners;

use App\Mail\ConferenceDeleted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\DeleteConferenceEvent;

class DeleteConferenceEventHandler implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\DeleteConferenceEvent  $event
     * @return void
     */
    public function handle(DeleteConferenceEvent $event)
    {
        $conference = $event->conference;

        foreach($event->participants as $participant) {
            Mail::to($participant->email)
            ->send(new ConferenceDeleted($participant->first_name, $conference->title));
            }
    }
}
