<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ListenersExport implements FromCollection, WithHeadings
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
        return User::where('users.role', '=', 'LISTENER')
        ->leftJoin('conferences_users', function($leftJoin) {
            $leftJoin
                ->on('conferences_users.user_id', '=', 'users.id');
        })
        ->where('conferences_users.conference_id', '=', $this->conf_id)
        ->select("users.id", "users.first_name", "users.last_name", "users.birthdate", "users.countries", "users.phone", "users.email")
        ->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */ 

    public function headings(): array
    {
        return ["#", "Firstname", "Lastname", "Birthdate", "Country", "Phone", "Email"];
    }
}
