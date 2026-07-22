<?php 
namespace App\Http\Controllers;

use App\Models\ContactQuery;
use App\Models\OfficeLocation;
use App\Models\Banner;


use Illuminate\Http\Request;

class ContactController extends Controller
{
  public function contactPage()
{
    $offices = OfficeLocation::where('status',1)->get();
    $banner = Banner::where('title', 'Contact Banner')->first();
    return view('contact', compact('offices','banner'));
}
public function contactSubmit(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required'
    ]);

    ContactQuery::create([
        'name' => $request->name,
        'email' => $request->email,
        'message' => $request->message,
        'status' => 0
    ]);

    return back()->with('success', 'Message sent successfully!');
}
}