<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Report extends Model
{
    use HasFactory;

    /**
     * The users that belong to the reports.
     */

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites_reports');
    }

    /**
     * The conferences that belong to the reports.
     */

    public function comments() {
        return $this->hasMany(
            Comment::class, 'report_id', 'id'
        );
    }

    /**
     * to pivote
     */

    public function reportsUsers()
    {
        return $this->hasMany(
            ReportsUsers::class, 'report_id', 'id');
    }

    public function getPaginateReports($userId, $confId)
    {
        $reports = $this
        ->where('conference_id', $confId)
        ->withCount(['comments'])
        ->paginate(10);
        foreach($reports as $report)
        {
            $isOwn = $report->created_by === $userId;
            $report->isOwn = $isOwn;
            $reportsUsers = $report->reportsUsers;
            if (empty($reportsUsers)) {
                continue;
            }

            foreach($reportsUsers as $additionalData) {
                $isAlreadyLiked = $additionalData->user_id === $userId
                    && $additionalData->liked_at
                    && $additionalData->report_id === $report->id;
                if ($isAlreadyLiked) {
                    $report->isAlreadyLiked = $isAlreadyLiked;
                }
            }
        }
        return $reports;
    }

    public function getReportId($userId, $confId, $reportId)
    {
        $report = $this->where('conference_id', $confId)->findOrFail($reportId);
            $isOwn = $report->created_by === $userId;
            $report->isOwn = $isOwn;

        $report->file_path = Storage::url($report->file_path);
        return $report;
    }
}
