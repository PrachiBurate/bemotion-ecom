<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    private function rules($id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('brands', 'name')->ignore($id),
            ],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,svg',
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
            'name.required' => 'Brand name is required.',
            'name.min' => 'Brand name must be at least 2 characters.',
            'name.unique' => 'This brand name already exists.',
            'logo.image' => 'The file must be an image.',
            'logo.mimes' => 'Logo must be a JPG, PNG, WEBP or SVG file.',
            'logo.max' => 'Logo may not be larger than 2MB.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('brands.view') || $user->is_admin, 403);

        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('brands.create') || $user->is_admin, 403);

        // Add form always submits a status, but default to Active as a safety net
        $request->merge(['status' => $request->status ?? 1]);

        $validated = $request->validate($this->rules(), $this->messages());

        $logoName = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logoName = uniqid('brand_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/brands'), $logoName);
        }

        Brand::create([
            'name'   => $validated['name'],
            'logo'   => $logoName,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Brand added successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('brands.edit') || $user->is_admin, 403);

        $brand = Brand::findOrFail($id);

        $validated = $request->validate($this->rules($id), $this->messages());

        $logoName = $brand->logo;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logoName = uniqid('brand_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/brands'), $logoName);

            // Remove old logo now that the new one is safely on disk
            if ($brand->logo && file_exists(public_path('assets/images/brands/' . $brand->logo))) {
                @unlink(public_path('assets/images/brands/' . $brand->logo));
            }
        }

        $brand->update([
            'name'   => $validated['name'],
            'logo'   => $logoName,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Brand updated successfully');
    }

    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('brands.delete') || $user->is_admin, 403);

        $brand = Brand::find($id);

        if (!$brand) {
            return back()->with('error', 'Brand not found.');
        }

        if ($brand->logo && file_exists(public_path('assets/images/brands/' . $brand->logo))) {
            @unlink(public_path('assets/images/brands/' . $brand->logo));
        }

        $brand->delete();

        return back()->with('success', 'Brand deleted successfully');
    }
}