<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // 🔥 LIST COMMENTS
    public function index()
    {
        $comments = Comment::with('blog')->latest()->get();
        return view('admin.comments.index', compact('comments'));
    }

    // 🔥 DELETE COMMENT
   public function delete($id)
{
    if (!auth()->user()->hasPermission('comments.delete') && !auth()->user()->is_admin) {
        abort(403);
    }

    $comment = Comment::findOrFail($id);
    $comment->delete();

    return back()->with('success', 'Comment deleted successfully.');
}

    // 🔥 CHANGE STATUS (APPROVE / REJECT)
  public function status($id)
{
    if (!auth()->user()->hasPermission('comments.edit') && !auth()->user()->is_admin) {
        abort(403);
    }

    $comment = Comment::findOrFail($id);

    $comment->status = !$comment->status;
    $comment->save();

    return back()->with('success', 'Comment status updated successfully.');
}
}