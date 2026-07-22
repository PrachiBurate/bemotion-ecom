<?php 
// app/Http/Controllers/Admin/TestimonialController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

 public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'message' => 'required',
        'image' => 'required|image'
    ]);

    $imageName = null;

    if($request->hasFile('image')){
        $file = $request->file('image');
        $imageName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/testimonials'), $imageName);
    }

    Testimonial::create([
        'name' => $request->name,
        'message' => $request->message,
        'rating' => $request->rating ?? 5,
        'image' => $imageName,
        'status' => $request->status ?? 1
    ]);

    return back()->with('success', 'Testimonial Added');
}
   public function update(Request $request, $id)
{
    $t = Testimonial::findOrFail($id);

    $data = [
        'name' => $request->name,
        'message' => $request->message,
        'rating' => $request->rating ?? 5,
        'status' => $request->status
    ];

    if ($request->hasFile('image')) {

        // delete old image (optional but best)
        if ($t->image && file_exists(public_path('assets/images/testimonials/'.$t->image))) {
            unlink(public_path('assets/images/testimonials/'.$t->image));
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('assets/images/testimonials'), $imageName);

        $data['image'] = $imageName;
    }

    $t->update($data);

    return back()->with('success', 'Updated');
}

    public function delete($id)
    {
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }
}