<?php

namespace App\Exports;

use App\Models\Comment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $conf_id;
    public $report_id;

    public function __construct($confId, $reportId) {
        $this->conf_id = $confId;
        $this->report_id = $reportId;
    }
    
    public function collection()
    {
        return Comment::where('comments.report_id', '=', $this->report_id)
        ->leftJoin('users', function($leftJoin) {
            $leftJoin
                ->on("users.id", "=", "comments.created_by");
        })
        ->select(
            "comments.id",
            "users.first_name",
            "users.last_name",
            "comments.created_at",
            "comments.comment_message",
        )
        ->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["#", "author_first_name", "author_last_name", "Date", "Comment message"];
    }
}
