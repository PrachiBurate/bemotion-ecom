<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class DealController extends Controller
{
    private function rules()
    {
        return [
            'product_id'       => ['required', 'integer', 'exists:products,id'],
            'title'            => ['nullable', 'string', 'max:150'],
            'buy_quantity'     => ['required', 'integer', 'min:1'],
            'get_quantity'     => ['required', 'integer', 'min:1'],
            'get_type'         => ['required', 'in:free,discount'],
            'discount_percent' => ['required_if:get_type,discount', 'nullable', 'numeric', 'min:0.01', 'max:100'],
            'max_free_qty'     => ['nullable', 'integer', 'min:1'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'start_date'       => ['nullable', 'date'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'           => ['required', 'in:0,1'],
        ];
    }

    private function messages()
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists' => 'Selected product does not exist.',
            'buy_quantity.required' => 'Buy quantity is required.',
            'buy_quantity.min' => 'Buy quantity must be at least 1.',
            'get_quantity.required' => 'Get quantity is required.',
            'get_quantity.min' => 'Get quantity must be at least 1.',
            'get_type.required' => 'Please select an offer type.',
            'discount_percent.required_if' => 'Discount % is required when offer type is Discount.',
            'discount_percent.max' => 'Discount % cannot exceed 100.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a JPG, PNG or WEBP file.',
            'image.max' => 'Image may not be larger than 2MB.',
            'end_date.after_or_equal' => 'End date must be on or after the start date.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('deals.view') || $user->is_admin, 403);

        $deals = Deal::with('product')->latest()->get();
        $products = Product::orderBy('name')->get();

        return view('admin.deals.index', compact('deals', 'products'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('deals.create') || $user->is_admin, 403);

        $validated = $request->validate($this->rules(), $this->messages());

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('deal_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $imageName);
        }

        // Only store discount_percent when the offer type actually uses it
        if ($validated['get_type'] !== 'discount') {
            $validated['discount_percent'] = null;
        }

        Deal::create([
            'product_id'       => $validated['product_id'],
            'title'            => $validated['title'] ?? null,
            'buy_quantity'     => $validated['buy_quantity'],
            'get_quantity'     => $validated['get_quantity'],
            'get_type'         => $validated['get_type'],
            'discount_percent' => $validated['discount_percent'] ?? null,
            'max_free_qty'     => $validated['max_free_qty'] ?? null,
            'image'            => $imageName,
            'start_date'       => $validated['start_date'] ?? null,
            'end_date'         => $validated['end_date'] ?? null,
            'status'           => $validated['status'],
        ]);

        return back()->with('success', 'Deal Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('deals.edit') || $user->is_admin, 403);

        $deal = Deal::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        $imageName = $deal->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('deal_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $imageName);

            if ($deal->image && file_exists(public_path('assets/images/banner/' . $deal->image))) {
                @unlink(public_path('assets/images/banner/' . $deal->image));
            }
        }

        if ($validated['get_type'] !== 'discount') {
            $validated['discount_percent'] = null;
        }

        $deal->update([
            'product_id'       => $validated['product_id'],
            'title'            => $validated['title'] ?? null,
            'buy_quantity'     => $validated['buy_quantity'],
            'get_quantity'     => $validated['get_quantity'],
            'get_type'         => $validated['get_type'],
            'discount_percent' => $validated['discount_percent'] ?? null,
            'max_free_qty'     => $validated['max_free_qty'] ?? null,
            'image'            => $imageName,
            'start_date'       => $validated['start_date'] ?? null,
            'end_date'         => $validated['end_date'] ?? null,
            'status'           => $validated['status'],
        ]);

        return back()->with('success', 'Deal Updated Successfully');
    }

    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('deals.delete') || $user->is_admin, 403);

        $deal = Deal::find($id);

        if (!$deal) {
            return back()->with('error', 'Deal not found.');
        }

        if ($deal->image && file_exists(public_path('assets/images/banner/' . $deal->image))) {
            @unlink(public_path('assets/images/banner/' . $deal->image));
        }

        $deal->delete();

        return back()->with('success', 'Deleted successfully');
    }
}