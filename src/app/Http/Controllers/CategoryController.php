<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Providers\RouteServiceProvider;

class CategoryController extends Controller
{
    public function create()
    {
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Create category can Admin only' );
        }
        return Inertia::render('Categories/CategoryForm');
    }

    public function store(StoreCategoryRequest $request)
    {
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Create category can Admin only' );
        }

        $category = new Category();

        $category->name = $request->input('name');
        $category->save();

        return redirect(RouteServiceProvider::HOME);
    }
}
