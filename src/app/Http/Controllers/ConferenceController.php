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
    public function create(Request $request){
        $validation = $request->validate([
            'title'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'position.lat'=> 'required|max:25',
            'position.lng'=> 'required|max:25',
            'countries'=> 'required'
        ]);
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
        if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
//        $isAnnouncer = Gate::allows('isAnnouncer');
//        $isListener = Gate::allows('isListener');
//        $canSeeConf = $isAnnouncer && $isListener
//        if ($canSeeConf) {
//            abort(403);
//        }
        $userId = Auth::id();
        $conferences = new Conference;
        $paginatedConferences = $conferences->getPaginateConf($userId);

        return Inertia::render('Conferences', [
            'conferences' => $paginatedConferences
        ]);
    }

    public function detailConference($confId)
    {
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
            abort(403, 'You are can not edit this conference');
        }
        return Inertia::render('Edit', [
            'conference' => Conference::findOrFail($id)
        ]);
    }
    public function editSaveConference( $id, Request $request){
        $validation = $request->validate([
            'title'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'position.lat'=> 'required|max:25',
            'position.lng'=> 'required|max:25',
            'countries'=> 'required'
        ]);
        $conferences = Conference::find($id);
        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('position.lat');
        $conferences->lng = $request->input('position.lng');
        $conferences->countries = $request->input('countries');
        $conferences->save();

        return Inertia::render('Details', [
            'conference' => Conference::findOrFail($id)
        ]);
    }
    public function deleteConference($id)
    {
        $userId = Auth::id();
        $conference = Conference::find($id);
         $isOwner = $conference->created_by === $userId;
         if (!Gate::allows('isAdmin') && !$isOwner) {
            abort(403, 'You are can not delete this conference');
         }
        $conference->delete();
        return Redirect::route('Conferences');
    }
    public function joinConference($id) {
        if (!Gate::allows('isAnnouncer') &
            !Gate::allows('isListener')) {
            abort(403);}
        $userId = Auth::id();

        $conferences = new ConferencesUsers();
        $conferences->join($id,$userId);
    }
    public function unjoinConference($id) {
        $userId = Auth::id();

        $conferences = new ConferencesUsers();
        $conferences->unjoin($id,$userId);
    }
}
