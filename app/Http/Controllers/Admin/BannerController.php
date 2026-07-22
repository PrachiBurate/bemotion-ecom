<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
  public function index()
{
    $banners =Banner::orderBy('id')->get();
    return view('admin.banners.index', compact('banners'));
}

public function update(Request $request, $id)
{
    $banner = Banner::findOrFail($id);

    $request->validate([
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048'
        ],

        'subtitle' => [
            'nullable',
            'string',
            'max:255'
        ],

        'button_text' => [
            'nullable',
            'string',
            'max:100'
        ],

        'button_link' => [
            'nullable',
            'url',
            'max:255'
        ]

    ],[
        'image.image' => 'Please upload a valid image.',
        'image.mimes' => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
        'image.max' => 'Image size cannot exceed 2 MB.',

        'button_link.url' => 'Please enter a valid URL.'
    ]);

    $imageName = $banner->image;

    if ($request->hasFile('image')) {

        if ($banner->image && file_exists(public_path('assets/images/banner/'.$banner->image))) {
            unlink(public_path('assets/images/banner/'.$banner->image));
        }

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(
            public_path('assets/images/banner'),
            $imageName
        );
    }

    $banner->update([
        'title' => $banner->title,
        'subtitle' => $request->subtitle,
        'button_text' => $request->button_text,
        'button_link' => $request->button_link,
        'image' => $imageName,
        'status' => 1
    ]);

    return back()->with('success','Banner Updated Successfully');
}
}