<?php

namespace App\Http\Controllers;
use App\Conference;
use Illuminate\Http\Request;

class ConfListController extends Controller
{
    public function allData(){
        $conferences = new Conference;
        return view('meeting', ['data' => $conferences->paginate(15)]);
    }
}
