<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConferencesMapUsers extends Model
{
    protected $table = "conferences_map_users";
    public $timestamps = false;

    public function join($conferenceId, $userId) {
        $confMapUser = new ConferencesMapUsers();

        $confMapUser->user_id = $userId;
        $confMapUser->conference_id = $conferenceId;
        $confMapUser->joined_at = date('d-m-y h:i:s');

        $confMapUser->save();
    }
}
