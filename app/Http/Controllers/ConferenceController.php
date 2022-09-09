<?php

namespace App\Http\Controllers;
use App\Conference;
use Illuminate\Http\Request;


class ConferenceController extends Controller
{
    public function create(Request $request){
       $validation = $request->validate([
           'name'=> 'required|min:2|max:255',
           'date'=> 'required|date|after:today',
       ]);
       $conferences =new Conference();
       $conferences->name = $request->input('name');
       $conferences->date = $request->input('date');
       $conferences->save();

       return redirect()->route('conferences_all')->with('success', 'Conference was created');

    }
    public function allData(){
        return view('messages', ['data' => Conference::all()]);
    }
}
