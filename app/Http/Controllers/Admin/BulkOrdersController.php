<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;

class BulkOrdersController extends Controller
{
    public function index()
    {
        $orders = BulkOrder::latest()->get();
        return view('admin.bulk_orders.index', compact('orders'));
    }

    public function status($id)
    {
        $order = BulkOrder::findOrFail($id);
        $order->status = 1;
        $order->save();

        return back()->with('success','Marked as processed');
    }

    public function delete($id)
    {
        BulkOrder::findOrFail($id)->delete();
        return back()->with('success','Deleted successfully');
    }
}