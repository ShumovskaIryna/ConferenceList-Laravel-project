<?php

namespace App\Http\Controllers;

use App\Events\AddCommentEvent;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Conference;
use App\Models\User;
use App\Exports\CommentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function export($confId, $reportId)
    {
        return Excel::download(new CommentsExport($confId, $reportId), 'comments.xlsx');
    }
    
    /**
    * Store a new conference.
    *
    * @param  \App\Http\Requests\StoreCommentRequest  $request
    * @return Illuminate\Http\Response
    */

    public function create($confId, $reportId, StoreCommentRequest $request)
    {
        $validated = $request->validated();

        $userId = Auth::id();

        $comment = new Comment();

        $comment->comment_message = $request->input('comment_message');
        $comment->created_by = $userId;
        $comment->report_id = $reportId;
        $comment->save();

        $report = new Report;
        $comments = new Comment;
        $conference = Conference::find($confId);
        $paginatedComments = $comments->getPaginateComments($userId, $confId, $reportId);
        $reportById = $report->getReportId($userId, $confId, $reportId);
        $reportOwner = User::find($reportById->created_by);
        event(new AddCommentEvent( $comment, $reportOwner));

        return Inertia::render('Reports/ReportDetails', [
            'report' => $reportById,
            'comments' => $paginatedComments,
            'conference' => $conference
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

    public function editSaveComment($confId, $reportId, $commentId,  StoreCommentRequest $request)
    {
        $validated = $request->validated();

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
