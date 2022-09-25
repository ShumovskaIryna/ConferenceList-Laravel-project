<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
    /**
     * The users that belong to the conferences.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conferences_users');
    }
    /**
     * to pivote
     */
    public function conferencesUsers() {
        return $this->hasMany(
            ConferencesUsers::class, 'conference_id', 'id');
    }
    /**
     *
     */
    public function getPaginateConf($userId) {
        $conferences = $this->with('conferencesUsers')->paginate(15);
        if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));

        foreach($conferences as $conf) {
            fwrite(STDOUT, $conf);

            $isOwn = $conf->created_by === $userId;
            $conf->isOwn = $isOwn;
        }
        $confUsers = $conf->conferencesUsers;

//        if(empty($confUsers)) {
//            continue;
//        }
        foreach($confUsers as $additionalData) {
            $isAlreadyJoined = $additionalData->user_id === $userId
                && $additionalData->joined_at
                && $additionalData->conference_id === $conf->id;

            $conf->isAlreadyJoined = $isAlreadyJoined;
        }
        return $conferences;
    }
}
