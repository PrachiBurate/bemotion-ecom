<?php 
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Models\Banner;


class BlogsController extends Controller
{
    // BLOG LIST + SEARCH
 public function index(Request $request)
{
    // 🔥 TOP LATEST BLOGS (fixed, no pagination)
    $latestBlogs = Blog::where('status', 1)
        ->latest()
        ->take(5)
        ->get();

    // 🔥 PAGINATED BLOGS (for bottom list)
    $blogs = Blog::where('status', 1)
        ->latest()
        ->paginate(3); // adjust per UI

        $banner = Banner::where('title', 'Blog Banner')->first();
   return view('blog', compact('latestBlogs', 'blogs', 'banner'));
}

    // BLOG DETAILS
// 🔥 STORE BLOG IN SESSION (POST)
public function showPost(Request $request)
{
    session(['blog_id' => $request->blog_id]);

    return redirect('/blog-details');
}

// 🔥 SHOW BLOG PAGE (GET)
public function showPage()
{
    $blogId = session('blog_id');

    if (!$blogId) {
        abort(404);
    }

    $blog = Blog::findOrFail($blogId);

    $recentBlogs = Blog::latest()->take(5)->get();

    $comments = Comment::where('blog_id', $blog->id)->latest()->get();

    $banner = Banner::where('title', 'Blog Banner')->first();

    return view('blog-details', compact('blog','recentBlogs','comments','banner'));
}

    // COMMENT STORE
    public function comment(Request $request)
    {
        Comment::create([
            'blog_id' => $request->blog_id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Comment added');
    }

    
public function subscribe(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    // 🔥 CHECK IF EXISTS
    $exists = Newsletter::where('email', $request->email)->exists();

    if ($exists) {
        return back()->with('error', 'You are already subscribed!');
    }

    Newsletter::create([
        'email' => $request->email
    ]);

    return back()->with('success', 'Subscribed successfully!');
}
}