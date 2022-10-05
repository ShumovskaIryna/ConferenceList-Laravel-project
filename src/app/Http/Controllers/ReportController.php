<?php

namespace App\Http\Controllers;

use App\Models\ConferencesUsers;
use App\Models\Report;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function create($confId, Request $request)
    {
        $request->validate([
            'topic'=> 'required|min:2|max:255',
            'time_start'=> 'required|date',
            'time_finish'=> 'required|date',
            'description'=> 'required|string|max:5000',
            'presentation'=> '',
        ]);

        if (!Gate::allows('isAnnouncer')) {
            abort(403, 'Create report can Announcer only' );
        }
        $userId = Auth::id();

        $reports = new Report();
        $reports->topic = $request->input('topic');
        $reports->time_start = $request->input('time_start');
        $reports->time_finish = $request->input('time_finish');
        $reports->description = $request->input('description');
        $reports->file_path = $request->input('file');
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
}
