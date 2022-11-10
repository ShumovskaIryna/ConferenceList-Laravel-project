<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $conf_title;
    public $comment_author;
    public $report_topic;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($name, $conf_title, $comment_author, $report_topic)
    {
        $this->name = $name;
        $this->conf_title = $conf_title;
        $this->comment_author = $comment_author;
        $this->report_topic = $report_topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New comment on your report')
            ->markdown('emails.new-comment');
    }
}
