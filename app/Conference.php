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
     *
     */
    public function getPaginateConf($ownerId) {
        $conferences = $this->paginate(15);

        foreach($conferences as $conf) {
            $isOwn = $conf->created_by === $ownerId;
            $conf->isOwn = $isOwn;
        }

        return $conferences;
    }
}
