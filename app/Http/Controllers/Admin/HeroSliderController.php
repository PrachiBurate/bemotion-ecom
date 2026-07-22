<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlider;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::latest()->get();

        return view('admin.hero.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'subtitle'    => 'nullable|string|max:150',
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'price'       => 'nullable|numeric|min:0',
                'button_text' => 'nullable|string|max:100',
                'button_link' => 'nullable|string|max:255',
                'status'      => 'required|boolean',
                'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'title.required'  => 'Title is required.',
                'price.numeric'   => 'Please enter a valid price.',

                'image.required'  => 'Please select an image.',
                'image.image'     => 'The selected file must be an image.',
                'image.mimes'     => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
                'image.max'       => 'Image size must not exceed 2 MB.',
                'image.uploaded'  => 'The image could not be uploaded. It may exceed the server upload limit.',
            ]
        );

        if ($request->hasFile('image')) {

            $image = time() . '.' . $request->file('image')->extension();

            $request->file('image')->move(
                public_path('assets/images/hero'),
                $image
            );

            $validated['image'] = $image;
        }

        HeroSlider::create($validated);

        return back()->with('success', 'Hero slider created successfully.');
    }

    public function update(Request $request, $id)
    {
        $slider = HeroSlider::findOrFail($id);

        $validated = $request->validate(
            [
                'subtitle'    => 'nullable|string|max:150',
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'price'       => 'nullable|numeric|min:0',
                'button_text' => 'nullable|string|max:100',
                'button_link' => 'nullable|string|max:255',
                'status'      => 'required|boolean',
                'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'title.required' => 'Title is required.',
                'price.numeric'  => 'Please enter a valid price.',

                'image.image'    => 'The selected file must be an image.',
                'image.mimes'    => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
                'image.max'      => 'Image size must not exceed 2 MB.',
                'image.uploaded' => 'The image could not be uploaded. It may exceed the server upload limit.',
            ]
        );

        if ($request->hasFile('image')) {

            if (
                $slider->image &&
                file_exists(public_path('assets/images/hero/' . $slider->image))
            ) {
                unlink(public_path('assets/images/hero/' . $slider->image));
            }

            $image = time() . '.' . $request->file('image')->extension();

            $request->file('image')->move(
                public_path('assets/images/hero'),
                $image
            );

            $validated['image'] = $image;
        }

        $slider->update($validated);

        return back()->with('success', 'Hero slider updated successfully.');
    }

    public function delete($id)
    {
        $slider = HeroSlider::findOrFail($id);

        if (
            $slider->image &&
            file_exists(public_path('assets/images/hero/' . $slider->image))
        ) {
            unlink(public_path('assets/images/hero/' . $slider->image));
        }

        $slider->delete();

        return back()->with('success', 'Hero slider deleted successfully.');
    }
}