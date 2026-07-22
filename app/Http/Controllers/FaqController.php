<?php 
namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Banner;

use Illuminate\Http\Request;



class FaqController extends Controller
{
   public function faq()
{
    $faqs = Faq::where('status', 1)->get();
$banner = Banner::where('title', 'FAQ Banner')->first();
    return view('faq', compact('faqs','banner'));
}
public function faqSubmit(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required'
    ]);

    // Save to DB (optional)
    \DB::table('faq_queries')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'message' => $request->message,
        'created_at' => now()
    ]);

    return back()->with('success', 'Your query has been submitted!');
}
 
}