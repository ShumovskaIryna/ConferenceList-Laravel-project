<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ConferencesUsers;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public $FILE_PATH = 'files/presentation/';

    public function create($confId, Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'topic'=> 'required|min:2|max:255',
            'time_start'=> 'required|date',
            'time_finish'=> 'required|date',
            'description'=> 'required|string',
            'file' => 'required|file|mimes:html',
        ]);

        if (!Gate::allows('isAnnouncer')) {
            abort(403, 'Create report can Announcer only' );
        }
        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            $this->FILE_PATH.$userId,
            $uploadedFile,
            $filename
        );

        $reports = new Report();
        $reports->topic = $request->input('topic');
        $reports->time_start = $request->input('time_start');
        $reports->time_finish = $request->input('time_finish');
        $reports->description = $request->input('description');
        $reports->file_path = $this->FILE_PATH.$userId.'/'.$filename;
        $reports->created_by = $userId;
        $reports->conference_id = $confId;

        $reports->save();

        $conferences = new ConferencesUsers();
        $conferences->join($confId, $userId);

        return Redirect::route('Details', $confId);
    }

    public function getReports($confId)
    {
        if (!Gate::allows('isAnnouncer') &&
            !Gate::allows('isListener') &&
            !Gate::allows('isAdmin')) {
            return Redirect::route('register');
        }
        $userId = Auth::id();

        $reports = new Report;

        $paginatedReports = $reports->getPaginateReports($userId, $confId);

        return Inertia::render('Reports/ReportsList', [
            'reports' => $paginatedReports
        ]);
    }

    public function detailReport($confId, $reportId)
    {
        if (!Gate::allows('isAnnouncer') &&
            !Gate::allows('isListener') &&
            !Gate::allows('isAdmin')){
            return Redirect::route('register');
        }

        $userId = Auth::id();

        $report = new Report;

        $comments = new Comment;
        $paginatedComments = $comments->getPaginateComments($userId, $confId, $reportId);
        $reportById = $report->getReportId($userId, $confId, $reportId);
        return Inertia::render('Reports/ReportDetails', [
            'report' => $reportById,
            'comments' => $paginatedComments
        ]);
    }

    public function editReport($confId, $reportId)
    {
            return Inertia::render('Reports/ReportEdit', [
            'report' => Report::findOrFail($reportId)
        ]);
}
    public function editSaveReport($confId, $reportId, Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'topic'=> 'required|min:2|max:255',
            'time_start'=> 'required|date',
            'time_finish'=> 'required|date',
            'description'=> 'required|string',
            'file' => 'required|file|mimes:html',
        ]);

        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            $this->FILE_PATH.$userId,
            $uploadedFile,
            $filename
        );

        $report = Report::find($reportId);

        $report->topic = $request->input('topic');
        $report->time_start = $request->input('time_start');
        $report->time_finish = $request->input('time_finish');
        $report->description = $request->input('description');
        $report->file_path = $this->FILE_PATH . $userId . '/' . $filename;
        $report->save();

        $comments = new Comment;
        $paginatedComments = $comments->getPaginateComments($userId, $confId, $reportId);
        $reportById = $report->getReportId($userId, $confId, $reportId);
        return Inertia::render('Reports/ReportDetails', [
            'report' => $reportById,
            'comments' => $paginatedComments
        ]);
    }
}
