<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportsUsers extends Model
{
    use HasFactory;
    protected $table = "favorites_reports";
    public $timestamps = false;

    public function like($reportId, $userId)
    {
        $repExist = ReportsUsers::where('user_id', $userId)
        ->where('report_id', $reportId)->count();
            if ($repExist) {
                return null;
            }
        $reportUser = new ReportsUsers();
        $reportUser->user_id = $userId;
        $reportUser->report_id = $reportId;
        $reportUser->liked_at = date('d-m-y h:i:s');
        $reportUser->save();
    }

    public function unlike($reportId, $userId)
    {
        ReportsUsers::where('user_id', $userId)
        ->where('report_id', $reportId)
        ->delete();
    }

}
