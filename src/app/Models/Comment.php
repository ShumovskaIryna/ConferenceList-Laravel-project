<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }

    public function getPaginateComments($userId, $confId, $reportId)
    {
        $comments = $this->where('report_id', $reportId)
            ->with('user')
            ->with('report')
            ->paginate(10);
        foreach($comments as $comment)
        {
            $isOwn = $comment->created_by === $userId;
            $comment->isOwn = $isOwn;
        }
        return $comments;
    }
}
