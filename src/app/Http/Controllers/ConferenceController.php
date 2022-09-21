<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
