<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $confUser->joined_at = date('d-m-y h:i:s');
        $confUser->save();
    }

    public function unjoin($conferenceId, $userId)
    {
        $confUser = new ConferencesUsers();
        $confUser->user_id = $userId;
        $confUser->conference_id = $conferenceId;
        $confUser->joined_at = null;
        $confUser->save();
    }
}
