<?php

namespace App\Http\Controllers;

use App\Conference;
use Illuminate\Http\Request;

class ConfByIdController extends Controller
{
    public function showConferenceById($id){
        $conferences = new Conference;
        return view('detail', ['data' => $conferences->find($id)]);
    }
}
