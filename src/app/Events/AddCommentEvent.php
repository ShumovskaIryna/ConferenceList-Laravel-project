<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddCommentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $comment;
    public $reportOwner;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $reportOwner)
    {
        $this->comment = $comment;
        $this->reportOwner = $reportOwner;
    }
}
