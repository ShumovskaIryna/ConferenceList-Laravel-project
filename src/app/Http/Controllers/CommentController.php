<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function create($confId, $reportId, Request $request)
    {
        $request->validate([
            'comment_message'=> 'required|min:2|max:255',
        ]);

        $userId = Auth::id();

        $comment = new Comment();

        $comment->comment_message = $request->input('comment_message');
        $comment->created_by = $userId;
        $comment->report_id = $reportId;
        $comment->save();

        $report = new Report;
        $comments = new Comment;
        $paginatedComments = $comments->getPaginateComments($userId, $confId, $reportId);
        $reportById = $report->getReportId($userId, $confId, $reportId);
        return Inertia::render('Reports/ReportDetails', [
            'report' => $reportById,
            'comments' => $paginatedComments
        ]);
    }

    public function delete($confId, $reportId, $commentId)
    {
        $userId = Auth::id();

        $comment = Comment::find($commentId);
        $isOwner = $comment->created_by === $userId;

        if (!Gate::allows('isAdmin') && !$isOwner) {
            abort(403, 'You can not delete this comment');
        }

        Comment::where('id', $commentId)
            ->delete();

        return Redirect::route('report_details', [$confId, $reportId, $commentId]);
    }

    public function edit($confId, $reportId, $commentId)
    {
        $userId = Auth::id();

        $comment = Comment::find($commentId);

        $isOwner = $comment->created_by === $userId;
        $ALLOWED_TIME_FOR_UPDATE = 10 * 60 * 1000;

        $isTimeValid = time() < (strtotime($comment->updated_at) + $ALLOWED_TIME_FOR_UPDATE);

        if (!$isTimeValid || !$isOwner) {

            abort(403, 'You can not edit this comment');
        }
        $report = new Report;
        $reportById = $report->getReportId($userId, $confId, $reportId);
        return Inertia::render('Reports/CommentEdit', [
            'report' => $reportById,
            'comment' => Comment::findOrFail($commentId)
        ]);
    }

    public function editSaveComment($confId, $reportId, $commentId,  Request $request)
    {
        $request->validate([
            'comment_message'=> 'required|min:2|max:255',
        ]);

        $userId = Auth::id();

        $comment = Comment::find($commentId);

        $isOwner = $comment->created_by === $userId;

        $ALLOWED_TIME_FOR_UPDATE = 10 * 60 * 1000;

        $isTimeValid = time() < (strtotime($comment->updated_at) + $ALLOWED_TIME_FOR_UPDATE);

        if (!$isTimeValid || !$isOwner) {

            abort(403, 'You can not edit this comment');
        }

        $comment->comment_message = $request->input('comment_message');
        $comment->save();
        
        return Redirect::route('report_details', [$confId, $reportId, $commentId]);
    }
}
