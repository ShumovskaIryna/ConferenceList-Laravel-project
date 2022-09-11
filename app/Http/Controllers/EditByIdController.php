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
//    public function index()
//    {
//        $countries = Country::all();
//        return view('edit', compact('countries'));
//
//    }
}
