<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\ComboItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComboController extends Controller
{
    // ===========================
    // INDEX
    // ===========================
    public function index()
    {
        $combos = Combo::with('items.product')->latest()->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view('admin.combos.index', compact('combos', 'products'));
    }

    // ===========================
    // STORE
    // ===========================
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'price'       => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'image'       => 'nullable|image',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'offer_price' => $request->offer_price,
            'status'      => $request->status ?? 1,
        ];

        // Upload Image
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $imageName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('assets/images/combos'), $imageName);

            $data['image'] = $imageName;
        }

        $combo = Combo::create($data);

        // Save Combo Products
        if ($request->has('products')) {

            foreach ($request->products as $product) {

                if (!empty($product['product_id'])) {

                    ComboItem::create([
                        'combo_id'   => $combo->id,
                        'product_id' => $product['product_id'],
                        'quantity'   => $product['quantity'] ?? 1,
                    ]);
                }
            }
        }

        return back()->with('success', 'Combo Created Successfully.');
    }

    // ===========================
    // UPDATE
    // ===========================
    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);

        $request->validate([
            'name'        => 'required|max:255',
            'price'       => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'image'       => 'nullable|image',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'offer_price' => $request->offer_price,
            'status'      => $request->status,
        ];

        // Image Update
        if ($request->hasFile('image')) {

            if (
                $combo->image &&
                file_exists(public_path('assets/images/combos/' . $combo->image))
            ) {
                unlink(public_path('assets/images/combos/' . $combo->image));
            }

            $file = $request->file('image');

            $imageName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('assets/images/combos'), $imageName);

            $data['image'] = $imageName;
        }

        $combo->update($data);

        // Remove Old Products
        ComboItem::where('combo_id', $combo->id)->delete();

        // Save New Products
        if ($request->has('products')) {

            foreach ($request->products as $product) {

                if (!empty($product['product_id'])) {

                    ComboItem::create([
                        'combo_id'   => $combo->id,
                        'product_id' => $product['product_id'],
                        'quantity'   => $product['quantity'] ?? 1,
                    ]);
                }
            }
        }

        return back()->with('success', 'Combo Updated Successfully.');
    }

    // ===========================
    // DELETE
    // ===========================
    public function delete($id)
    {
        $combo = Combo::findOrFail($id);

        // Delete Image
        if (
            $combo->image &&
            file_exists(public_path('assets/images/combos/' . $combo->image))
        ) {
            unlink(public_path('assets/images/combos/' . $combo->image));
        }

        ComboItem::where('combo_id', $combo->id)->delete();

        $combo->delete();

        return back()->with('success', 'Combo Deleted Successfully.');
    }

    // ===========================
    // STATUS TOGGLE
    // ===========================
    public function toggleStatus($id)
    {
        $combo = Combo::findOrFail($id);

        $combo->status = $combo->status ? 0 : 1;

        $combo->save();

        return back()->with('success', 'Status Updated Successfully.');
    }
}