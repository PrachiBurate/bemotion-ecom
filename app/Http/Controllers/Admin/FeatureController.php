<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::latest()->get();
        return view('admin.features.index', compact('features'));
    }

    public function store(Request $req)
    {
        Feature::create($req->all());
        return back()->with('success', 'Feature Added');
    }

    public function update(Request $req, $id)
    {
        Feature::find($id)->update($req->all());
        return back()->with('success', 'Updated');
    }

    public function delete($id)
    {
        Feature::find($id)->delete();
        return back()->with('success', 'Deleted');
    }
}