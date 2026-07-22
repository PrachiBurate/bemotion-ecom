<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BundleController extends Controller
{
    // ===========================
    // INDEX
    // ===========================
    public function index()
    {
        $bundles = Bundle::with('items.product')->latest()->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view('admin.bundles.index', compact('bundles', 'products'));
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
        $image = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('assets/images/bundles'), $image);

        $data['image'] = $image;
    }

    $bundle = Bundle::create($data);

    // Save Bundle Products
    if ($request->filled('products')) {

        foreach ($request->products as $row) {

            if (!empty($row['product_id'])) {

                $bundle->items()->create([
                    'product_id' => $row['product_id'],
                    'quantity'   => $row['quantity'] ?? 1,
                ]);

            }

        }

    }

    return redirect()->back()->with('success', 'Bundle Added Successfully.');
}
    // ===========================
    // UPDATE
    // ===========================
  public function update(Request $request, $id)
{
    $bundle = Bundle::findOrFail($id);

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

    // Update Image
    if ($request->hasFile('image')) {

        if (
            $bundle->image &&
            file_exists(public_path('assets/images/bundles/'.$bundle->image))
        ) {
            unlink(public_path('assets/images/bundles/'.$bundle->image));
        }

        $file = $request->file('image');
        $image = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('assets/images/bundles'), $image);

        $data['image'] = $image;
    }

    $bundle->update($data);

    // Delete Existing Items
    $bundle->items()->delete();

    // Insert Updated Items
    if ($request->filled('products')) {

        foreach ($request->products as $row) {

            if (!empty($row['product_id'])) {

                $bundle->items()->create([
                    'product_id' => $row['product_id'],
                    'quantity'   => $row['quantity'] ?? 1,
                ]);

            }

        }

    }

    return redirect()->back()->with('success', 'Bundle Updated Successfully.');
}

    // ===========================
    // DELETE
    // ===========================
    public function delete($id)
    {
        $bundle = Bundle::findOrFail($id);

        if (
            $bundle->image &&
            file_exists(public_path('assets/images/bundles/' . $bundle->image))
        ) {
            unlink(public_path('assets/images/bundles/' . $bundle->image));
        }

        BundleItem::where('bundle_id', $bundle->id)->delete();

        $bundle->delete();

        return back()->with('success', 'Bundle Deleted Successfully.');
    }

    // ===========================
    // STATUS TOGGLE
    // ===========================
    public function toggleStatus($id)
    {
        $bundle = Bundle::findOrFail($id);

        $bundle->status = $bundle->status ? 0 : 1;

        $bundle->save();

        return back()->with('success', 'Bundle Status Updated Successfully.');
    }
}