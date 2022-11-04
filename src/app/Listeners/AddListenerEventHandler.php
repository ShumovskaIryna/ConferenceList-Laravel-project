<?php

namespace App\Listeners;

use App\Mail\NewListenerAdded;
use Illuminate\Support\Facades\Mail;
use App\Events\AddListenerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddListenerEventHandler implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AddListenerEvent  $event
     * @return void
     */
    public function handle(AddListenerEvent $event)
    {
        foreach($event->announcers as $announcer) {
            Mail::to($announcer->email)
            ->send(new NewListenerAdded(
                $event->conference->title,
                $event->listener->first_name,
                $announcer->first_name,
            ));
        }
    }
}
