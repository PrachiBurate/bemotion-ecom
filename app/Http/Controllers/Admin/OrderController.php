<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Orders List
     */
    public function index()
    {
        $orders = Order::with(['items.product'])
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update Order Status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);

        $order->order_status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Transactions
     */
    public function transactions()
    {
        $transactions = Transaction::with('order')
            ->latest()
            ->get();

        return view('admin.orders.transactions', compact('transactions'));
    }
}