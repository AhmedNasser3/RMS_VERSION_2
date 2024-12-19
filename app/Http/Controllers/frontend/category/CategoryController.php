<?php

namespace App\Http\Controllers\frontend\category;

use App\Http\Controllers\Controller;
use App\Models\frontend\category\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(){
        return view('frontend.category.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $validated['user_id'] = auth()->user()->id;

        Category::create($validated);
        return redirect()->route('home.page')->with('success', 'The Category Is Created Successfully');
    }
    public function edit($categoryId){
        $category = Category::find($categoryId);
        return view('frontend.category.edit',compact('category'));
    }
    public function update(Request $request,$categoryId){
        $category = Category::find($categoryId);
        $category->update($request->validate(['title','description','user_id']));
        return view('frontend.home.index')->with('success', 'The edited Is Created Successfully');
    }
    public function delete($categoryId){
        $category = Category::find($categoryId);
        $category->delete();
        return view('frontend.home.index')->with('success', 'The Category Is Deleted Successfully');
    }
}