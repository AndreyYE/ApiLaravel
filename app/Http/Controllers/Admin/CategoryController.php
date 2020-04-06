<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\EditCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        try{
            $categories = Category::withDepth()->paginate(10);
            return view('admin.categories.categories',compact('categories'));
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>__('messages.ExistsNoCategories')]);
        }
    }

    public function create(Request $request)
    {
        try{
            $category = $request->category?$request->category:null;
            return view('admin.categories.create',compact('category'));
        }
        catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
        }
    }

    public function store(CreateCategory $request)
    {
        try{
            Category::create($request->only(['name','parent_id']));
            return redirect()->route('admin.categories.index');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>__('messages.ErrorCreateCategory')]);
        }
    }

    public function show(Category $category)
    {
        return view('admin.categories.category',compact('category'));
    }

    public function edit(Category $category)
    {
        try{
            $categories = Category::withDepth()->get();
            return view('admin.categories.edit',compact('category','categories'));
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
        }
    }

    public function update(EditCategory $request, $id)
    {
        try{
            $category = Category::findOrFail($id);
            if(!$request->parent_id){
               $category->saveAsRoot();
               return redirect()->route('admin.categories.index');
            }
            $parent = Category::find($request->parent_id);
            $parent->appendNode($category);
            return redirect()->route('admin.categories.index');
        }catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error'=>__('messages.ErrorEditCategory')]);
        }
    }

    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return redirect()->route('admin.categories');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>__('messages.ErrorDeleteCategory')]);
        }
    }
}
