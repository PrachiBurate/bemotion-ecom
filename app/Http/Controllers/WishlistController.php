<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;
class WishlistController extends Controller
{
    // Add / Remove Wishlist
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $session = session()->getId();

        $customer = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;

        $wishlist = Wishlist::where('product_id', $request->product_id)
            ->where(function ($q) use ($session, $customer) {

                if ($customer) {
                    $q->where('customer_id', $customer);
                } else {
                    $q->where('session_id', $session);
                }

            })
            ->first();

        // Already exists -> Remove
        if ($wishlist) {

            $wishlist->delete();

            return response()->json([
                'status' => true,
                'action' => 'removed'
            ]);
        }

        // Add
        Wishlist::create([
            'session_id' => $customer ? null : $session,
            'customer_id' => $customer,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'status' => true,
            'action' => 'added'
        ]);
    }

    // Wishlist Count
    public function count()
    {
        $session = session()->getId();

        $customer = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;

        $count = Wishlist::when($customer, function ($q) use ($customer) {
                $q->where('customer_id', $customer);
            }, function ($q) use ($session) {
                $q->where('session_id', $session);
            })
            ->count();

        return response()->json([
            'count' => $count
        ]);
    }

    // Wishlist Page
    public function index()
    {
        $session = session()->getId();

        $customer = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;

        $wishlist = Wishlist::with('product')
            ->when($customer, function ($q) use ($customer) {
                $q->where('customer_id', $customer);
            }, function ($q) use ($session) {
                $q->where('session_id', $session);
            })
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlist'));
    }
    public function remove(Request $request)
{
    Wishlist::findOrFail($request->id)->delete();

    return response()->json([
        'status' => true
    ]);
}
public function moveToCart(Request $request)
{
    $session = session()->getId();

    $customer = Auth::guard('customer')->check()
        ? Auth::guard('customer')->id()
        : null;

    $product = Product::findOrFail($request->product_id);

    // Check if already in cart
    $cart = Cart::where('product_id', $request->product_id)
        ->where(function ($q) use ($session, $customer) {

            if ($customer) {
                $q->where('customer_id', $customer);
            } else {
                $q->where('session_id', $session);
            }

        })
        ->first();

    if ($cart) {

        $cart->quantity += 1;
        $cart->save();

    } else {

       Cart::create([
    'session_id' => $customer ? null : $session,
    'customer_id' => $customer,
            'product_id' => $product->id,
            'price' => $product->sale_price ?: $product->price,
            'quantity' => 1
        ]);

    }

    // Remove from wishlist
    Wishlist::where('product_id', $request->product_id)
        ->where(function ($q) use ($session, $customer) {

            if ($customer) {
                $q->where('customer_id', $customer);
            } else {
                $q->where('session_id', $session);
            }

        })
        ->delete();

    return response()->json([
        'status' => true
    ]);
}
}