<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $conf_id;

    public function __construct($confId) {
        $this->conf_id = $confId;
    }

    public function collection()
    {
        return Report::select("id", "topic", "time_start", "time_finish", "description")
        ->where('conference_id', '=', $this->conf_id)
        ->withCount(['comments'])
        ->get();

        
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function headings(): array
    {
        return ["#", "Topic", "time_start", "time_finish", "Description", "Comments Count"];
    }
}
