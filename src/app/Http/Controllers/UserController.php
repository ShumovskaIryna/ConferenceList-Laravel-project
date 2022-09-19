<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{

    public function __invoke()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });
        $users = QueryBuilder::for(User::class)
            ->defaultSort('name')
            ->allowedSorts(['name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Users/Index', ['users' => $users])->table(function (InertiaTable $table) {
            $table->column('id', 'ID', searchable: true, sortable: true);
            $table->column('name', 'User Name', searchable: true, sortable: true);
            $table->column('email', 'Email Address', searchable: true, sortable: true);
            $table->column('created_at', 'Join Date', searchable: true, sortable: true);
        });
    }
}
