<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Country;
use Illuminate\Http\Request;

class CreateFormController extends Controller
{
    public function create(Request $request){
        $validation = $request->validate([
            'name'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'lat'=> 'required',
            'lng'=> 'required',
            'countries'=> 'required'
        ]);

        $conferences = new Conference();
        $conferences->name = $request->input('name');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('lat');
        $conferences->lng = $request->input('lng');
        $conferences->countries = $request->input('countries');
        $conferences->save();

        return redirect()->route('conferences_all')->with('success', 'Conference was created');

    }

    public function index()
    {
        $countries = Country::all();

        return view('create', compact('countries'));

    }
}
