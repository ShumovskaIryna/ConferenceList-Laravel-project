<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
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
        $conferences = new Conference();
        $conferences->title = $request->input('title');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('lat');
        $conferences->lng = $request->input('lng');
        $conferences->countries = $request->input('countries');
        $conferences->save();

        return redirect(RouteServiceProvider::HOME);
    }
    public function getConferences(){
        $conferences = Conference::all();
        return response()->json($conferences);
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
}
