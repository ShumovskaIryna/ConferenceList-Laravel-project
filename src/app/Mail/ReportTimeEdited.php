<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportTimeEdited extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $conf_title;
    public $report_author;
    public $report_topic;
    public $new_time_start;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($name, $conf_title, $report_author, $report_topic, $new_time_start)
    {
        $this->name = $name;
        $this->conf_title = $conf_title;
        $this->comment_author = $report_author;
        $this->report_topic = $report_topic;
        $this->new_time_start = $new_time_start;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Edit time report')
            ->markdown('emails.report-time-edited');
    }
}
