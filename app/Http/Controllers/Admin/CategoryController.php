<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;


use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'image' => 'required|image'
    ]);

    $image = null;

    if($request->hasFile('image')){
        $file = $request->file('image');
        $image = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/categories'), $image);
    }

    Category::create([
        'name' => $request->name,
        'image' => $image,
        'status' => $request->status
    ]);

    return back()->with('success','Category added');
}

  public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $image = $category->image;

    if($request->hasFile('image')){
        $file = $request->file('image');
        $image = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/categories'), $image);
    }

    $category->update([
        'name' => $request->name,
        'image' => $image,
        'status' => $request->status
    ]);

    return back()->with('success','Updated');
}

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success','Deleted');
    }
}