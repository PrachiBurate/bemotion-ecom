<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // 🔥 LIST BLOGS
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    // 🔥 STORE BLOG
  public function store(Request $request)
{
  $request->validate([
    'title' => [
        'required',
        'string',
        'min:5',
        'max:255',
        'unique:blogs,title'
    ],

    'content' => [
        'required',
        'string',
        'min:50'
    ],

    'image' => [
        'required',
        'image',
        'mimes:jpeg,jpg,png,webp',
        'max:2048'
    ],

    'status' => [
        'required',
        'in:0,1'
    ]

],[
    'title.required' => 'Blog title is required.',
    'title.min' => 'Title must be at least 5 characters.',
    'title.max' => 'Title cannot exceed 255 characters.',
    'title.unique' => 'This blog title already exists.',

    'content.required' => 'Blog content is required.',
    'content.min' => 'Content must contain at least 50 characters.',

    'image.required' => 'Please upload a featured image.',
    'image.image' => 'Uploaded file must be an image.',
    'image.mimes' => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
    'image.max' => 'Image size cannot exceed 2MB.',

    'status.required' => 'Please select blog status.',
    'status.in' => 'Invalid status selected.'
]);

    $imageName = null;

    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('assets/images/blog'), $imageName);
    }

    Blog::create([
        'title' => $request->input('title'),
        'slug' => $this->generateSlug($request->input('title')),
        'content' => $request->input('content'), //   FIXED
        'image' => $imageName,
        'status' => $request->input('status', 1)
    ]);

    return back()->with('success', 'Blog Created Successfully');
}
    // 🔥 UPDATE BLOG
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

    $request->validate([

    'title' => [
        'required',
        'string',
        'min:5',
        'max:255',
        'unique:blogs,title,'.$id
    ],

    'content' => [
        'required',
        'string',
        'min:50'
    ],

    'image' => [
        'nullable',
        'image',
        'mimes:jpeg,jpg,png,webp',
        'max:2048'
    ],

    'status' => [
        'required',
        'in:0,1'
    ]

],[
    'title.unique'=>'Another blog already has this title.'
]);

        $data = [
            'title' => $request->title,
            'slug' => $this->generateSlug($request->title, $id),
          'content' => $request->input('content'),
            'status' => $request->status
        ];

        // IMAGE UPDATE
        if ($request->hasFile('image')) {

            // delete old image
            if ($blog->image && file_exists(public_path('assets/images/blog/' . $blog->image))) {
                unlink(public_path('assets/images/blog/' . $blog->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/images/blog'), $imageName);

            $data['image'] = $imageName;
        }

        $blog->update($data);

        return back()->with('success', 'Blog Updated Successfully');
    }

    // 🔥 DELETE BLOG
    public function delete($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && file_exists(public_path('assets/images/blog/' . $blog->image))) {
            unlink(public_path('assets/images/blog/' . $blog->image));
        }

        $blog->delete();

        return back()->with('success', 'Blog Deleted Successfully');
    }

    // 🔥 GENERATE UNIQUE SLUG
    private function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = Blog::where('slug', 'LIKE', $slug . '%')
                    ->when($id, function ($query) use ($id) {
                        return $query->where('id', '!=', $id);
                    })
                    ->count();

        return $count ? $slug . '-' . ($count + 1) : $slug;
    }

public function uploadImage(Request $request)
{
    $request->validate([
        'upload' => [
            'required',
            'image',
            'mimes:jpeg,jpg,png,gif,webp',
            'max:2048'
        ]
    ]);

    $file = $request->file('upload');

    $filename = uniqid().'.'.$file->extension();

    $path = public_path('assets/images/blog');

    if(!file_exists($path)){
        mkdir($path,0777,true);
    }

    $file->move($path,$filename);

    return response()->json([
        'uploaded'=>1,
        'fileName'=>$filename,
        'url'=>asset('assets/images/blog/'.$filename)
    ]);
}
}