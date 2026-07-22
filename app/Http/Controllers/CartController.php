<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
 
public function add(Request $request)
{
    if(Auth::guard('customer')->check()){

        $customer = Auth::guard('customer')->id();

        $cart = Cart::where('customer_id',$customer)
                    ->where('product_id',$request->product_id)
                    ->first();

    }else{

        $session = session()->getId();

        $cart = Cart::where('session_id',$session)
                    ->whereNull('customer_id')
                    ->where('product_id',$request->product_id)
                    ->first();
    }

    if($cart){

        $cart->quantity++;

        $cart->save();

    }else{

      $customerId = Auth::guard('customer')->id();

Cart::create([
    'session_id' => $customerId ? null : session()->getId(),
    'customer_id' => $customerId,
    'product_id' => $request->product_id,
    'price' => $request->price,
    'quantity' => 1
]);

    }

    return response()->json([
        'status'=>true
    ]);
}

public function sidebar()
{
    if(Auth::guard('customer')->check()){

        $cart = Cart::with('product')
            ->where('customer_id',Auth::guard('customer')->id())
            ->get();

    }else{

        $cart = Cart::with('product')
            ->where('session_id',session()->getId())
            ->whereNull('customer_id')
            ->get();

    }

    $subtotal = 0;

    foreach($cart as $item){

        $subtotal += $item->price * $item->quantity;

    }

    return view('cart.sidebar',compact('cart','subtotal'));
}

public function increase(Request $request)
{
    $query = Cart::where('id',$request->id);

    if(Auth::guard('customer')->check()){

        $query->where('customer_id',Auth::guard('customer')->id());

    }else{

        $query->where('session_id',session()->getId());
    }

    $cart = $query->firstOrFail();

    $cart->increment('quantity');

    return response()->json(['status'=>true]);
}
public function decrease(Request $request)
{
    $cart = Cart::findOrFail($request->id);

    if($cart->quantity>1){

        $cart->quantity--;

        $cart->save();

    }

    return response()->json([
        'status'=>true
    ]);
}

public function remove(Request $request)
{
    Cart::find($request->id)?->delete();

    return response()->json([
        'status'=>true
    ]);
}

public function headerCounts()
{
    $session = session()->getId();
    $customer = Auth::guard('customer')->id();

    return response()->json([
        'cart' => Cart::when($customer, function ($q) use ($customer) {
            $q->where('customer_id', $customer);
        }, function ($q) use ($session) {
            $q->where('session_id', $session);
        })->sum('quantity'),

        'wishlist' => Wishlist::when($customer, function ($q) use ($customer) {
            $q->where('customer_id', $customer);
        }, function ($q) use ($session) {
            $q->where('session_id', $session);
        })->count()
    ]);
}
}
