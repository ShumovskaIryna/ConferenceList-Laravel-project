<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Exports\ListenersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function export($confId)
    {
        return Excel::download(new ListenersExport($confId), 'members.xlsx');
    }

    public function __invoke()
    {
        //
    }
}
