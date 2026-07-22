<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Validation rules. $imageRequired controls whether image is mandatory
     * (true on store, false on update since an existing image may be kept).
     */
    private function rules(bool $imageRequired, $id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'image' => [
                $imageRequired ? 'required' : 'nullable',
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
            'name.required' => 'Category name is required.',
            'name.min' => 'Category name must be at least 2 characters.',
            'name.unique' => 'This category name already exists.',
            'image.required' => 'Please select an image.',
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
        abort_unless($user->hasPermission('categories.view') || $user->is_admin, 403);

        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('categories.create') || $user->is_admin, 403);

        $validated = $request->validate($this->rules(true), $this->messages());

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('cat_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/categories'), $imageName);
        }

        Category::create([
            'name'   => $validated['name'],
            'image'  => $imageName,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Category added successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('categories.edit') || $user->is_admin, 403);

        $category = Category::findOrFail($id);

        $validated = $request->validate($this->rules(false, $id), $this->messages());

        $imageName = $category->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid('cat_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/categories'), $imageName);

            // Remove old image now that the new one is safely on disk
            if ($category->image && file_exists(public_path('assets/images/categories/' . $category->image))) {
                @unlink(public_path('assets/images/categories/' . $category->image));
            }
        }

        $category->update([
            'name'   => $validated['name'],
            'image'  => $imageName,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Category updated successfully');
    }

    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('categories.delete') || $user->is_admin, 403);

        $category = Category::find($id);

        if (!$category) {
            return back()->with('error', 'Category not found.');
        }

        if ($category->image && file_exists(public_path('assets/images/categories/' . $category->image))) {
            @unlink(public_path('assets/images/categories/' . $category->image));
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }
}