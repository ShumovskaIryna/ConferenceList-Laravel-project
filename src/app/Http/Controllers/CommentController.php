<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create($confId, $reportId, Request $request)
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
}
