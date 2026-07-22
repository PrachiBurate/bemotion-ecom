<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        Coupon::create($request->all());
        return back()->with('success','Coupon Created');
    }

    public function update(Request $request, $id)
    {
        Coupon::findOrFail($id)->update($request->all());
        return back()->with('success','Coupon Updated');
    }

    public function status($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();

        return back()->with('success','Status Updated');
    }

    public function delete($id)
    {
        Coupon::findOrFail($id)->delete();
        return back()->with('success','Deleted');
    }
}