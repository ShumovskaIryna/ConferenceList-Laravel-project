<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function create($reportId, Request $request)
    {
        $request->validate([
            'comment'=> 'required|min:2|max:255',
        ]);

        $userId = Auth::id();

        $comment = new Comment();

        $comment->comment = $request->input('comment');
        $comment->created_by = $userId;
        $comment->report_id = $reportId;
        $comment->save();
    }

    public function getComments($userId, $reportId)
    {
        $comments = new Comment;

        $paginatedComments = $comments->getPaginateComments($userId, $reportId);

        return Inertia::render('Reports/ReportDetails', [
            'comments' => $paginatedComments
        ]);
    }
}
