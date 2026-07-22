@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Str;

$mainBlog = $latestBlogs->first();
$smallBlogs = $latestBlogs->skip(1);
@endphp
    <!--====== Main Bg  ======-->
    <main class="main-bg">
        <!--====== Start Hero Section ======-->
        <section class="hero-section">
            <div class="hero-wrapper-one">
                <div class="container">

                    <div class="hero-dots"></div>

                    <div class="hero-slider-one">

                        @foreach($heroSliders as $hero)
                        <div class="single-hero-slider">
                            <div class="row align-items-center">

                                <!-- LEFT CONTENT -->
                                <div class="col-lg-6">
                                    <div class="hero-content style-one mb-50">

                                        <span class="sub-heading">
                                            {{ $hero->subtitle }}
                                        </span>

                                        <h1>
                                            {!! $hero->title !!}
                                        </h1>

                                        <p>
                                            {{ $hero->description }}
                                        </p>

                                        <ul>
                                            <li>
                                                <div class="price-box">
                                                    <div class="currency">₹</div>
                                                    <div class="text">
                                                        <span class="discount">Price</span>
                                                        <h3>Starting at <br>{{ $hero->price }} /-</h3>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <img src="{{ asset('assets/images/hero/line-1.png') }}" alt="">
                                            </li>

                                            <li>
                                                <a href="{{ $hero->button_link }}" class="theme-btn style-one">
                                                    {{ $hero->button_text }}
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                                <!-- RIGHT IMAGE -->
                                <div class="col-lg-6">
                                    <div class="hero-image-box">
                                        <div class="hero-image">

                                            @if($hero->image)
                                            <img src="{{ asset('assets/images/hero/'.$hero->image) }}" alt="Hero" width="460" height="550">
                                            @endif

                                            <div class="hero-shape bg_cover"
                                                style="background-image: url({{ asset('assets/images/hero/hero-one-shape1.png') }});">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </section>
        <!--====== End Hero Section ======-->

        <!--====== Start Animated-headline Section ======-->
        <section class="animated-headline-area primary-dark-bg pt-25 pb-25">
            <div class="headline-wrap style-one">
                <span class="marquee-wrap">

                    @for($i = 0; $i < 3; $i++) {{-- repeat for smooth scroll --}}
                    <span class="marquee-inner left">

                        @foreach($categories as $cat)

                            {{-- CATEGORY --}}
                            <span class="marquee-item">
                                <b>{{ $cat->name }}</b>
                                <i class="fas fa-bahai"></i>
                            </span>

                            {{-- SUBCATEGORIES --}}
                            @foreach($cat->subcategories as $sub)
                                <span class="marquee-item">
                                    <b>{{ $sub->name }}</b>
                                    <i class="fas fa-bahai"></i>
                                </span>
                            @endforeach

                        @endforeach

                    </span>
                    @endfor

                </span>
            </div>
        </section><!--====== End Animated-headline Section ======-->

        <!--====== Start Features Section ======-->
        <section class="features-section pt-130">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="features-wrapper" data-aos="fade-up">

                            @foreach($features as $index => $f)

                            <!-- FEATURE ITEM -->
                            <div class="iconic-box-item icon-left-box mb-25">
                                <div class="icon">
                                    <i class="fas {{ $f->icon }}"></i>
                                </div>
                                <div class="content">
                                    <h5>{{ $f->title }}</h5>
                                    <p>{{ $f->description }}</p>
                                </div>
                            </div>

                            <!-- DIVIDER -->
                            @if(!$loop->last)
                            <div class="divider mb-25">
                                <img src="{{ asset('assets/images/divider.png') }}">
                            </div>
                            @endif

                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </section><!--====== End Features Section ======-->

        <!--====== Start Category Section ======-->
        <section class="category-section pt-125 overflow-hidden">
            <div class="container">

                <!-- TITLE -->
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="section-title mb-50">
                            <div class="sub-heading d-inline-flex align-items-center">
                                <i class="flaticon-sparkler"></i>
                                <span class="sub-title">Categories</span>
                            </div>
                            <h2>Browse Top Category</h2>
                        </div>
                    </div>
                </div>

            </div>

            <!-- SLIDER -->
            <div class="category-slider-one">

                @forelse($categories as $cat)

                <div class="category-item style-one text-center">

                    <!-- IMAGE -->
                    <div class="category-img">
                        <img src="{{ asset('assets/images/categories/'.$cat->image) }}" alt="{{ $cat->name }}">
                    </div>

                    <!-- NAME -->
                    <div class="category-content">
                        <a href="#" class="category-btn">{{ $cat->name }}</a>
                    </div>

                </div>

                @empty

                <p class="text-center">No categories found</p>

                @endforelse

            </div>
        </section>
  <!--====== Start Features Products Section  ======-->
        <section class="features-products-section pt-85 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <!--=== Section Title  ===-->
                        <div class="section-title mb-50" data-aos="fade-right" data-aos-delay="10" data-aos-duration="1000">
                            <div class="sub-heading d-inline-flex align-items-center">
                                <i class="flaticon-sparkler"></i>
                                <span class="sub-title">Feature Products</span>
                            </div>
                            <h2>Our Features Collection</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!--=== Arrows ===-->
                        <div class="feature-arrows style-one mb-60" data-aos="fade-left" data-aos-delay="15" data-aos-duration="1200"></div>
                    </div>
                </div>
                <!--=== Feature Slider  ===-->
                <div class="feature-slider-one" data-aos="fade-up" data-aos-delay="20" data-aos-duration="1400">

                    @foreach($featuredProducts as $p)

                    <div class="product-item style-one mb-40">

                        <div class="product-thumbnail">

                            <img src="{{ asset('assets/images/products/'.$p->image) }}" alt="product">

                            {{-- DISCOUNT --}}
                            @if($p->sale_price)
                            <div class="discount">
                                {{ round((($p->price - $p->sale_price)/$p->price)*100) }}% Off
                            </div>
                            @endif

                            {{-- HOVER --}}
                            <div class="hover-content">
                                <a href="javascript:void(0)"
                                   class="icon-btn wishlistBtn"
                                   data-id="{{ $p->id }}">
                                    <i class="{{ in_array($p->id,$wishlistIds) ? 'fas' : 'far' }} fa-heart"></i>
                                </a>
                                <a href="{{ asset('assets/images/products/'.$p->image) }}" class="img-popup icon-btn">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>

                            {{-- CART --}}
                            <div class="cart-button">
                                <a href="javascript:void(0)"
                                   class="cart-btn addCart"
                                   data-id="{{ $p->id }}"
                                   data-price="{{ $p->sale_price ?? $p->price }}">
                                    <i class="far fa-shopping-basket"></i>
                                    <span class="text">
                                        Add To Cart
                                    </span>
                                </a>
                            </div>

                        </div>

                     <div class="minimal-product-content">

    <h4 class="product-title">
        {{ $p->name }}
    </h4>

    <p class="product-desc">
        {{ Str::limit(strip_tags($p->short_description ?? $p->description),55) }}
    </p>

    <div class="product-rating">
        ★★★★★
    </div>

    <div class="product-price">

        @if($p->sale_price)

            <span class="sale-price">
                ₹{{ $p->sale_price }}
            </span>

            <span class="old-price">
                ₹{{ $p->price }}
            </span>

        @else

            <span class="sale-price">
                ₹{{ $p->price }}
            </span>

        @endif

    </div>

    {{-- Example size buttons --}}
    <!-- <div class="product-size">

        <button class="active">
            250ml
        </button>

        <button>
            500ml
        </button>

        <button>
            1L
        </button>

    </div> -->

    <a href="javascript:void(0)"
       class="minimal-cart-btn addCart"
       data-id="{{ $p->id }}"
       data-price="{{ $p->sale_price ?? $p->price }}">

        Add to Cart

    </a>

