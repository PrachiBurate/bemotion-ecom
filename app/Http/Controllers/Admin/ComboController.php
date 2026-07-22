<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\ComboItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ComboController extends Controller
{
    private function rules($id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('combos', 'name')->ignore($id),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'offer_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'      => ['required', 'in:0,1'],

            'products'                 => ['required', 'array', 'min:1'],
            'products.*.product_id'    => ['required', 'integer', 'exists:products,id'],
            'products.*.quantity'      => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'Combo name is required.',
            'name.unique' => 'A combo with this name already exists.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'offer_price.numeric' => 'Offer price must be a number.',
            'offer_price.lte' => 'Offer price cannot be greater than the regular price.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a JPG, PNG or WEBP file.',
            'image.max' => 'Image may not be larger than 2MB.',
            'status.required' => 'Please select a status.',
            'products.required' => 'Please add at least one product to the combo.',
            'products.min' => 'Please add at least one product to the combo.',
            'products.*.product_id.required' => 'Please select a product for every row.',
            'products.*.product_id.exists' => 'One of the selected products does not exist.',
            'products.*.quantity.required' => 'Please enter a quantity for every product.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }

    /**
     * Filter out completely empty rows (e.g. a row added via "+ Add Product"
     * but left with no product selected) before validation, and re-index
     * the array so validation error keys and stored order stay clean.
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

    // ===========================
    // INDEX
    // ===========================
    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('combos.view') || $user->is_admin, 403);

        $combos = Combo::with('items.product')->latest()->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view('admin.combos.index', compact('combos', 'products'));
    }

    // ===========================
    // STORE
    // ===========================
    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('combos.create') || $user->is_admin, 403);

        $this->cleanedProducts($request);

        $validated = $request->validate($this->rules(), $this->messages());

        // Guard against duplicate product rows (same product added twice)
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
            $imageName = uniqid('combo_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/combos'), $imageName);
            $data['image'] = $imageName;
        }

        $combo = Combo::create($data);

        foreach ($validated['products'] as $product) {
            ComboItem::create([
                'combo_id'   => $combo->id,
                'product_id' => $product['product_id'],
                'quantity'   => $product['quantity'],
            ]);
        }

        return back()->with('success', 'Combo Created Successfully.');
    }

    // ===========================
    // UPDATE
    // ===========================
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('combos.edit') || $user->is_admin, 403);

        $combo = Combo::findOrFail($id);

        $this->cleanedProducts($request);

        $validated = $request->validate($this->rules($id), $this->messages());

        $this->assertNoDuplicateProducts($validated['products']);

        $data = [
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . $combo->id,
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'offer_price' => $validated['offer_price'] ?? null,
            'status'      => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('combo_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/combos'), $imageName);
            $data['image'] = $imageName;

            if ($combo->image && file_exists(public_path('assets/images/combos/' . $combo->image))) {
                @unlink(public_path('assets/images/combos/' . $combo->image));
            }
        }

        $combo->update($data);

        // Rebuild combo items from validated rows
        ComboItem::where('combo_id', $combo->id)->delete();

        foreach ($validated['products'] as $product) {
            ComboItem::create([
                'combo_id'   => $combo->id,
                'product_id' => $product['product_id'],
                'quantity'   => $product['quantity'],
            ]);
        }

        return back()->with('success', 'Combo Updated Successfully.');
    }

    // ===========================
    // DELETE
    // ===========================
    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('combos.delete') || $user->is_admin, 403);

        $combo = Combo::find($id);

        if (!$combo) {
            return back()->with('error', 'Combo not found.');
        }

        if ($combo->image && file_exists(public_path('assets/images/combos/' . $combo->image))) {
            @unlink(public_path('assets/images/combos/' . $combo->image));
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
        $user = auth()->user();
        abort_unless($user->hasPermission('combos.edit') || $user->is_admin, 403);

        $combo = Combo::findOrFail($id);

        $combo->status = $combo->status ? 0 : 1;
        $combo->save();

        return back()->with('success', 'Status Updated Successfully.');
    }

    /**
     * Reject a combo where the same product appears in more than one row —
     * ComboItem has no unique constraint, so without this check duplicate
     * rows would silently create two separate line items for one product.
     */
    private function assertNoDuplicateProducts(array $products): void
    {
        $ids = collect($products)->pluck('product_id');

        if ($ids->count() !== $ids->unique()->count()) {
            $validator = validator([], []);
            $validator->errors()->add('products', 'The same product cannot be added twice to one combo.');
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }
}