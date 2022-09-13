<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ConferencesMapUsers;

class ConferenceJoin extends Controller
{
    public function joinConf(Request $request) {
        $userId = Auth::id();

        $conferences = new ConferencesMapUsers();
        $confId = $request->input('conf_id');

        $conferences->join($confId,$userId);

        return redirect()->route('conferences_all')->with('success', 'You are join to conference 🥳');
    }
    public function unjoinConf(Request $request) {
        $userId = Auth::id();

        $conferences = new ConferencesMapUsers();
        $confId = $request->input('conf_id');

        $conferences->unjoin($confId,$userId);

        return redirect()->route('conferences_all')->with('success', 'You canceled join to conference 😱');
    }
}
