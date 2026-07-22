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

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        // Server-side permission check (not just hiding the edit button in Blade)
        if (!$user || !($user->hasPermission('pages.edit') || $user->is_admin)) {
            abort(403, 'You are not authorized to update pages.');
        }

        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status'  => ['nullable', 'in:0,1'],
        ], [
            'title.required'   => 'The page title is required.',
            'content.required' => 'The page content cannot be empty.',
            'status.in'        => 'Invalid status selected.',
        ]);

        $page->update([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'status'  => $validated['status'] ?? 1,
        ]);

        return back()->with('success', 'Page Updated Successfully');
    }

    // ================= CKEDITOR IMAGE UPLOAD =================
    public function uploadImage(Request $request)
    {
        $user = auth()->user();

        if (!$user || !($user->hasPermission('pages.edit') || $user->is_admin)) {
            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => 'Unauthorized'],
            ], 403);
        }

        $validator = \Validator::make($request->all(), [
            'upload' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => $validator->errors()->first('upload')],
            ]);
        }

        $file = $request->file('upload');
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

        $path = public_path('assets/images/pages');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $filename);

        // CKEditor REQUIRED FORMAT
        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => asset('assets/images/pages/'.$filename),
        ]);
    }
}