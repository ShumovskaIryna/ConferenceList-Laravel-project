<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The users that belong to the reports.
     */

//    public function users()
//    {
//        return $this->belongsToMany(User::class, 'users_reports');
//    }

    /**
     * The conferences that belong to the reports.
     */

//    public function conferences()
//    {
//        return $this->belongsToMany(Conference::class, 'conferences_reports');
//    }

    /**
     * to pivote
     */

//    public function conferencesReports()
//    {
//        return $this->hasMany(
//            conferencesReports::class, 'conference_id', 'id');
//    }
//
//    public function usersReports()
//    {
//        return $this->hasMany(
//            usersReports::class, 'users_id', 'id');
//    }
}
