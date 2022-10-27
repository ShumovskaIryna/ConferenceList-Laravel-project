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

    public function conferences() 
    {
        return $this->belongsTo(
            Conference::class, 'conference_id', 'id'
        );
    }
    public function getPaginateReports(
        $userId, 
        $confId,
        $durationReport,
        $selectedCategories,
        $timeReport
    )
    {
        $query = $this
            ->where('conference_id', $confId)
            ->withCount(['comments']);
        
        if(!empty($selectedCategories)) {
            $query
                ->whereIn('category', $selectedCategories);
        }


        if (!empty($durationReport)) {
            $query
                ->whereRaw('(TIME_TO_SEC(time_finish) - TIME_TO_SEC(time_start))/60 >= ?', $durationReport[0]);

            if ($durationReport[1]) {
                $query
                     ->whereRaw('(TIME_TO_SEC(time_finish) - TIME_TO_SEC(time_start))/60 <= ?', $durationReport[1]);
            }
        }

        if (!empty($timeReport)) {
            
            $query
                ->where('time_start', '>=', $timeReport[0]);
            
            if ($timeReport[1]) {
                $query
                    ->where('time_finish', '<=', $timeReport[1]);
            }
        }

        $reports = $query->paginate(10);

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

    public function getFavoritesReports($userId)
    {
        $reports = $this
            ->withCount(['comments'])
            ->join('favorites_reports', function($join) use ($userId) {
                $join->on('favorites_reports.report_id', '=', 'reports.id')
                ->whereNotNull('liked_at')
                ->where('favorites_reports.user_id', '=', $userId);
            })
            ->addSelect('favorites_reports.liked_at')
            ->paginate(10);
        
        return $reports;
    }
}
