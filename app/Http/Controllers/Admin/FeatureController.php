<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use Illuminate\Validation\Rule;

class FeatureController extends Controller
{
    /**
     * Rules shared between store/update.
     * Icon must be a valid Font Awesome class suffix, e.g. "fa-truck".
     */
    private function rules($id = null)
    {
        return [
            'icon' => [
                'required',
                'string',
                'max:100',
                'regex:/^fa-[a-z0-9-]+$/',
            ],
            'title' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('features', 'title')->ignore($id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
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
            'icon.required' => 'Please select an icon.',
            'icon.regex' => 'Please select a valid icon from the icon picker.',
            'title.required' => 'Feature title is required.',
            'title.min' => 'Feature title must be at least 3 characters.',
            'title.unique' => 'Feature title already exists.',
            'description.max' => 'Description may not exceed 1000 characters.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    public function index()
    {
        $features = Feature::latest()->get();
        return view('admin.features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        Feature::create($validated);

        return back()->with('success', 'Feature Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $validated = $request->validate($this->rules($id), $this->messages());

        $feature->update($validated);

        return back()->with('success', 'Feature Updated Successfully');
    }

    public function delete($id)
    {
        $feature = Feature::findOrFail($id);
        $feature->delete();

        return back()->with('success', 'Feature Deleted Successfully');
    }
}