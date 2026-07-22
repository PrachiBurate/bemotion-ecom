<?php

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
        $this->authorizeAction('testimonials.create');

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'rating'  => ['nullable', 'integer', 'min:1', 'max:5'],
            'status'  => ['nullable', 'in:0,1'],
            'image'   => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required'    => 'Customer name is required.',
            'message.required' => 'Testimonial message is required.',
            'image.required'   => 'Please upload an image.',
            'image.image'      => 'The file must be an image.',
            'image.mimes'      => 'Image must be jpg, jpeg, png, or webp.',
            'image.max'        => 'Image may not be larger than 2MB.',
            'rating.min'       => 'Rating must be between 1 and 5.',
            'rating.max'       => 'Rating must be between 1 and 5.',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/testimonials'), $imageName);
        }

        Testimonial::create([
            'name'    => $validated['name'],
            'message' => $validated['message'],
            'rating'  => $validated['rating'] ?? 5,
            'image'   => $imageName,
            'status'  => $validated['status'] ?? 1,
        ]);

        return back()->with('success', 'Testimonial Added');
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAction('testimonials.edit');

        $t = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'rating'  => ['nullable', 'integer', 'min:1', 'max:5'],
            'status'  => ['nullable', 'in:0,1'],
            'image'   => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required'    => 'Customer name is required.',
            'message.required' => 'Testimonial message is required.',
            'image.image'      => 'The file must be an image.',
            'image.mimes'      => 'Image must be jpg, jpeg, png, or webp.',
            'image.max'        => 'Image may not be larger than 2MB.',
            'rating.min'       => 'Rating must be between 1 and 5.',
            'rating.max'       => 'Rating must be between 1 and 5.',
        ]);

        $data = [
            'name'    => $validated['name'],
            'message' => $validated['message'],
            'rating'  => $validated['rating'] ?? 5,
            'status'  => $validated['status'] ?? $t->status,
        ];

        if ($request->hasFile('image')) {

            // delete old image (optional but best)
            if ($t->image && file_exists(public_path('assets/images/testimonials/'.$t->image))) {
                @unlink(public_path('assets/images/testimonials/'.$t->image));
            }

            $imageName = time().'_'.uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('assets/images/testimonials'), $imageName);

            $data['image'] = $imageName;
        }

        $t->update($data);

        return back()->with('success', 'Testimonial Updated');
    }

    public function delete($id)
    {
        $this->authorizeAction('testimonials.delete');

        $t = Testimonial::findOrFail($id);

        if ($t->image && file_exists(public_path('assets/images/testimonials/'.$t->image))) {
            @unlink(public_path('assets/images/testimonials/'.$t->image));
        }

        $t->delete();

        return back()->with('success', 'Testimonial Deleted');
    }

    /**
     * Shared server-side permission check.
     */
    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !($user->hasPermission($permission) || $user->is_admin)) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }
}