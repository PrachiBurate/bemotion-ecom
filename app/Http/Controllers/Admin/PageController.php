<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    // ================= INDEX =================
public function index()
{
    $pages = Page::whereIn('slug', ['privacy-policy', 'terms'])->get();
    return view('admin.pages.index', compact('pages'));
}

    // ================= STORE =================
   

    // ================= UPDATE =================
  public function update(Request $request, $id)
{
    $page = Page::findOrFail($id);

    $request->validate([
        'title' => 'required',
        'content' => 'required'
    ]);

    $page->update([
        'title' => $request->title,
        'content' => $request->input('content'),
        'status' => $request->status ?? 1
    ]);

    return back()->with('success', 'Page Updated Successfully');
}

public function uploadImage(Request $request)
{
    if ($request->hasFile('upload')) {

        $file = $request->file('upload');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        //   Ensure folder exists
        $path = public_path('assets/images/pages');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        //   Move file
        $file->move($path, $filename);

        //   CKEditor REQUIRED FORMAT
        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => asset('assets/images/pages/' . $filename)
        ]);
    }

    // ❌ Fail response
    return response()->json([
        'uploaded' => 0,
        'error' => [
            'message' => 'Upload failed'
        ]
    ]);
}
    // ================= DELETE =================
   
}