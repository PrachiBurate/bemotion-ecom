<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;



use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        $categories = Category::all();

        return view('admin.subcategories.index', compact('subcategories','categories'));
    }

 public function store(Request $request)
{
    $image = null;

    if($request->hasFile('image')){
        $file = $request->file('image');
        $image = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/subcategories'), $image);
    }

    Subcategory::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'image' => $image,
        'status' => $request->status
    ]);

    return back()->with('success','Added');
}
public function update(Request $request, $id)
{
    $subcategory = Subcategory::findOrFail($id);

    $image = $subcategory->image; // keep old image

    // check new image
    if ($request->hasFile('image')) {

        // optional: delete old image
        if ($subcategory->image && file_exists(public_path('assets/images/subcategories/' . $subcategory->image))) {
            unlink(public_path('assets/images/subcategories/' . $subcategory->image));
        }

        $file = $request->file('image');
        $image = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/images/subcategories'), $image);
    }

    $subcategory->update([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'image'       => $image, // 👈 important
        'status'      => $request->status
    ]);

    return back()->with('success', 'Updated successfully');
}
    public function delete($id)
    {
        Subcategory::findOrFail($id)->delete();
        return back()->with('success','Deleted');
    }
}