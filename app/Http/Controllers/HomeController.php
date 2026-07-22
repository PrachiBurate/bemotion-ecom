<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Setting;
use App\Models\Banner;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\ProcessStep;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\WeeklyDeal;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Wishlist;


class HomeController extends Controller
{
    public function home()
    {
        // ================= BLOGS =================


        // Latest 5 blogs (1 main + 4 small)
        $latestBlogs = Blog::where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        // Footer blogs (3 only)
        $footerBlogs = Blog::where('status', 1)
            ->latest()
            ->take(3)
            ->get();
$testimonials = Testimonial::where('status', 1)->get();

$newsletterBanner = Banner::where('title', 'Home Page Newsletter Banner')
    ->where('status', 1)
    ->first();
    $steps = ProcessStep::where('status', 1)
    ->orderBy('step_number', 'ASC')
    ->get();

    $categories = Category::where('status', 1)
    ->with(['subcategories' => function($q){
        $q->where('status', 1);
    }])
    ->get();
        // ================= RETURN VIEW =================
$heroSliders = \App\Models\HeroSlider::where('status', 1)->get();
$features = \App\Models\Feature::where('status',1)->get();
$deals = Deal::where('status',1)
            ->latest()
            ->get();
           
$weeklyDeals = WeeklyDeal::where('status',1)->latest()->get();
  $trendingProducts = Product::where('is_trending', 1)
        ->where('status', 1)
        ->latest()
        ->get();

        $featuredProducts = Product::where('is_featured', 1)
    ->where('status', 1)
    ->latest()
    ->get();
$session = session()->getId();

$customer = Auth::guard('customer')->check()
    ? Auth::guard('customer')->id()
    : null;

$wishlistIds = Wishlist::when($customer,function($q) use($customer){

        $q->where('customer_id',$customer);

    },function($q) use($session){

        $q->where('session_id',$session);

    })
    ->pluck('product_id')
    ->toArray();


 return view('index', compact(
    'latestBlogs',
    'footerBlogs',
    'testimonials',
    'newsletterBanner',
    'steps',
    'categories',
    'heroSliders',
    'features',
    'deals',
    'weeklyDeals' ,
    'trendingProducts',
    'featuredProducts',
    'wishlistIds'
));
    }

public function page($slug = null)
{
    $slug = $slug ?? request()->path(); // auto detect

    $page = Page::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    $banner = Banner::where('title', $page->title . ' Banner')->first();

    return view('pages.show', compact('page', 'banner'));
}

public function deals()
{
    // Banner
    $banner = Banner::where('title', 'Deals Banner')
        ->where('status', 1)
        ->first();

    // Deals (pagination like blogs)
    $deals = Deal::where('status', 1)
        ->latest()
        ->paginate(6);

    return view('deals.index', compact('deals', 'banner'));
}


public function shops(Request $request)
{
    $query = Product::with(['category', 'brand'])
        ->where('status', 1);

    // Category Filter
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Brand Filter
    if ($request->filled('brand')) {
        $query->where('brand_id', $request->brand);
    }

    // Price Filter
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // Sorting
    switch ($request->sort) {

        case 'newest':
            $query->latest();
            break;

        case 'price_low':
            $query->orderBy('price');
            break;

        case 'price_high':
            $query->orderByDesc('price');
            break;

        default:
            $query->latest();
            break;
    }

    $products = $query->paginate(12);

    $categories = Category::where('status',1)->get();

    $brands = Brand::where('status',1)->get();

    return view('shops', compact(
        'products',
        'categories',
        'brands'
    ));
}

public function shopDetails($slug)
{
    $product = Product::with(['category','brand'])
        ->where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('status', 1)
        ->latest()
        ->take(8)
        ->get();

    $wishlistIds = [];

  $session = session()->getId();
$customer = Auth::guard('customer')->id();

$wishlistIds = Wishlist::when($customer, function ($q) use ($customer) {
    $q->where('customer_id', $customer);
}, function ($q) use ($session) {
    $q->where('session_id', $session);
})->pluck('product_id')->toArray();

    return view('shop-details', compact(
        'product',
        'relatedProducts',
        'wishlistIds'
    ));
}
}