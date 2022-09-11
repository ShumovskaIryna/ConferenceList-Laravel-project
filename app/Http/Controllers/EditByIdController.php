<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Country;
use Illuminate\Http\Request;

class EditByIdController extends Controller
{
    public function editConferenceById($id)
    {
        $conferences = new Conference;
        return view('edit', ['data' => $conferences->find($id)]);
    }
    public function index($id)
    {
        $conferences = new Conference;

        $countries = Country::all();
        $data = $conferences->find($id);
        return view('edit', compact('countries', 'data'));

    }
    public function editConferenceByIdSave($id, Request $request){
        $validation = $request->validate
        ([
            'name'=> 'required|min:2|max:255',
            'date'=> 'required|date|after:today',
            'lat'=> 'required',
            'lng'=> 'required',
            'countries'=> 'required'
        ]);

        $conferences = Conference::find($id);
        $conferences->name = $request->input('name');
        $conferences->date = $request->input('date');
        $conferences->lat = $request->input('lat');
        $conferences->lng = $request->input('lng');
        $conferences->countries = $request->input('countries');
        $conferences->save();

        return redirect()->route('detail', $id)->with('success', 'Conference was edited');

    }
}
