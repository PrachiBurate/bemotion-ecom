<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSection;

class AboutsController extends Controller
{
    // ================= SINGLE RECORD =================
    public function index()
    {
        $about = AboutSection::first();

        if (!$about) {
            $about = AboutSection::create([
                'title' => '',
                'subtitle' => '',
                'description' => '',
                'experience_year' => 0,
                'status' => 1
            ]);
        }

        return view('admin.about.index', compact('about'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $this->authorizeAction('about.update');

        $about = AboutSection::findOrFail($id);

        $imageRules = ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'subtitle'         => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:5000'],
            'experience_year'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'list1'            => ['nullable', 'string', 'max:255'],
            'list2'            => ['nullable', 'string', 'max:255'],
            'list3'            => ['nullable', 'string', 'max:255'],
            'author_name'      => ['nullable', 'string', 'max:255'],
            'author_position'  => ['nullable', 'string', 'max:255'],
            'status'           => ['nullable', 'in:0,1'],
            'image1'           => $imageRules,
            'image2'           => $imageRules,
            'thumb1'           => $imageRules,
            'thumb2'           => $imageRules,
            'author_image'     => $imageRules,
            'signature'        => $imageRules,
            'divider_image'    => $imageRules,
        ], [
            'title.required'        => 'Title is required.',
            'experience_year.integer' => 'Experience years must be a number.',
            'experience_year.max'   => 'Experience years seems too high.',
            'image1.image'          => 'Image 1 must be a valid image.',
            'image1.mimes'          => 'Image 1 must be jpg, jpeg, png, or webp.',
            'image1.max'            => 'Image 1 may not be larger than 2MB.',
            'image2.image'          => 'Image 2 must be a valid image.',
            'image2.mimes'          => 'Image 2 must be jpg, jpeg, png, or webp.',
            'image2.max'            => 'Image 2 may not be larger than 2MB.',
            'thumb1.image'          => 'Thumbnail 1 must be a valid image.',
            'thumb1.mimes'          => 'Thumbnail 1 must be jpg, jpeg, png, or webp.',
            'thumb1.max'            => 'Thumbnail 1 may not be larger than 2MB.',
            'thumb2.image'          => 'Thumbnail 2 must be a valid image.',
            'thumb2.mimes'          => 'Thumbnail 2 must be jpg, jpeg, png, or webp.',
            'thumb2.max'            => 'Thumbnail 2 may not be larger than 2MB.',
            'author_image.image'    => 'Author image must be a valid image.',
            'author_image.mimes'    => 'Author image must be jpg, jpeg, png, or webp.',
            'author_image.max'      => 'Author image may not be larger than 2MB.',
            'signature.image'       => 'Signature must be a valid image.',
            'signature.mimes'       => 'Signature must be jpg, jpeg, png, or webp.',
            'signature.max'         => 'Signature may not be larger than 2MB.',
            'divider_image.image'   => 'Divider image must be a valid image.',
            'divider_image.mimes'   => 'Divider image must be jpg, jpeg, png, or webp.',
            'divider_image.max'     => 'Divider image may not be larger than 2MB.',
        ]);

        $data = [
            'title'            => $validated['title'],
            'subtitle'         => $validated['subtitle'] ?? null,
            'description'      => $validated['description'] ?? null,
            'experience_year'  => $validated['experience_year'] ?? 0,
            'list1'            => $validated['list1'] ?? null,
            'list2'            => $validated['list2'] ?? null,
            'list3'            => $validated['list3'] ?? null,
            'author_name'      => $validated['author_name'] ?? null,
            'author_position'  => $validated['author_position'] ?? null,
            'status'           => $validated['status'] ?? $about->status,
        ];

        // ================= IMAGE 1 =================
        if ($request->hasFile('image1')) {
            if ($about->image1 && file_exists(public_path('assets/images/about/' . $about->image1))) {
                @unlink(public_path('assets/images/about/' . $about->image1));
            }

            $file = $request->file('image1');
            $name = time() . '_' . uniqid() . '_1.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['image1'] = $name;
        }

        // ================= IMAGE 2 =================
        if ($request->hasFile('image2')) {
            if ($about->image2 && file_exists(public_path('assets/images/about/' . $about->image2))) {
                @unlink(public_path('assets/images/about/' . $about->image2));
            }

            $file = $request->file('image2');
            $name = time() . '_' . uniqid() . '_2.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['image2'] = $name;
        }

        // ================= THUMB 1 =================
        if ($request->hasFile('thumb1')) {
            if ($about->thumb1 && file_exists(public_path('assets/images/about/' . $about->thumb1))) {
                @unlink(public_path('assets/images/about/' . $about->thumb1));
            }

            $file = $request->file('thumb1');
            $name = time() . '_' . uniqid() . '_thumb1.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['thumb1'] = $name;
        }

        // ================= THUMB 2 =================
        if ($request->hasFile('thumb2')) {
            if ($about->thumb2 && file_exists(public_path('assets/images/about/' . $about->thumb2))) {
                @unlink(public_path('assets/images/about/' . $about->thumb2));
            }

            $file = $request->file('thumb2');
            $name = time() . '_' . uniqid() . '_thumb2.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['thumb2'] = $name;
        }

        // ================= AUTHOR IMAGE =================
        if ($request->hasFile('author_image')) {
            if ($about->author_image && file_exists(public_path('assets/images/about/' . $about->author_image))) {
                @unlink(public_path('assets/images/about/' . $about->author_image));
            }

            $file = $request->file('author_image');
            $name = time() . '_' . uniqid() . '_author.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['author_image'] = $name;
        }

        // ================= SIGNATURE =================
        if ($request->hasFile('signature')) {
            if ($about->signature && file_exists(public_path('assets/images/about/' . $about->signature))) {
                @unlink(public_path('assets/images/about/' . $about->signature));
            }

            $file = $request->file('signature');
            $name = time() . '_' . uniqid() . '_sign.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['signature'] = $name;
        }

        // ================= DIVIDER =================
        if ($request->hasFile('divider_image')) {
            if ($about->divider_image && file_exists(public_path('assets/images/about/' . $about->divider_image))) {
                @unlink(public_path('assets/images/about/' . $about->divider_image));
            }

            $file = $request->file('divider_image');
            $name = time() . '_' . uniqid() . '_divider.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['divider_image'] = $name;
        }

        $about->update($data);

        return back()->with('success', 'About Section Updated Successfully');
    }

    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !($user->hasPermission($permission) || $user->is_admin)) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }
}