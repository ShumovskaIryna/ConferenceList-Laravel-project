<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    /**
     * The users that belong to the conferences.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conferences_map_users');
    }

    /**
     * to pivote
     */
    public function conferencesMapUsers() {
        return $this->hasMany(ConferencesMapUsers::class, 'conference_id', 'id');
    }
    /**
     *
     */
    public function getPaginateConf($userId) {
        $conferences = $this->with('conferencesMapUsers')->paginate(15);
        if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));


        foreach($conferences as $conf) {
            fwrite(STDOUT, $conf);

            $isOwn = $conf->created_by === $userId;
            $conf->isOwn = $isOwn;

            $confMapUsers = $conf->conferencesMapUsers;;


            if(empty($confMapUsers)) {
                continue;
            }

            foreach($confMapUsers as $additionalData) {
                $isAlreadyJoined = $additionalData->user_id === $userId
                    && $additionalData->joined_at
                    && $additionalData->conference_id === $conf->id;

                $conf->isAlreadyJoined = $isAlreadyJoined;
            }


        }
        return $conferences;
    }
}
