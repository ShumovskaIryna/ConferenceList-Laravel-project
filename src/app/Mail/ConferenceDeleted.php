<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($participant, $title)
    {
        $this->participant = $participant;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Conference was deleted by Admin')
            ->markdown('emails.conference-deleted');
    }
}
