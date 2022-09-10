<?php

namespace App\Http\Controllers;
use App\Conference;
use Illuminate\Http\Request;

class ConfListController extends Controller
{
    public function allData(){
        return view('meeting', ['data' => Conference::all()]);
    }
}
