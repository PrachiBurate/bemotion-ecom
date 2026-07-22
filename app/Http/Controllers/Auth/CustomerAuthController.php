<?php
namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CustomerAuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::guard('customer')->check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|confirmed|min:6'
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success','Registered Successfully');
    }

    // LOGIN
 public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Store guest session ID BEFORE login
    $guestSessionId = session()->getId();

    if (Auth::guard('customer')->attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {

        $customer = Auth::guard('customer')->user();

        // session([
        //     'customer' => $customer
        // ]);

        // Merge guest data
        $this->mergeGuestCart($customer->id, $guestSessionId);
      $this->mergeGuestWishlist($customer->id, $guestSessionId);

        return redirect('/')->with('success', 'Login Successful');
    }

    return back()->with('error', 'Invalid credentials');
}
    // LOGOUT
public function logout()
{
    if (!Auth::guard('customer')->check()) {
        return redirect('/');
    }

    $customerId = Auth::guard('customer')->id();

    $cartItems = Cart::where('customer_id', $customerId)->get();
    $wishlistItems = Wishlist::where('customer_id', $customerId)->get();

    Auth::guard('customer')->logout();

    session()->invalidate();
    session()->regenerate();

    $guestSessionId = session()->getId();

    // Clear guest data for this session
    Cart::where('session_id', $guestSessionId)
        ->whereNull('customer_id')
        ->delete();

    Wishlist::where('session_id', $guestSessionId)
        ->whereNull('customer_id')
        ->delete();

    foreach ($cartItems as $item) {
        Cart::create([
            'session_id' => $guestSessionId,
            'customer_id' => null,
            'product_id' => $item->product_id,
            'price' => $item->price,
            'quantity' => $item->quantity,
        ]);
    }

    foreach ($wishlistItems as $item) {
        Wishlist::create([
            'session_id' => $guestSessionId,
            'customer_id' => null,
            'product_id' => $item->product_id,
        ]);
    }

    session()->regenerateToken();

    return redirect('/')->with('success', 'Logged out successfully.');
}
private function mergeGuestCart($customerId, $sessionId)
{
    $guestCart = Cart::where('session_id', $sessionId)
        ->whereNull('customer_id')
        ->get();

    foreach ($guestCart as $item) {

        $existing = Cart::where('customer_id', $customerId)
            ->where('product_id', $item->product_id)
            ->first();

        if ($existing) {

            // If the guest quantity is newer, keep it.
            // Otherwise simply delete the guest copy.
            $existing->quantity = max($existing->quantity, $item->quantity);
            $existing->price = $item->price;
            $existing->save();

            $item->delete();

        } else {

            $item->customer_id = $customerId;
            $item->save();
        }
    }
}
private function mergeGuestWishlist($customerId, $sessionId)
{
    $guestWishlist = Wishlist::where('session_id', $sessionId)
        ->whereNull('customer_id')
        ->get();

    foreach ($guestWishlist as $item) {

        $exists = Wishlist::where('customer_id', $customerId)
            ->where('product_id', $item->product_id)
            ->exists();

        if ($exists) {
            $item->delete();
        } else {
            $item->customer_id = $customerId;
            $item->save();
        }
    }
}
}