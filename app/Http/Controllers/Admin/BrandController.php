<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $logo = null;

        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $logo = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/brands'), $logo);
        }

        Brand::create([
            'name' => $request->name,
            'logo' => $logo,
            'status' => 1
        ]);

        return back()->with('success','Brand added');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $logo = $brand->logo;

        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $logo = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/brands'), $logo);
        }

        $brand->update([
            'name' => $request->name,
            'logo' => $logo,
            'status' => $request->status
        ]);

        return back()->with('success','Updated');
    }

    public function delete($id)
    {
        Brand::findOrFail($id)->delete();
        return back()->with('success','Deleted');
    }
}