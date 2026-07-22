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

    $imageName = $banner->image;

    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('assets/images/banner'), $imageName);
    }

    $banner->update([
        'title' => $banner->title,
        'subtitle' => $request->subtitle,
        'image' => $imageName,
        'button_text' => $request->button_text,
        'button_link' => $request->button_link,
        'status' => 1
    ]);

    return back()->with('success', 'Banner Updated Successfully');
}
}