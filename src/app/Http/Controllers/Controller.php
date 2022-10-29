<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\SearchReportConfRequest;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\Conference;
use App\Models\Report;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getSearchList(SearchReportConfRequest $request)
    {
        $request->validated();

        $requestSearch = $request->requestSearch;

        $conferences = Conference::where('title', 'like', "%$requestSearch%")->get();
        $reports = Report::where('topic', 'like', "%$requestSearch%")->get();

        return Inertia::render('SearchCR', [
            'conferences' => $conferences,
            'reports' => $reports,
        ]);
    }
}
