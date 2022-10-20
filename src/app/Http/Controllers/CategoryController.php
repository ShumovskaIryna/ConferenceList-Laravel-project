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
        $categories = Category::all();
        return Inertia::render('Categories/CategoryForm', [
            'categories' => $categories
        ]);
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
        $category->category_id = $request->input('category_id');
        $category->save();

        return redirect(RouteServiceProvider::HOME);
    }
    
    public function getCategories()
    {
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'See category list can Admin only' );
        }
       $categories = Category::with('children')
            ->whereNull('category_id')
            ->get();

        return Inertia::render('Categories/CategoriesList', [
            'categories' => $categories
        ]);
    }
    public function deleteCategory($categoryId)
    {
        Category::where('id', $categoryId)
        ->delete();
        Category::where('category_id', $categoryId)
        ->delete();
    }
}
