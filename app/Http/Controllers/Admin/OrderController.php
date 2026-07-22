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
        $user = auth()->user();

        // Server-side permission check (not just hiding the form in Blade)
        if (!$user || !($user->hasPermission('orders.update') || $user->is_admin)) {
            abort(403, 'You are not authorized to update order status.');
        }

        $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,shipped,delivered,cancelled'],
        ], [
            'status.required' => 'Please select an order status.',
            'status.in'       => 'The selected status is invalid.',
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