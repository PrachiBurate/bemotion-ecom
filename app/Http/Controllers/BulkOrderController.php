<?php 
namespace App\Http\Controllers;

use App\Models\BulkOrder;
use App\Models\Banner;


use Illuminate\Http\Request;

class BulkOrderController extends Controller
{

public function bulkOrderPage()
{
    $banner = Banner::where('title','Bulk Order Banner')->first(); // or create Bulk Banner
    return view('bulk-order', compact('banner'));
}
public function bulkOrderSubmit(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'city' => 'required'
    ]);

    BulkOrder::create($request->all());

    return back()->with('success','Order submitted successfully!');
}
}