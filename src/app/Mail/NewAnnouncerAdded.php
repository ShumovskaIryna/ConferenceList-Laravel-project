<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAnnouncerAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $conf_title;
    public $report_author;
    public $report_topic;
    public $new_time_start;
    public $new_time_finish;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $conf_title, $report_author, $report_topic, $new_time_start, $new_time_finish)
    {
        $this->name = $name;
        $this->conf_title = $conf_title;
        $this->report_author = $report_author;
        $this->report_topic = $report_topic;
        $this->new_time_start = $new_time_start;
        $this->new_time_finish = $new_time_finish;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New report')
            ->markdown('emails.new-announcer');
    }
}
