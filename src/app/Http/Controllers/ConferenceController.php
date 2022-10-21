<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferencesUsers;
use App\Models\User;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\StoreConferenceRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class ConferenceController extends Controller
{

    /**
     * Store a new conference.
     *
     * @param  \App\Http\Requests\StoreConferenceRequest  $request
     * @return Illuminate\Http\Response
     */

    public function store(StoreConferenceRequest $request)
    {
        $validated = $request->validated();

        $isAnnouncer = Gate::allows('isAnnouncer');
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAnnouncer || $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Create conference can Admin and Announcer only' );
        }
        $userId = Auth::id();

        $conferences = new Conference();

        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('position.lat');
        $conferences->lng = $request->input('position.lng');
        $conferences->countries = $request->input('countries');
        $conferences->category = $request->input('category');
        $conferences->created_by = $userId;

        $conferences->save();

        $users = User::find($userId);

        $conferences->users()->attach($users, [
            'joined_at' => date('d-m-y h:i:s'),
        ]);
        return redirect(RouteServiceProvider::HOME);
    }

    public function create()
    {
        $isAnnouncer = Gate::allows('isAnnouncer');
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAnnouncer || $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Create conference can Admin and Announcer only' );
        }
        $countries = Country::all();
        $categories = Category::all();
        return Inertia::render('Conferences/Create', [
            'countries' => $countries,
            'categories' => $categories
        ]);
    }

    public function getConferences()
    {
        $userId = Auth::id();

        $conferences = new Conference;

        $paginatedConferences = $conferences->getPaginateConf($userId);
        return Inertia::render('Conferences/Conferences', [
            'conferences' => $paginatedConferences
        ]);
    }

    public function detailConference($confId)
    {
        if (!Gate::allows('isAnnouncer') &&
        !Gate::allows('isListener') &&
        !Gate::allows('isAdmin')){
            return Redirect::route('register');
        }

        $userId = Auth::id();

        $conference = new Conference();

        $idConference = $conference->getConfId($userId, $confId);
        return Inertia::render('Conferences/Details', [
            'conference' => $idConference
        ]);
    }

    public function editConference($id)
    {
        $userId = Auth::id();

        $conference = Conference::find($id);

        $isOwner = $conference->created_by === $userId;
        if (!Gate::allows('isAdmin') && !$isOwner) {
            abort(403, 'You can not edit this conference');
        }
        $categories = Category::all();
        $countries = Country::all();
        return Inertia::render('Conferences/Edit', [
            'countries' => $countries,
            'conference' => Conference::findOrFail($id),
            'categories' => $categories
        ]);
    }

    public function editSaveConference( $id, StoreConferenceRequest  $request)
    {
        $validated = $request->validated();
        $conferences = Conference::find($id);

        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('position.lat');
        $conferences->lng = $request->input('position.lng');
        $conferences->countries = $request->input('countries');
        $conferences->category = $request->input('category');
        $conferences->save();

        $userId = Auth::id();
        $conference = Conference::find($id);
        $isOwner = $conference->created_by === $userId;
        $conference->isOwn = $isOwner;
        return Inertia::render('Conferences/Details', [
            'conference' => $conference,
        ]);
    }

    public function deleteConference($id)
    {
        $userId = Auth::id();
        $conference = Conference::find($id);
        $isOwner = $conference->created_by === $userId;
        if (!Gate::allows('isAdmin') && !$isOwner) {
            abort(403, 'You can not delete this conference');
        }
        $conference->delete();
        return Redirect::route('conferences_list');
    }

    public function joinConference($id)
    {
        if (!Gate::allows('isAnnouncer') &&
            !Gate::allows('isListener')){
            return Redirect::route('register');
        }
        $userId = Auth::id();
        $conferences = new ConferencesUsers();
        $conferences->join($id,$userId);
    }

    public function unjoinConference($id)
    {
        $userId = Auth::id();
        $conferences = new ConferencesUsers();
        $conferences->unjoin($id,$userId);
        return Redirect::route('conferences_list');
    }
}
