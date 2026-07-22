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
        $about = AboutSection::findOrFail($id);

        //   SAFE DATA (NO request->all)
        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'experience_year' => $request->experience_year,
            'list1' => $request->list1,
            'list2' => $request->list2,
            'list3' => $request->list3,
            'author_name' => $request->author_name,
            'author_position' => $request->author_position,
            'status' => $request->status,
        ];

        // ================= IMAGE 1 =================
        if ($request->hasFile('image1')) {
            if ($about->image1 && file_exists(public_path('assets/images/about/' . $about->image1))) {
                unlink(public_path('assets/images/about/' . $about->image1));
            }

            $file = $request->file('image1');
            $name = time().'_1.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['image1'] = $name;
        }

        // ================= IMAGE 2 =================
        if ($request->hasFile('image2')) {
            if ($about->image2 && file_exists(public_path('assets/images/about/' . $about->image2))) {
                unlink(public_path('assets/images/about/' . $about->image2));
            }

            $file = $request->file('image2');
            $name = time().'_2.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['image2'] = $name;
        }

        // ================= THUMB 1 =================
        if ($request->hasFile('thumb1')) {
            $file = $request->file('thumb1');
            $name = time().'_thumb1.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['thumb1'] = $name;
        }

        // ================= THUMB 2 =================
        if ($request->hasFile('thumb2')) {
            $file = $request->file('thumb2');
            $name = time().'_thumb2.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['thumb2'] = $name;
        }

        // ================= AUTHOR IMAGE =================
        if ($request->hasFile('author_image')) {
            $file = $request->file('author_image');
            $name = time().'_author.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['author_image'] = $name;
        }

        // ================= SIGNATURE =================
        if ($request->hasFile('signature')) {
            $file = $request->file('signature');
            $name = time().'_sign.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['signature'] = $name;
        }

        // ================= DIVIDER =================
        if ($request->hasFile('divider_image')) {
            $file = $request->file('divider_image');
            $name = time().'_divider.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $name);
            $data['divider_image'] = $name;
        }

        //   UPDATE
        $about->update($data);

        return back()->with('success', 'About Section Updated Successfully ');
    }
}