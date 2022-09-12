<?php

namespace App\Http\Controllers;
use App\Conference;
use Illuminate\Support\Facades\Auth;

class ConfListController extends Controller
{
    public function allData(){
        $userId = Auth::id();
        $conferences = new Conference;
        $data = $conferences->getPaginateConf($userId);
        return view('meeting', ['data' => $data]);
    }
}
