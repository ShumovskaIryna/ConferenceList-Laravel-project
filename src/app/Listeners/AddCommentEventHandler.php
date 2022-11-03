<?php

namespace App\Listeners;

use App\Mail\NewCommentAdded;
use Illuminate\Support\Facades\Mail;
use App\Events\AddCommentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommentEventHandler implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AddCommentEvent  $event
     * @return void
     */
    public function handle(AddCommentEvent $event)
    {
        Mail::to($event->reportOwner->email)
        ->send(new NewCommentAdded($event->reportOwner->first_name, '-Conference title-', $event->comment->user->first_name, $event->comment->report->topic));
    }
}
