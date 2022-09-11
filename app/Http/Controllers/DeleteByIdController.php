<?php

namespace App\Http\Controllers;

use App\Conference;
use Illuminate\Http\Request;

class DeleteByIdController extends Controller
{
    public function deleteConferenceById($id){
        Conference::find($id)->delete();
        return redirect()->route('conferences_all')->with('success', 'Conference was deleted');
    }
}
