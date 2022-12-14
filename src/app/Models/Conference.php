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

    public function conferencesUsers()
    {
        return $this->hasMany(
            ConferencesUsers::class, 'conference_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany(
            Report::class, 'conference_id', 'id');
    }

    public function getPaginateConf(
        $userId,             
        $countReport,
        $dateConf,
        $selectedCategories,
    )
    {
        $query = $this->with('conferencesUsers');

        if (!empty($countReport)) {
            $query
                ->withCount(['reports'])
                ->havingBetween('reports_count', $countReport);
        }

        if (!empty($dateConf)) {
            $query
                ->where('date', '>=', $dateConf[0]);
            
            if ($dateConf[1]) {
                $query
                    ->where('date', '<=', $dateConf[1]);
            }
        }

        if (!empty($selectedCategories)) {
            $query
                ->whereIn('category', $selectedCategories);
        }

        $conferences = $query->paginate(15);

        foreach($conferences as $conf) {
            $isOwn = $conf->created_by === $userId;
            $conf->isOwn = $isOwn;
            $confMapUsers = $conf->conferencesUsers;
            if (empty($confMapUsers)) {
                continue;
            }
            foreach($confMapUsers as $additionalData) {
                $isAlreadyJoined = $additionalData->user_id === $userId
                    && $additionalData->joined_at
                    && $additionalData->conference_id === $conf->id;
                if ($isAlreadyJoined) {
                    $conf->isAlreadyJoined = $isAlreadyJoined;
                }
            }
        }
        return $conferences;
    }

    public function getConfId($userId, $confId)
    {
        $conference = $this->with('conferencesUsers')->findOrFail($confId);
        $isOwn = $conference->created_by === $userId;
        $conference->isOwn = $isOwn;
        $confMapUsers = $conference->conferencesUsers;
        if (empty($confMapUsers)) {
            return $conference;
        }
        foreach($confMapUsers as $additionalData) {
            $isAlreadyJoined = $additionalData->user_id === $userId
                && $additionalData->joined_at
                && $additionalData->conference_id === $conference->id;
            $conference->isAlreadyJoined = $isAlreadyJoined;
        }
        return $conference;
    }
}
