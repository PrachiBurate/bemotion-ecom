<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\ProcessStep;
use App\Models\Testimonial;
use App\Models\Team;
use App\Models\AboutSection;

class AboutController extends Controller
{
    // ================= ABOUT PAGE =================
    public function index()
    {
        // 🔥 Fetch About Banner
        $banner = Banner::where('title', 'About Banner')
                    ->where('status', 1)
                    ->first();
$features = \App\Models\Feature::where('status',1)->get();
 $steps = ProcessStep::where('status', 1)
    ->orderBy('step_number', 'ASC')
    ->get();
$testimonials = Testimonial::where('status', 1)->get();
$newsletterBanner = Banner::where('title', 'Home Page Newsletter Banner')
    ->where('status', 1)
    ->first();

    $teams = Team::where('status',1)->get();

    $about = AboutSection::where('status',1)->first();

        // You can add more dynamic data here later
        return view('about', compact('banner','features','testimonials','steps','newsletterBanner','teams','about'));
    }
}