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
        Comment::findOrFail($id)->delete();

        return back()->with('success', 'Comment deleted successfully');
    }

    // 🔥 CHANGE STATUS (APPROVE / REJECT)
    public function status($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->status = !$comment->status;
        $comment->save();

        return back()->with('success', 'Comment status updated');
    }
}