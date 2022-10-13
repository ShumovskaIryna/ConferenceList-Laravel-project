<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferencesUsers;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class ConferenceController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'title'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'position.lat'=> 'max:25',
            'position.lng'=> 'max:25',
            'countries'=> 'required'
        ]);
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
        $conferences->created_by = $userId;

        $conferences->save();

        $users = User::find($userId);

        $conferences->users()->attach($users, [
            'joined_at' => date('d-m-y h:i:s'),
        ]);
        return redirect(RouteServiceProvider::HOME);
    }

    public function getConferences()
    {
        $userId = Auth::id();

        $conferences = new Conference;

        $paginatedConferences = $conferences->getPaginateConf($userId);
        return Inertia::render('Conferences', [
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
        return Inertia::render('Details', [
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
        return Inertia::render('Edit', [
            'conference' => Conference::findOrFail($id)
        ]);
    }

    public function editSaveConference( $id, Request $request)
    {
        $request->validate([
            'title'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'position.lat'=> 'max:25',
            'position.lng'=> 'max:25',
            'countries'=> 'required'
        ]);
        $conferences = Conference::find($id);

        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('position.lat');
        $conferences->lng = $request->input('position.lng');
        $conferences->countries = $request->input('countries');
        $conferences->save();

        $userId = Auth::id();
        $conference = Conference::find($id);
        $isOwner = $conference->created_by === $userId;
        $conference->isOwn = $isOwner;
        return Inertia::render('Details', [
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
        return Redirect::route('Conferences');
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
        return Redirect::route('Conferences');
    }
}
