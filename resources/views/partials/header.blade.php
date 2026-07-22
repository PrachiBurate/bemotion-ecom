@php

    $session = session()->getId();

    $customer = Auth::guard('customer')->id();

    $wishlistCount = \App\Models\Wishlist::when($customer, function ($q) use ($customer) {

        $q->where('customer_id', $customer);

    }, function ($q) use ($session) {

        $q->where('session_id', $session);

    })->count();

    $cartCount = \App\Models\Cart::when($customer, function ($q) use ($customer) {

        $q->where('customer_id', $customer);

    }, function ($q) use ($session) {

        $q->where('session_id', $session);

    })->sum('quantity');

@endphp

<!--=== Top Announcement Bar ===-->
<div class="top-announcement-bar">
    {{ $setting->announcement ?? 'Free shipping on all orders over $50' }}
</div>

<header class="header-area">

    <!--===  Header Navigation  ===-->
    <div class="header-navigation style-one">
        <div class="container">
            <!--=== Primary Menu ===-->
            <div class="primary-menu">
                <!-- <div class="site-branding d-lg-none d-block">
                    <a href="{{ url('/') }}" class="brand-logo"><img src="assets/images/logo/logo-main.png"
                            alt="Logo"></a>
                </div> -->
                <!--=== Nav Inner Menu ===-->
                <div class="nav-inner-menu">

                    <div class="site-branding">
                        <a href="{{ url('/') }}" class="footer-logo">
                            <img src="{{ asset('assets/images/logo/' . $setting->logo) }}" alt="Logo">
                        </a>
                    </div>

                    <!--=== Pesco Nav Main ===-->
                    <div class="pesco-nav-main">
                        <!--=== Pesco Nav Menu ===-->
                        <div class="pesco-nav-menu">
                            <!--=== Responsive Menu Search ===-->
                            <div class="nav-search mb-40 d-block d-lg-none">
                                <div class="form-group">
                                    <input type="search" class="form_control" placeholder="Search Here" name="search">
                                    <button class="search-btn"><i class="far fa-search"></i></button>
                                </div>
                            </div>
                            <!--=== Responsive Menu Tab ===-->
                            <div class="pesco-tabs style-three d-block d-lg-none">
                                <ul class="nav nav-tabs mb-30" role="tablist">
                                    <li>
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav1"
                                            role="tab">Menu</button>
                                    </li>
                                    <li>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav2"
                                            role="tab">Category</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav1">
                                        <nav class="main-menu">
                                            <ul>
                                                <li class="menu-item"><a href="{{ url('/') }}">Home</a></li>
                                                <li><a href="{{ url('/shops') }}">Shop</a></li>
                                                <li class="menu-item has-children"><a href="{{ url('/blog') }}">Blog</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ url('/blog') }}">Our Blog</a></li>
                                                        <li><a href="{{ url('/blog-details') }}">Blog Details</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item has-children"><a href="#">Pages</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ url('/about') }}">About Us</a></li>
                                                        <li><a href="{{ url('/faq') }}">Faqs</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item"><a href="{{ url('/contact') }}">Contact</a>
                                                </li>
                                                <li class="menu-item"><a href="{{ url('/bulk-order') }}">Bulk
                                                        Orders</a></li>
                                                <li class="menu-item">
                                                    <a href="{{ url('/deals') }}">Deals</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="tab-pane fade" id="nav2">
                                        <div class="categori-dropdown-item">
                                            <ul>
                                                @foreach($categories as $cat)
                                                <li>
                                                    <a href="{{ url('/shops?category=' . $cat->id) }}">
                                                        <img src="{{ asset('assets/images/categories/' . $cat->image) }}" alt="{{ $cat->name }}">
                                                        {{ $cat->name }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--===  Hotline Support  ===-->
                            <div class="hotline-support d-flex d-lg-none mt-30">
                                <div class="icon">
                                    <i class="flaticon-support"></i>
                                </div>
                                <div class="info">
                                    <span>24/7 Support</span>
                                    <h5>
                                        <a href="tel:{{ $setting->contact_number ?? '' }}">
                                            {{ $setting->contact_number ?? 'Not Available' }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <!--=== Main Menu ===-->
                            <nav class="main-menu d-none d-lg-block">
                                <ul>
                                    <li class="menu-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('/shops') }}">Shop</a></li>
                                    <li class="menu-item"><a href="{{ url('blog') }}">Blog</a></li>
                                    <li class="menu-item"><a href="{{ url('/about') }}">Our Story</a></li>
                                    <li class="menu-item"><a href="{{ url('faq') }}">Faqs</a></li>
                                    <li class="menu-item"><a href="{{ url('/contact') }}">Contact</a></li>
                                    <li class="menu-item"><a href="{{ url('/bulk-order') }}">Bulk Orders</a></li>
                                    <li class="menu-item"><a href="{{ url('/deals') }}">Deals</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!--=== Nav Right Item ===-->
                <div class="nav-right-item style-one">
                    <ul class="d-flex align-items-center gap-3">

                        {{-- ❤️ WISHLIST --}}
                        <li>
                            <a href="{{ url('/wishlist') }}">
                                <div class="wishlist-btn d-lg-block d-none">
                                    <i class="far fa-heart"></i>
                                    <span class="pro-count">
                                        {{ $wishlistCount }}
                                    </span>
                                </div>
                            </a>
                        </li>

                        {{-- 🛒 CART --}}
                        <li>
                            <div class="cart-button d-flex align-items-center">
                                <div class="icon">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span class="pro-count">
                                        {{ $cartCount }}
                                    </span>
                                </div>
                            </div>
                        </li>

                        {{-- 👤 USER --}}
                        <li class="user-menu">

                            <a href="/login">
                                <i class="far fa-user"></i>
                            </a>

                            @if(Auth::guard('customer')->check())
                                <div class="user-dropdown-box">

                                    <div class="user-header">
                                        <i class="far fa-user-circle"></i>
                                        <div>
                                            <strong>{{ Auth::guard('customer')->user()->name }}</strong>
                                            <small>My Account</small>
                                        </div>
                                    </div>

                                    <a href="/my-orders" class="dropdown-item">
                                        <i class="far fa-box"></i> My Orders
                                    </a>
                                    <a href="/cart" class="dropdown-item">
                                        <i class="far fa-box"></i> My Cart
                                    </a>

                                    <a href="/logout" class="dropdown-item">
                                        <i class="far fa-sign-out"></i> Logout
                                    </a>

                                </div>
                            @endif

                        </li>

                    </ul>

                    <div class="navbar-toggler d-block d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>