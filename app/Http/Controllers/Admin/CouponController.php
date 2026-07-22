<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    private function rules($id = null)
    {
        return [
            'code' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                Rule::unique('coupons', 'code')->ignore($id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'type'        => ['required', 'in:flat,percent'],
            // percent capped at 100; flat just needs to be a sane positive number
            'value' => [
                'required',
                'numeric',
                'min:0.01',
                Rule::when(fn ($input) => $input['type'] === 'percent', ['max:100']),
                Rule::when(fn ($input) => $input['type'] === 'flat', ['max:999999.99']),
            ],
            'min_amount' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'status'     => ['required', 'in:0,1'],
        ];
    }

    private function messages()
    {
        return [
            'code.required' => 'Coupon code is required.',
            'code.min' => 'Coupon code must be at least 3 characters.',
            'code.alpha_dash' => 'Coupon code may only contain letters, numbers, dashes and underscores.',
            'code.unique' => 'This coupon code already exists.',
            'type.required' => 'Please select a coupon type.',
            'value.required' => 'Value is required.',
            'value.numeric' => 'Value must be a number.',
            'value.min' => 'Value must be greater than 0.',
            'value.max' => 'Percentage discounts cannot exceed 100%.',
            'min_amount.numeric' => 'Minimum amount must be a number.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('coupons.view') || $user->is_admin, 403);

        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('coupons.create') || $user->is_admin, 403);

        // Normalize code to uppercase before validation so "save10" and
        // "SAVE10" are treated as the same code by the uniqueness check.
        $request->merge(['code' => strtoupper((string) $request->code)]);

        $validated = $request->validate($this->rules(), $this->messages());

        Coupon::create($validated);

        return back()->with('success', 'Coupon Created Successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('coupons.edit') || $user->is_admin, 403);

        $coupon = Coupon::findOrFail($id);

        $request->merge(['code' => strtoupper((string) $request->code)]);

        $validated = $request->validate($this->rules($id), $this->messages());

        $coupon->update($validated);

        return back()->with('success', 'Coupon Updated Successfully');
    }

    public function status($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('coupons.edit') || $user->is_admin, 403);

        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();

        return back()->with('success', 'Status Updated');
    }

    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('coupons.delete') || $user->is_admin, 403);

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return back()->with('error', 'Coupon not found.');
        }

        $coupon->delete();

        return back()->with('success', 'Deleted successfully');
    }
}