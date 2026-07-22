<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category','subcategory','brand')->latest()->get();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('admin.products.index', compact('products','categories','subcategories','brands'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $data = $request->all();

        // IMAGE UPLOAD
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products'), $image);
            $data['image'] = $image;
        }

        // STOCK
        $data['stock_status'] = $request->quantity > 0 ? 'in_stock' : 'out_of_stock';

        // SLUG
        $data['slug'] = Str::slug($request->name);

        // 🔥 FEATURED + TRENDING
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_trending'] = $request->has('is_trending') ? 1 : 0;

        Product::create($data);

        return back()->with('success','Product Added');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();

        // IMAGE UPDATE
        if($request->hasFile('image')){
            
            // delete old image
            if($product->image && file_exists(public_path('assets/images/products/'.$product->image))){
                unlink(public_path('assets/images/products/'.$product->image));
            }

            $file = $request->file('image');
            $image = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products'), $image);

            $data['image'] = $image;
        }

        // STOCK
        $data['stock_status'] = $request->quantity > 0 ? 'in_stock' : 'out_of_stock';

        // SLUG
        $data['slug'] = Str::slug($request->name);

        // 🔥 FEATURED + TRENDING
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_trending'] = $request->has('is_trending') ? 1 : 0;

        $product->update($data);

        return back()->with('success','Product Updated');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // delete image
        if($product->image && file_exists(public_path('assets/images/products/'.$product->image))){
            unlink(public_path('assets/images/products/'.$product->image));
        }

        $product->delete();

        return back()->with('success','Deleted');
    }

    // ================= STOCK TOGGLE =================
    public function updateStock($id)
    {
        $product = Product::findOrFail($id);

        $product->stock_status = $product->stock_status == 'in_stock'
            ? 'out_of_stock'
            : 'in_stock';

        $product->save();

        return back()->with('success','Stock updated');
    }
}