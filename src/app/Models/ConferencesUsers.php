<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ConferencesUsers extends Model
{
    use HasFactory;
    protected $table = "conferences_users";
    public $timestamps = false;

    public function join($conferenceId, $userId)
    {
        $confUser = new ConferencesUsers();
        $confUser->user_id = $userId;
        $confUser->conference_id = $conferenceId;
        $confUser->joined_at = Carbon::now();
        $confUser->save();
    }

    public function unjoin($conferenceId, $userId)
    {
        ConferencesUsers::where('user_id', $userId)
            ->where('conference_id', $conferenceId)
            ->delete();

        Report::where('created_by', $userId)
            ->where('conference_id', $conferenceId)
            ->delete();
    }
}
