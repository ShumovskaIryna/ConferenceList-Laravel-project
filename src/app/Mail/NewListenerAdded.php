<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewListenerAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $conf_title;
    public $new_listener;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conf_title, $new_listener, $name)
    {
        $this->name = $name;
        $this->conf_title = $conf_title;
        $this->new_listener = $new_listener;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('You have new listener')
            ->markdown('emails.new-listener');
    }
}
