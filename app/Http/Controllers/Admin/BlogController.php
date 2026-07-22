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
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image'
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
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
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
    if ($request->hasFile('upload')) {

        $file = $request->file('upload');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        //   MAKE SURE FOLDER EXISTS
        $path = public_path('assets/images/blog');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $filename);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => asset('assets/images/blog/' . $filename)
        ]);
    }

    return response()->json([
        'uploaded' => 0,
        'error' => ['message' => 'Upload failed']
    ]);
}
}