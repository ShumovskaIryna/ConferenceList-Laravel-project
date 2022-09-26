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

class ConferenceController extends Controller
{
    public function create(Request $request){
        $validation = $request->validate([
            'title'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'lat'=> 'required|max:25',
            'lng'=> 'required|max:25',
            'countries'=> 'required'
        ]);
        $userId = Auth::id();

        $conferences = new Conference();
        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('lat');
        $conferences->lng = $request->input('lng');
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
//        fwrite(STDOUT, 4444);
        $userId = Auth::id();
        $conferences = new Conference;
        $paginatedConferences = $conferences->getPaginateConf($userId);
//        fwrite(STDOUT, $paginatedConferences);

        return Inertia::render('Conferences', [
            'conferences' => $paginatedConferences
        ]);
    }

    public function detailConference($id)
    {
        return Inertia::render('Details', [
            'conference' => Conference::findOrFail($id)
        ]);
    }
    public function editConference($id)
    {
        return Inertia::render('Edit', [
            'conference' => Conference::findOrFail($id)
        ]);
    }
    public function editSaveConference( $id, Request $request){
        $validation = $request->validate([
            'title'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'lat'=> 'required|max:25',
            'lng'=> 'required|max:25',
            'countries'=> 'required'
        ]);
        $conferences = Conference::find($id);
        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('lat');
        $conferences->lng = $request->input('lng');
        $conferences->countries = $request->input('countries');
        $conferences->save();

        return Inertia::render('Details', [
            'conference' => Conference::findOrFail($id)
        ]);
    }
    public function deleteConference($id)
    {
        Conference::find($id)->delete();
        return Redirect::route('Conferences');
    }
    public function joinConference($id) {
        $userId = Auth::id();

        $conferences = new ConferencesUsers();
        $conferences->join($id,$userId);
        return Redirect::route('Conferences');
    }
    public function unjoinConference($id) {
        $userId = Auth::id();

        $conferences = new ConferencesUsers();
        $conferences->unjoin($id,$userId);
        return Redirect::route('Conferences');
    }
}
