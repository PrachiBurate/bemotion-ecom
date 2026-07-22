<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::with('product')->latest()->get();
        $products = Product::all();

        return view('admin.deals.index', compact('deals','products'));
    }

    public function store(Request $request)
    {
         $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $name = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/banner'), $name);

        $data['image'] = $name;
    }

    Deal::create($data);

    return back()->with('success','Deal Added');
    }

   public function update(Request $request, $id)
{
    $deal = Deal::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $name = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/banner'), $name);

        $data['image'] = $name;
    }

    $deal->update($data);

    return back()->with('success','Deal Updated');
}

    public function delete($id)
    {
        Deal::findOrFail($id)->delete();

        return back()->with('success','Deleted');
    }
}