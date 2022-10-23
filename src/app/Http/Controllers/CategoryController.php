<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Conference;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

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
        $validated = $request->validated();
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Create category can Admin only' );
        }
        $category = new Category();

        $category->name = $request->input('name');
        $category->category_id = $request->input('category_id');
        $category->save();

        return Redirect::route('category_list');
    }
    
    public function getCategories()
    {
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'See category list can Admin only' );
        }
       $categories = Category::with(['children'])
            ->withCount(['conferences', 'reports'])
            ->whereNull('category_id')
            ->get();

        return Inertia::render('Categories/CategoriesList', [
            'categories' => $categories
        ]);
    }
    public function deleteCategory($categoryId)
    {
        $parent = Category::find($categoryId);
        foreach ($parent->children as $child){
            foreach ($child->children as $grandChild){
                foreach ($grandChild->children as $ggrandChild){
                    foreach ($ggrandChild->children as $gggrandChild){
                        $gggrandChild->delete();
                    }
                    $ggrandChild->delete();
                }
                $grandChild->delete();
            }
            $child->delete();
        }
        $parent->delete();

        Conference::where('category', $categoryId)
        ->update(['category' => null]);
    }

    public function editCategory($categoryId)
    {
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Edit category can Admin only' );
        }
        $category = Category::with('children')
        ->findOrFail($categoryId);

        $categories = Category::with('children')
        ->get();
            
        return Inertia::render('Categories/CategoryEdit', [
            'categories' => $categories,
            'category' => $category
        ]);
    }
    
    public function editSaveCategory($categoryId, StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $isAdmin = Gate::allows('isAdmin');
        $canCreateConf = $isAdmin;
        if (!$canCreateConf) {
            abort(403, 'Edit category can Admin only' );
        }
        $category = Category::findOrFail($categoryId);

        $category->name = $request->input('name');
        $category->category_id = $request->input('category_id');
        $category->save();

        return Redirect::route('category_list');
    }
}
