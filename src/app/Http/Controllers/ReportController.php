<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ConferencesUsers;
use App\Models\Conference;
use App\Models\ReportsUsers;
use App\Models\Report;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\FilterReportRequest;
use App\Events\EditReportTimeEvent;
use App\Events\AddAnnouncerEvent;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    public $FILE_PATH = 'files/presentation/';

    /**
    * @return \Illuminate\Support\Collection
    */

    public function export($confId) 
    {
        return Excel::download(new ReportsExport($confId), 'reports.xlsx');
    }

    /**
     * Store a new report.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return Illuminate\Http\Response
     */

    public function create($confId, $categoryId)
    {
        $conference = Conference::find($confId);
        $categories = Category::with('children')
        ->where('category_id', $categoryId)
        ->orWhere('id', $categoryId)
        ->get();
       return Inertia::render('Reports/ReportForm', [
            'categories' => $categories,
            'conference' => $conference
       ]);
    }

    public function store ($confId, StoreReportRequest $request)
    {
        $userId = Auth::id();

        $validated = $request->validated();

        if (!Gate::allows('isAnnouncer')) {
            abort(403, 'Create report can Announcer only' );
        }
        $time_start = $request->input('time_start');
        $time_finish = $request->input('time_finish');

        $isTimeBooked = Report::where(function ($query) use ($time_start) {
            $query->where('time_start', '<', $time_start)
                  ->where('time_finish', '>', $time_start);
        })
        ->orWhere(function ($query) use ($time_finish) {
            $query->where('time_start', '<', $time_finish)
                  ->where('time_finish', '>', $time_finish);
        })
        ->leftJoin('conferences', function ($leftJoin) use ($time_start) {
            $leftJoin
                ->on('conferences.id', '=', 'reports.conference_id');   
        })
        ->orWhere(function ($query) use($time_start) {
            $query->where('conferences.date', '>', $time_start);
        })
        ->get();

        if (count($isTimeBooked)){
            throw ValidationException::withMessages([
                'time_start' => 
                    'Try this time '.$isTimeBooked[0]->time_finish.'. Conference start at '.$isTimeBooked[0]->date
            ]);
        }
        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();

        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $filesystem = Storage::disk('local');
        $filesystem->putFileAs(
            $this->FILE_PATH.$userId,
            $uploadedFile,
            $filename
        );

        $report = new Report();
        $report->topic = $request->input('topic');
        $report->time_start = $request->input('time_start');
        $report->time_finish = $request->input('time_finish');
        $report->description = $request->input('description');
        $report->file_path = $this->FILE_PATH.$userId.'/'.$filename;
        $report->category = $request->input('category');
        $report->created_by = $userId;
        $report->conference_id = $confId;

        $report->save();

        $conferences = new ConferencesUsers();
        $conferences->join($confId, $userId);

        $conference = Conference::find($confId);
        $listeners = User::where('users.role', '=', 'LISTENER')
        ->leftJoin('conferences_users', function($leftJoin) {
            $leftJoin
                ->on('conferences_users.user_id', '=', 'users.id');
        })
        ->where('conferences_users.conference_id', '=', $confId)
        ->select('users.*')
        ->get();
        
        event(new AddAnnouncerEvent( $report, $conference, $listeners));

        return Redirect::route('conference_details', $confId);
    }

    public function getReports($confId, FilterReportRequest $request)
    {
        if (!Gate::allows('isAnnouncer') &&
            !Gate::allows('isListener') &&
            !Gate::allows('isAdmin')) {
            return Redirect::route('register');
        }

        $selectedCategories = $request->query('selectedCategories');
        $timeReport = $request->query('timeReport');
        $durationReport = $request->query('durationReport');

        $userId = Auth::id();

        $reports = new Report;

        $paginatedReports = $reports->getPaginateReports(
            $userId, 
            $confId,
            $durationReport,
            $selectedCategories,
            $timeReport
        );
        $categories = Category::all();
        return Inertia::render('Reports/ReportsList', [
            'reports' => $paginatedReports,
            'categories' => $categories,
            'durationReport' => $durationReport,
            'timeReport' => $timeReport,
            'selectedCategories' => $selectedCategories
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
        $conference = Conference::find($confId);
        $comments = new Comment;
        $paginatedComments = $comments->getPaginateComments($userId, $confId, $reportId);
        $reportById = $report->getReportId($userId, $confId, $reportId);
        return Inertia::render('Reports/ReportDetails', [
            'report' => $reportById,
            'comments' => $paginatedComments,
            'conference' => $conference
        ]);
    }

    public function editReport($confId, $reportId, $categoryId)
    {
         $categories = Category::with('children')
         ->where('category_id', $categoryId)
         ->orWhere('id', $categoryId)
         ->get();
        $conference = Conference::find($confId);
        return Inertia::render('Reports/ReportEdit', [
            'report' => Report::findOrFail($reportId),
            'categories' => $categories,
            'conference' => $conference
        ]);
    }
    
    public function editSaveReport($confId, $reportId, StoreReportRequest $request)
    {
        $userId = Auth::id();

        $validated = $request->validated();

        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();

        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $filesystem = Storage::disk('local');
        $filesystem->putFileAs(
            $this->FILE_PATH.$userId,
            $uploadedFile,
            $filename
        );

        $report = Report::find($reportId);
        $conference = Conference::find($confId);
        $listeners = User::where('users.role', '=', 'LISTENER')
        ->leftJoin('conferences_users', function($leftJoin) {
            $leftJoin
                ->on('conferences_users.user_id', '=', 'users.id');
        })
        ->where('conferences_users.conference_id', '=', $confId)
        ->select('users.*')
        ->get();

        if(strtotime($report->time_start) !== strtotime($request->input('time_start')) ||
        strtotime($report->time_finish) !== strtotime($request->input('time_finish'))) {
            event(new EditReportTimeEvent( $report, $conference, $listeners));
        }

        $report->topic = $request->input('topic');
        $report->time_start = $request->input('time_start');
        $report->time_finish = $request->input('time_finish');
        $report->description = $request->input('description');
        $report->file_path = $this->FILE_PATH . $userId . '/' . $filename;
        $report->category = $request->input('category');
        $report->save();

        $comments = new Comment;
        $paginatedComments = $comments->getPaginateComments($userId, $confId, $reportId);
        $reportById = $report->getReportId($userId, $confId, $reportId);

        return Inertia::render('Reports/ReportDetails', [
            'report' => $reportById,
            'comments' => $paginatedComments,
            'conference' => $conference
        ]);
    }

    public function likeReport($confId, $reportId)
    {
        $userId = Auth::id();
        $report = new ReportsUsers();
        $report->like($reportId, $userId);
    }

    public function unlikeReport($confId, $reportId)
    {
        $userId = Auth::id();
        $report = new ReportsUsers();
        $report->unlike($reportId, $userId);
    }


    public function getFavReports()
    {
        if (!Gate::allows('isAnnouncer') &&
            !Gate::allows('isListener') &&
            !Gate::allows('isAdmin')) {
            return Redirect::route('register');
        }
        $userId = Auth::id();
        $reports = new Report;
        $conferences = new Conference;
        $favoriteReports = $reports->getFavoritesReports($userId);

        return Inertia::render('Reports/ReportsFavoritesList', [
            'reports' => $favoriteReports
        ]);
    }
}
