<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;

class BulkOrdersController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bulk_orders.view') || $user->is_admin, 403);

        $orders = BulkOrder::latest()->get();
        return view('admin.bulk_orders.index', compact('orders'));
    }

    public function status($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bulk_orders.update') || $user->is_admin, 403);

        $order = BulkOrder::find($id);

        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        $order->status = 1;
        $order->save();

        return back()->with('success', 'Marked as processed');
    }

    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bulk_orders.delete') || $user->is_admin, 403);

        $order = BulkOrder::find($id);

        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        $order->delete();

        return back()->with('success', 'Deleted successfully');
    }
}