<?php

namespace App\Exports;

use App\Models\Conference;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConferencesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Conference::select("id", "title", "date", "lat", "lng", "countries")
        ->withCount(['reports'])
        ->withCount(['users'])
        ->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["#", "Title", "Date", "lat", "lng", "Country", "Reports count", "Members count"];
    }
}
