<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
  use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Checkout Page
     */
public function index()
{
    if (!Auth::guard('customer')->check()) {
        return redirect('/login');
    }

    $customer = Auth::guard('customer')->user();

    $cart = Cart::with('product')
        ->where('customer_id', $customer->id)
        ->get();

    if ($cart->isEmpty()) {
        return redirect('/')->with('error', 'Your cart is empty.');
    }

    $subtotal = $cart->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    $shipping = 0;
    $tax = 0;
    $total = $subtotal + $shipping + $tax;

    return view('checkout', compact(
        'customer',
        'cart',
        'subtotal',
        'shipping',
        'tax',
        'total'
    ));
}

    /**
     * Place Order
     */
    public function placeOrder(Request $request)
    {

    // dd($request->all());
    if (!Auth::guard('customer')->check()) {
    return redirect('/login');
}



        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'payment_method' => 'required'
        ]);

        DB::beginTransaction();

        try {

           $customer = Auth::guard('customer')->user();

            $cart = Cart::with('product')
                ->where('customer_id', $customer->id)
                ->get();

            if ($cart->count() == 0) {

                return response()->json([
                    'status' => false,
                    'message' => 'Cart is empty.'
                ]);
            }

            $subtotal = 0;

            foreach ($cart as $item) {
                $subtotal += ($item->price * $item->quantity);
            }

            $shipping = 0;
            $tax = 0;
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([

                'customer_id' => $customer->id,

                'order_number' => 'ORD' . date('YmdHis') . rand(100,999),

                'subtotal' => $subtotal,

                'shipping' => $shipping,

                'tax' => $tax,

                'total' => $total,

                'payment_method' => $request->payment_method,

                'payment_status' => 'pending',

                'order_status' => 'pending',

                'name' => $request->name,

                'email' => $request->email,

                'phone' => $request->phone,

                'address' => $request->address,

                'city' => $request->city,

                'state' => $request->state,

                'pincode' => $request->pincode

            ]);

            foreach ($cart as $item) {

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item->product_id,

                    'quantity' => $item->quantity,

                    'price' => $item->price,

                    'total' => $item->price * $item->quantity

                ]);

                // Optional: Reduce Stock
                // $item->product->decrement('stock', $item->quantity);
            }

            // Clear Cart
            Cart::where('customer_id', $customer->id)->delete();

        DB::commit();

return redirect()
    ->route('order.success', $order->id)
    ->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {

    DB::rollBack();

    dd($e->getMessage(), $e->getTraceAsString());
}
    }

    /**
     * Order Success
     */
   public function success($id)
{
    if (!Auth::guard('customer')->check()) {
        return redirect('/login');
    }

    $customer = Auth::guard('customer')->user();

    $order = Order::with('items.product')
        ->where('customer_id', $customer->id)
        ->where('id', $id)
        ->firstOrFail();

    return view('order-success', compact('order'));
}
    /**
     * Customer Orders
     */
   public function myOrders()
{
    if (!Auth::guard('customer')->check()) {
        return redirect('/login');
    }

    $customer = Auth::guard('customer')->user();

    $orders = Order::where('customer_id', $customer->id)
        ->latest()
        ->paginate(10);

    return view('my-orders', compact('orders'));
}

    /**
     * Order Details
     */
   public function orderDetails($id)
{
    if (!Auth::guard('customer')->check()) {
        return redirect('/login');
    }

    $customer = Auth::guard('customer')->user();

    $order = Order::with('items.product')
        ->where('customer_id', $customer->id)
        ->where('id', $id)
        ->firstOrFail();

    return view('order-details', compact('order'));
}
}