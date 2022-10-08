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

    public function users()
    {
        return $this->belongsToMany(User::class, 'reports_conferences_users');
    }

    /**
     * The conferences that belong to the reports.
     */

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'reports_conferences_users');
    }

    /**
     * to pivote
     */

    public function reportsUsers()
    {
        return $this->hasMany(
            ReportsUsers::class, 'users_id', 'id');
    }

    public function getPaginateReports($userId, $confId)
    {
        $reports = $this->where('conference_id', $confId)->paginate(15);
        foreach($reports as $report)
        {
            $isOwn = $report->created_by === $userId;
            $report->isOwn = $isOwn;

        }
        return $reports;
    }

    public function getReportId($userId, $confId, $reportId)
    {
        $report = $this->where('conference_id', $confId)->findOrFail($reportId);
            $isOwn = $report->created_by === $userId;
            $report->isOwn = $isOwn;

        $report->file_path = $file_path = public_path('app/'.$report->file_path);
        return $report;
    }
}