</div>

                    </div>

                    @endforeach

                </div>
            </div>
        </section><!--====== End Features Products Section  ======-->

        <section class="banner-section pt-130">
             
            <div class="container">
                 <div class="section-title mb-50" data-aos="fade-right" data-aos-delay="10" data-aos-duration="1000">
                            <div class="sub-heading d-inline-flex align-items-center">
                                <i class="flaticon-sparkler"></i>
                                <span class="sub-title">Deals</span>
                            </div>
                            <h2>Our Deals</h2>
                        </div>
                <div class="row">

                    @foreach($deals as $index => $d)

                    <div class="col-lg-6">
                        <!--=== Banner Item ===-->
                        <div class="banner-item style-one {{ $index == 0 ? 'bg-one' : 'bg-two' }} mb-40"
                            data-aos="fade-up"
                            data-aos-delay="{{ $index == 0 ? '10' : '20' }}"
                            data-aos-duration="{{ $index == 0 ? '900' : '1100' }}">

                            <!-- SHAPES (KEEP SAME) -->
                            <div class="shape shape-one">
                                <span><img src="{{ asset('assets/images/banner/discount.png') }}"></span>
                            </div>

                            <div class="shape shape-two">
                                <span><img src="{{ asset('assets/images/banner/line.png') }}"></span>
                            </div>

                            <!-- IMAGE -->
                            <div class="banner-img">
                                <img src="{{ asset('assets/images/banner/'.$d->image) }}" alt="banner" width="338" height="357">
                            </div>

                            <!-- CONTENT -->
                            <div class="banner-content">

                                <span>
                                    UP TO
                                    <span class="off">
                                        @if($d->get_type == 'discount')
                                            {{ $d->discount_percent }}%
                                        @else
                                            FREE
                                        @endif
                                    </span>
                                </span>

                                <h4>{{ $d->title }}</h4>

                                <a href="{{ url('/shops') }}" class="theme-btn style-one">
                                    Shop Now
                                </a>

                            </div>

                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </section>

      
        <!--====== Start Working Section  ======-->
        <section class="work-processing-section pt-30 pb-90">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center mb-60">
                            <div class="sub-heading d-inline-flex align-items-center">
                                <i class="flaticon-sparkler"></i>
                                <span class="sub-title">Work Processing</span>
                                <i class="flaticon-sparkler"></i>
                            </div>
                            <h2>How it Work processing</h2>
                        </div>
                    </div>
                </div>

                <div class="row">

                    @foreach($steps as $step)
                    <div class="col-xl-3 col-sm-6">

                        <div class="iconic-box-item style-two mb-40">

                            {{-- STEP NUMBER --}}
                            <div class="sn-number">
                                {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                            </div>

                            {{-- ICON --}}
                            <div class="icon">
                                <i class="fas {{ $step->icon }}"></i>
                            </div>

                            {{-- CONTENT --}}
                            <div class="content">
                                <h6>{{ $step->title }}</h6>
                                <p>{{ $step->description }}</p>
                            </div>

                        </div>

                    </div>
                    @endforeach

                </div>

            </div>
        </section><!--====== End Working Section  ======-->

        <!--====== Start Trending Products Sections  ======-->
        <section class="trending-products-section pb-40 pb-130">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <!--=== Section Title  ===-->
                        <div class="section-title mb-50" data-aos="fade-right" data-aos-duration="1000">
                            <div class="sub-heading d-inline-flex align-items-center">
                                <i class="flaticon-sparkler"></i>
                                <span class="sub-title">Trending Products</span>
                            </div>
                            <h2>What's Trending Now</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!--=== Arrows ===-->
                        <div class="trending-product-arrows style-one mb-60" data-aos="fade-left" data-aos-duration="1200"></div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="trending-products-slider" data-aos="fade-up" data-aos-duration="1400">

                    @foreach($trendingProducts as $p)

                    <div class="product-item style-two">

                        <div class="product-thumbnail">
                            <img src="{{ asset('assets/images/products/'.$p->image) }}" alt="product">
                        </div>

                        <div class="product-info-wrap">

                            <div class="product-info">
                                <ul class="ratings rating5">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><a href="#">(0)</a></li>
                                </ul>

                                <h4 class="title">
                                    <a href="#">{{ $p->name }}</a>
                                </h4>
                            </div>

                            <div class="product-price">

                                @if($p->sale_price)
                                    <span class="price prev-price">
                                        ₹{{ $p->price }}
                                    </span>

                                    <span class="price new-price">
                                        ₹{{ $p->sale_price }}
                                    </span>
                                @else
                                    <span class="price new-price">
                                        ₹{{ $p->price }}
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>
            </div>
        </section><!--====== End Trending Products Sections  ======-->

        <!--====== Start Deal of the Week Section  ======-->
        <section class="best-deal-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        @php
                            $deal = $weeklyDeals->first(); // take latest one
                        @endphp

                        @if($deal)
                        <div class="offer-deal-wrapper bg_cover"
                            data-aos="fade-up"
                            data-aos-duration="1400"
                            style="background-image: url({{ asset('assets/images/bg/deal-bg-1.png') }});">

                            <!-- IMAGE -->
                            <div class="deal-img">
                                <span>
                                    <img src="{{ asset('assets/images/banner/'.$deal->image) }}" alt="Image" width="775" height="577">
                                </span>
                            </div>

                            <!-- CONTENT -->
                            <div class="deal-content">
                                <span class="sub-heading">
                                    <i class="fas fa-tags"></i>Deal of the Week
                                </span>

                                <h2>
                                    Hurry Up! Offer ends in. Get
                                    <span>{{ $deal->discount }}</span>
                                </h2>

                                <!-- COUNTDOWN -->
                                <div class="simply-countdown countdown-{{ $deal->id }} mb-60"
                                    data-date="{{ \Carbon\Carbon::parse($deal->end_date)->format('Y-m-d H:i:s') }}">
                                </div>

                                <!-- BUTTON -->
                                <div class="shop-button">
                                    <a href="{{ url('/shops') }}" class="theme-btn style-one">
                                        Shop Now
                                    </a>
                                </div>
                            </div>

                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </section><!--====== End Deal of the Week Section  ======-->

        <!--====== Start Testimonial Sections  ======-->
        <section class="testimonial-section">
            <div class="testimonial-wrapper overflow-x-hidden pt-190 pb-90 white-bg">
                <div class="shape svg-shape1"><img src="assets/images/testimonial/tl-svgBottom.svg" alt="svg shape"></div>
                <div class="shape svg-shape2"><img src="assets/images/testimonial/tl-svgBottom.svg" alt="svg shape"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <!--=== Section Content Box ===-->
                            <div class="section-content-box mb-40" data-aos="fade-right" data-aos-delay="30" data-aos-duration="800">
                                <div class="section-title mb-50">
                                    <h2>What Our Clients Say About Us</h2>
                                </div>
                                <div class="testimonial-arrows style-one"></div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <!--=== Testimonial Slider ===-->
                            <div class="testimonial-slider-one" data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000">

                                @foreach($testimonials as $t)

                                <!--=== Testimonial Item ===-->
                                <div class="testimonial-item style-one mb-40">
                                    <div class="testimonial-content">

                                        {{-- MESSAGE --}}
                                        <p>{{ $t->message }}</p>

                                        <div class="author-quote-item d-flex justify-content-between align-items-center">

                                            <div class="author-item">

                                                {{-- IMAGE --}}
                                                <div class="author-thumb">
                                                    <img
                                                        src="{{ $t->image
                                                            ? asset('assets/images/testimonials/'.$t->image)
                                                            : asset('assets/images/testimonial/author-1.png') }}"
                                                        alt="author image">
                                                </div>

                                                <div class="author-info">
                                                    <h5>{{ $t->name }}</h5>

                                                    {{-- STATIC STARS (UI SAME) --}}
                                                    <ul class="ratings rating5">
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                    </ul>
                                                </div>

                                            </div>

                                            <div class="quote-icon">
                                                <i class="flaticon flaticon-right-quote"></i>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Testimonial Sections  ======-->

        <!--====== Start Blog Sections  ======-->
        <!-- <section class="blog-page-section pt-120 pb-95">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                       
                        <div class="section-title text-center mb-60" data-aos="fade-up" data-aos-duration="1000">
                            <div class="sub-heading d-inline-flex align-items-center">
                                <i class="flaticon-sparkler"></i>
                                <span class="sub-title">Our Blogs</span>
                                <i class="flaticon-sparkler"></i>
                            </div>
                            <h2>Explore our Articles</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">

                        @if($mainBlog)
                        <div class="blog-post-item style-one mb-25" data-aos="fade-up" data-aos-delay="15" data-aos-duration="1000">

                            <div class="post-thumbnail">
                                <img src="{{ asset('assets/images/blog/'.$mainBlog->image) }}">
                            </div>
                            <div class="post-content">
                                <h3 class="title">
                                    <form action="{{ url('/blog-details') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $mainBlog->id }}">

                                        <button type="submit" style="background:none;border:none;padding:0;">
                                            {{ $mainBlog->title }}
                                        </button>
                                    </form>
                                </h3>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="col-lg-6">
                        <div class="row">

                            @foreach($smallBlogs as $blog)
                            <div class="col-sm-6">
                                <div class="blog-post-item style-two mb-25" data-aos="fade-up" data-aos-delay="20" data-aos-duration="1000">

                                    <div class="post-thumbnail">
                                        <img src="{{ asset('assets/images/blog/'.$blog->image) }}">
                                    </div>
                                    <div class="post-content">
                                        <h3 class="title">
                                            <form action="{{ url('/blog-details') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">

                                                <button type="submit" style="background:none;border:none;padding:0;">
                                                    {{ $blog->title }}
                                                </button>
                                            </form>
                                        </h3>
                                        <div class="post-meta">
                                            <span>{{ $blog->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <!--====== Start Newsletter Sections  ======-->
        <section class="newsletter-section pb-95">
            <div class="container">
                <!--=== Newsletter Wrapper  ===-->
                <div class="newsletter-wrapper white-bg p-r z-1" data-aos="fade-up" data-aos-duration="1000">
                    <div class="newsletter-shape pattern-one"><span><img src="assets/images/newsletter/pattern-1.png" alt="Pattern Shape"></span></div>
                    <div class="newsletter-shape pattern-two"><span><img src="assets/images/newsletter/pattern-2.png" alt="Pattern Shape"></span></div>
                    <!-- <div class="newsletter-shape shape-one"><span><img src="assets/images/newsletter/shape-1.png" alt="Shape"></span></div> -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="newsletter-content-box">
                                <span class="sub-text">Our Newsletter</span>
                                <h3>Get weekly update. Sign up and get up to <span>20% off</span> your first purchase</h3>
                                <form action="{{ url('/newsletter') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email"
                                               class="form_control"
                                               name="email"
                                               placeholder="Write your Email Address"
                                               required>

                                        <button class="theme-btn style-one">
                                            Subscribe
                                        </button>
                                    </div>
                                </form>

                                {{-- SUCCESS / ERROR MESSAGE --}}
                                @if(session('success'))
                                    <div class="alert alert-success mt-2">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger mt-2">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="newsletter-image">
                                <img src="{{ $newsletterBanner && $newsletterBanner->image
                                    ? asset('assets/images/banner/' . $newsletterBanner->image)
                                    : asset('assets/images/newsletter/newsletter-1.png') }}"
                                    alt="Newsletter Banner" width="511" height="380">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Newsletter Sections  ======-->
    </main>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/simplycountdown.js"></script>

<script>
document.querySelectorAll(".simply-countdown").forEach(function (el) {

    simplyCountdown(el, {
        year: new Date(el.dataset.date).getFullYear(),
        month: new Date(el.dataset.date).getMonth() + 1,
        day: new Date(el.dataset.date).getDate(),
        hours: new Date(el.dataset.date).getHours(),
        minutes: new Date(el.dataset.date).getMinutes(),
        seconds: new Date(el.dataset.date).getSeconds(),
        enableUtc: false
    });

});
$('.hero-slider-one').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,          // true if you want arrows
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 4000,    // 4 seconds
    speed: 1000,            // transition speed
    pauseOnHover: false,
    pauseOnFocus: false,
    cssEase: 'ease',
    adaptiveHeight: false
});
</script>
@endpush
@endsection