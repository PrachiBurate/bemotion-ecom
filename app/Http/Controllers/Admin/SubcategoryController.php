<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    /**
     * Validation rules. $imageRequired is false here since the Add form
     * doesn't mark image as required (unlike categories).
     */
    private function rules($id = null)
    {
        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('subcategories', 'name')
                    ->where(fn ($query) => $query->where('category_id', request('category_id')))
                    ->ignore($id),
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // KB
            ],
            'status' => [
                'required',
                'in:0,1',
            ],
        ];
    }

    private function messages()
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Subcategory name is required.',
            'name.min' => 'Subcategory name must be at least 2 characters.',
            'name.unique' => 'This subcategory name already exists under the selected category.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a JPG, PNG or WEBP file.',
            'image.max' => 'Image may not be larger than 2MB.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('subcategories.view') || $user->is_admin, 403);

        $subcategories = Subcategory::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('subcategories.create') || $user->is_admin, 403);

        $validated = $request->validate($this->rules(), $this->messages());

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('subcat_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/subcategories'), $imageName);
        }

        Subcategory::create([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'image'       => $imageName,
            'status'      => $validated['status'],
        ]);

        return back()->with('success', 'Subcategory added successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('subcategories.edit') || $user->is_admin, 403);

        $subcategory = Subcategory::findOrFail($id);

        $validated = $request->validate($this->rules($id), $this->messages());

        $imageName = $subcategory->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('subcat_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/subcategories'), $imageName);

            // Remove old image now that the new one is safely on disk
            if ($subcategory->image && file_exists(public_path('assets/images/subcategories/' . $subcategory->image))) {
                @unlink(public_path('assets/images/subcategories/' . $subcategory->image));
            }
        }

        $subcategory->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'image'       => $imageName,
            'status'      => $validated['status'],
        ]);

        return back()->with('success', 'Subcategory updated successfully');
    }

    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('subcategories.delete') || $user->is_admin, 403);

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return back()->with('error', 'Subcategory not found.');
        }

        if ($subcategory->image && file_exists(public_path('assets/images/subcategories/' . $subcategory->image))) {
            @unlink(public_path('assets/images/subcategories/' . $subcategory->image));
        }

        $subcategory->delete();

        return back()->with('success', 'Subcategory deleted successfully');
    }
}