<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $userId = Auth::id();

        $conferences = new Conference();
        $conferences->name = $request->input('name');
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

        return redirect()->route('conferences_all')->with('success', 'Conference was created');

    }

    public function index()
    {
        $countries = Country::all();
        return view('create', compact('countries'));
    }
}
