<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BundleController extends Controller
{
    private function rules($id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bundles', 'name')->ignore($id),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'offer_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'      => ['required', 'in:0,1'],

            'products'               => ['required', 'array', 'min:1'],
            'products.*.product_id'  => ['required', 'integer', 'exists:products,id'],
            'products.*.quantity'    => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'Bundle name is required.',
            'name.unique' => 'A bundle with this name already exists.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'offer_price.numeric' => 'Offer price must be a number.',
            'offer_price.lte' => 'Offer price cannot be greater than the regular price.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a JPG, PNG or WEBP file.',
            'image.max' => 'Image may not be larger than 2MB.',
            'status.required' => 'Please select a status.',
            'products.required' => 'Please add at least one product to the bundle.',
            'products.min' => 'Please add at least one product to the bundle.',
            'products.*.product_id.required' => 'Please select a product for every row.',
            'products.*.product_id.exists' => 'One of the selected products does not exist.',
            'products.*.quantity.required' => 'Please enter a quantity for every product.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }

    /**
     * Filter out rows with no product selected before validation runs.
     */
    private function cleanedProducts(Request $request): array
    {
        $rows = collect($request->input('products', []))
            ->filter(fn ($row) => !empty($row['product_id']))
            ->values()
            ->all();

        $request->merge(['products' => $rows]);

        return $rows;
    }

    private function assertNoDuplicateProducts(array $products): void
    {
        $ids = collect($products)->pluck('product_id');

        if ($ids->count() !== $ids->unique()->count()) {
            $validator = validator([], []);
            $validator->errors()->add('products', 'The same product cannot be added twice to one bundle.');
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    // ===========================
    // INDEX
    // ===========================
    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bundles.view') || $user->is_admin, 403);

        $bundles = Bundle::with('items.product')->latest()->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view('admin.bundles.index', compact('bundles', 'products'));
    }

    // ===========================
    // STORE
    // ===========================
    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bundles.create') || $user->is_admin, 403);

        $this->cleanedProducts($request);

        $validated = $request->validate($this->rules(), $this->messages());

        $this->assertNoDuplicateProducts($validated['products']);

        $data = [
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'offer_price' => $validated['offer_price'] ?? null,
            'status'      => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('bundle_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/bundles'), $imageName);
            $data['image'] = $imageName;
        }

        $bundle = Bundle::create($data);

        foreach ($validated['products'] as $row) {
            $bundle->items()->create([
                'product_id' => $row['product_id'],
                'quantity'   => $row['quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Bundle Added Successfully.');
    }

    // ===========================
    // UPDATE
    // ===========================
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bundles.edit') || $user->is_admin, 403);

        $bundle = Bundle::findOrFail($id);

        $this->cleanedProducts($request);

        $validated = $request->validate($this->rules($id), $this->messages());

        $this->assertNoDuplicateProducts($validated['products']);

        $data = [
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . $bundle->id,
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'offer_price' => $validated['offer_price'] ?? null,
            'status'      => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('bundle_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/bundles'), $imageName);
            $data['image'] = $imageName;

            if ($bundle->image && file_exists(public_path('assets/images/bundles/' . $bundle->image))) {
                @unlink(public_path('assets/images/bundles/' . $bundle->image));
            }
        }

        $bundle->update($data);

        $bundle->items()->delete();

        foreach ($validated['products'] as $row) {
            $bundle->items()->create([
                'product_id' => $row['product_id'],
                'quantity'   => $row['quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Bundle Updated Successfully.');
    }

    // ===========================
    // DELETE
    // ===========================
    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('bundles.delete') || $user->is_admin, 403);

        $bundle = Bundle::find($id);

        if (!$bundle) {
            return back()->with('error', 'Bundle not found.');
        }

        if ($bundle->image && file_exists(public_path('assets/images/bundles/' . $bundle->image))) {
            @unlink(public_path('assets/images/bundles/' . $bundle->image));
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
        $user = auth()->user();
        abort_unless($user->hasPermission('bundles.edit') || $user->is_admin, 403);

        $bundle = Bundle::findOrFail($id);

        $bundle->status = $bundle->status ? 0 : 1;
        $bundle->save();

        return back()->with('success', 'Bundle Status Updated Successfully.');
    }
}