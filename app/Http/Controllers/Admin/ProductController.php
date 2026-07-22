<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private function rules($id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:150',
                Rule::unique('products', 'name')->ignore($id),
            ],
            'category_id'    => ['required', 'integer', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'integer', 'exists:subcategories,id'],
            'brand_id'       => ['nullable', 'integer', 'exists:brands,id'],
            'price'          => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'quantity'       => ['required', 'integer', 'min:0'],
            'status'         => ['required', 'in:0,1'],
            'is_featured'    => ['nullable', 'boolean'],
            'is_trending'    => ['nullable', 'boolean'],

            // main image
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // gallery: multiple files
            'gallery'   => ['nullable', 'array', 'max:10'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // existing gallery images to remove (edit only)
            'remove_gallery'   => ['nullable', 'array'],
            'remove_gallery.*' => ['integer', 'exists:product_images,id'],

            // dynamic spec fields e.g. Weight -> 1.5kg
            'spec_key'     => ['nullable', 'array'],
            'spec_key.*'   => ['nullable', 'string', 'max:100'],
            'spec_value'   => ['nullable', 'array'],
            'spec_value.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'name.unique' => 'A product with this name already exists.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'subcategory_id.exists' => 'Selected subcategory does not exist.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'image.image' => 'Main image must be an image file.',
            'image.mimes' => 'Main image must be JPG, PNG or WEBP.',
            'image.max' => 'Main image may not be larger than 2MB.',
            'gallery.max' => 'You can upload a maximum of 10 gallery images.',
            'gallery.*.image' => 'Each gallery file must be an image.',
            'gallery.*.mimes' => 'Gallery images must be JPG, PNG or WEBP.',
            'gallery.*.max' => 'Each gallery image may not be larger than 2MB.',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('products.view') || $user->is_admin, 403);

        $products = Product::with('category', 'subcategory', 'brand', 'images')->latest()->get();
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'subcategories', 'brands'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('products.create') || $user->is_admin, 403);

        $validated = $request->validate($this->rules(), $this->messages());

        // MAIN IMAGE
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('prod_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products'), $imageName);
        }

        $product = Product::create([
            'name'            => $validated['name'],
            'slug'            => Str::slug($validated['name']) . '-' . Str::random(6),
            'category_id'     => $validated['category_id'],
            'subcategory_id'  => $validated['subcategory_id'] ?? null,
            'brand_id'        => $validated['brand_id'] ?? null,
            'price'           => $validated['price'],
            'quantity'        => $validated['quantity'],
            'stock_status'    => $validated['quantity'] > 0 ? 'in_stock' : 'out_of_stock',
            'image'           => $imageName,
            'status'          => $validated['status'],
            'is_featured'     => $request->has('is_featured') ? 1 : 0,
            'is_trending'     => $request->has('is_trending') ? 1 : 0,
        ]);

        $this->syncGalleryImages($product, $request);
        $this->syncSpecifications($product, $request);

        return back()->with('success', 'Product Added Successfully');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('products.edit') || $user->is_admin, 403);

        $product = Product::findOrFail($id);

        $validated = $request->validate($this->rules($id), $this->messages());

        // MAIN IMAGE
        $imageName = $product->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('prod_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products'), $imageName);

            if ($product->image && file_exists(public_path('assets/images/products/' . $product->image))) {
                @unlink(public_path('assets/images/products/' . $product->image));
            }
        }

        $product->update([
            'name'            => $validated['name'],
            'slug'            => Str::slug($validated['name']) . '-' . $product->id,
            'category_id'     => $validated['category_id'],
            'subcategory_id'  => $validated['subcategory_id'] ?? null,
            'brand_id'        => $validated['brand_id'] ?? null,
            'price'           => $validated['price'],
            'quantity'        => $validated['quantity'],
            'stock_status'    => $validated['quantity'] > 0 ? 'in_stock' : 'out_of_stock',
            'image'           => $imageName,
            'status'          => $validated['status'],
            'is_featured'     => $request->has('is_featured') ? 1 : 0,
            'is_trending'     => $request->has('is_trending') ? 1 : 0,
        ]);

        // Remove any gallery images the user unchecked
        if ($request->filled('remove_gallery')) {
            $toRemove = ProductImage::where('product_id', $product->id)
                ->whereIn('id', $request->remove_gallery)
                ->get();

            foreach ($toRemove as $img) {
                if (file_exists(public_path('assets/images/products/gallery/' . $img->image))) {
                    @unlink(public_path('assets/images/products/gallery/' . $img->image));
                }
                $img->delete();
            }
        }

        $this->syncGalleryImages($product, $request);
        $this->syncSpecifications($product, $request);

        return back()->with('success', 'Product Updated Successfully');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('products.delete') || $user->is_admin, 403);

        $product = Product::with('images')->find($id);

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        if ($product->image && file_exists(public_path('assets/images/products/' . $product->image))) {
            @unlink(public_path('assets/images/products/' . $product->image));
        }

        foreach ($product->images as $img) {
            if (file_exists(public_path('assets/images/products/gallery/' . $img->image))) {
                @unlink(public_path('assets/images/products/gallery/' . $img->image));
            }
        }

        // product_images & product_specifications rows are removed automatically
        // via cascadeOnDelete() on the foreign key
        $product->delete();

        return back()->with('success', 'Deleted successfully');
    }

    // ================= STOCK TOGGLE =================
    public function updateStock($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('products.outofstock') || $user->is_admin, 403);

        $product = Product::findOrFail($id);

        $product->stock_status = $product->stock_status == 'in_stock'
            ? 'out_of_stock'
            : 'in_stock';

        $product->save();

        return back()->with('success', 'Stock updated');
    }

    // ================= HELPERS =================
    private function syncGalleryImages(Product $product, Request $request)
    {
        if (!$request->hasFile('gallery')) {
            return;
        }

        $order = $product->images()->max('sort_order') ?? 0;

        foreach ($request->file('gallery') as $file) {
            $order++;
            $imageName = uniqid('prod_gal_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products/gallery'), $imageName);

            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $imageName,
                'sort_order' => $order,
            ]);
        }
    }

    private function syncSpecifications(Product $product, Request $request)
    {
        if (!$request->has('spec_key')) {
            return;
        }

        // Simplest correct approach: wipe and rebuild from submitted rows,
        // skipping any row where key or value was left blank.
        $product->specifications()->delete();

        $keys = $request->input('spec_key', []);
        $values = $request->input('spec_value', []);

        $order = 0;
        foreach ($keys as $i => $key) {
            $value = $values[$i] ?? null;

            if (!filled($key) || !filled($value)) {
                continue;
            }

            ProductSpecification::create([
                'product_id' => $product->id,
                'key'        => trim($key),
                'value'      => trim($value),
                'sort_order' => $order++,
            ]);
        }
    }
}