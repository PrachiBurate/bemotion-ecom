  <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
              <a href="{{ url('/dashboard') }}" class="b-brand">
    <!-- Main Logo -->
    <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo" class="logo logo-lg" />

    <!-- Small Logo -->
    <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo" class="logo logo-sm" />
</a>
            </div>
            <div class="navbar-content">
                <ul class="nxl-navbar">
                    <li class="nxl-item nxl-caption">
                        <label>Navigation</label>
                    </li>
               
        @if(auth()->user()->hasPermission('dashboard.view'))
        <li class="nxl-item">
            <a class="nxl-link" href="{{ url('/dashboard') }}">
             <span class="nxl-micon"><i class="feather-airplay"></i></span>    
            Dashboard</a>
        </li>
        @endif

                     @if(auth()->user()->hasPermission('roles.view') || auth()->user()->hasPermission('users.view'))

<li class="nxl-item nxl-hasmenu">

    <a href="javascript:void(0);" class="nxl-link">
        <span class="nxl-micon"><i class="feather-users"></i></span>
        <span class="nxl-mtext">Roles</span>
        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
    </a>

    <ul class="nxl-submenu">

        {{-- Roles --}}
        @if(auth()->user()->hasPermission('roles.view'))
        <li class="nxl-item">
            <a class="nxl-link" href="/roles">Roles Management</a>
        </li>
        @endif

        {{-- Users --}}
        @if(auth()->user()->hasPermission('users.view'))
        <li class="nxl-item">
            <a class="nxl-link" href="/users">Users Management</a>
        </li>
        @endif

    </ul>

</li>

@endif

                @php $user = auth()->user(); @endphp

@if(
    $user->hasPermission('blogs.view') ||
    $user->hasPermission('comments.view') ||
    $user->is_admin
)

<li class="nxl-item nxl-hasmenu">
    <a href="javascript:void(0);" class="nxl-link">
        <span class="nxl-micon"><i class="feather-book-open"></i></span>
        <span class="nxl-mtext">Blogs</span>
        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
    </a>

    <ul class="nxl-submenu">

        {{-- BLOGS CRUD --}}
        @if($user->hasPermission('blogs.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="/blogs">
                Blogs Management
            </a>
        </li>
        @endif

        {{-- BLOG COMMENTS --}}
        @if($user->hasPermission('comments.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="/blog-comments">
                Blog Comments
            </a>
        </li>
        @endif

    </ul>
</li>

@endif

@php $user = auth()->user(); @endphp

@if(
    $user->hasPermission('banners.view') ||
    $user->is_admin
)

<li class="nxl-item">
    <a class="nxl-link" href="/banners">
        <span class="nxl-micon"><i class="feather-image"></i></span>
        <span class="nxl-mtext">Banners</span>
    </a>
</li>

@endif

@php $user = auth()->user(); @endphp

@if($user->hasPermission('hero.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="/admin/hero">
        <span class="nxl-micon"><i class="feather-sliders"></i></span>
        <span class="nxl-mtext">Hero Slider</span>
    </a>
</li>

@endif
@php $user = auth()->user(); @endphp

@if($user->hasPermission('features.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="/admin/features">
        <span class="nxl-micon"><i class="feather-star"></i></span>
        <span class="nxl-mtext">Features</span>
    </a>
</li>

@endif
@php $user = auth()->user(); @endphp

@if(
    $user->hasPermission('faqs.view') ||
    $user->hasPermission('faq_queries.view') ||
    $user->is_admin
)

<li class="nxl-item nxl-hasmenu">
    <a href="javascript:void(0);" class="nxl-link">
        <span class="nxl-micon"><i class="feather-help-circle"></i></span>
        <span class="nxl-mtext">FAQs</span>
        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
    </a>

    <ul class="nxl-submenu">

        {{-- FAQ MANAGEMENT --}}
        @if($user->hasPermission('faqs.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="/faqs">
                FAQs Management
            </a>
        </li>
        @endif

        {{-- FAQ QUERIES --}}
        @if($user->hasPermission('faq_queries.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="{{ route('faq.queries') }}">
                FAQ Queries
            </a>
        </li>
        @endif

    </ul>
</li>

@endif
                
@if($user->hasPermission('contact_queries.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="{{ route('contact.queries') }}">
        <span class="nxl-micon"><i class="feather-mail"></i></span>
        <span class="nxl-mtext">Contact Queries</span>
    </a>
</li>
@endif

@php $user = auth()->user(); @endphp

@if(
    $user->hasPermission('office_locations.view') ||
    $user->is_admin
)

<li class="nxl-item">
    <a class="nxl-link" href="{{ route('offices') }}">
        <span class="nxl-micon"><i class="feather-map-pin"></i></span>
        <span class="nxl-mtext">Office Locations</span>
    </a>
</li>

@endif

@if($user->hasPermission('categories.view') || $user->hasPermission('subcategories.view') || $user->hasPermission('brands.view') || $user->hasPermission('products.view') || $user->hasPermission('deals.view') ||$user->hasPermission('combos.view')|| $user->hasPermission('bundles.view')|| $user->is_admin )

<li class="nxl-item nxl-hasmenu">
    <a href="javascript:void(0);" class="nxl-link">
        <span class="nxl-micon"><i class="feather-grid"></i></span>
        <span class="nxl-mtext">Products</span>
        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
    </a>

    <ul class="nxl-submenu">
 @if($user->hasPermission('categories.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="/admin/categories">Categories</a>
        </li>
@endif
 @if($user->hasPermission('subcategories.view') || $user->is_admin)

        <li class="nxl-item">
            <a class="nxl-link" href="/admin/subcategories">Subcategories</a>
        </li>
@endif

 @if($user->hasPermission('brands.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="/admin/brands">
      
        <span class="nxl-mtext">Brands</span>
    </a>
</li>
@endif
 @if($user->hasPermission('products.view') || $user->is_admin)


<li class="nxl-item">
    <a class="nxl-link" href="{{ route('products') }}">
        Products
    </a>
</li>
@endif
 @if($user->hasPermission('deals.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="{{ url('/admin/deals') }}">
        Deals
    </a>
</li>
@endif
 @if($user->hasPermission('combos.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="{{ route('combos') }}">
        Combos
    </a>
</li>
@endif

 @if($user->hasPermission('bundles.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="{{ route('bundles') }}">
        Bundles
    </a>
</li>
@endif

    </ul>

    


</li>

@endif


@php $user = auth()->user(); @endphp

@if($user->hasPermission('bulk_orders.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="{{ route('bulk.orders') }}">
        <span class="nxl-micon"><i class="feather-shopping-cart"></i></span>
        <span class="nxl-mtext">Bulk Orders</span>
    </a>
</li>
@endif

@php $user = auth()->user(); @endphp

@if($user->hasPermission('coupons.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="{{ url('/admin/coupons') }}">
        <span class="nxl-micon"><i class="feather-tag"></i></span>
        <span class="nxl-mtext">Coupons</span>
    </a>
</li>
@endif

@if($user->hasPermission('settings.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="{{ route('settings') }}">
        <span class="nxl-micon"><i class="feather-settings"></i></span>
        <span class="nxl-mtext">Web Settings</span>
    </a>
</li>
@endif
@php $user = auth()->user(); @endphp

@if($user->hasPermission('orders.view') || $user->hasPermission('transactions.view') || $user->is_admin)

<li class="nxl-item nxl-hasmenu">
    <a href="javascript:void(0);" class="nxl-link">
        <span class="nxl-micon"><i class="feather-shopping-bag"></i></span>
        <span class="nxl-mtext">Orders</span>
        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
    </a>

    <ul class="nxl-submenu">

        {{-- ORDERS --}}
        @if($user->hasPermission('orders.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="/admin/orders">
                Orders
            </a>
        </li>
        @endif

        {{-- TRANSACTIONS --}}
        @if($user->hasPermission('transactions.view') || $user->is_admin)
        <li class="nxl-item">
            <a class="nxl-link" href="/admin/transactions">
                Transactions
            </a>
        </li>
        @endif

    </ul>
</li>

@endif

@php $user = auth()->user(); @endphp

@if(
    $user->hasPermission('pages.view') ||
    $user->is_admin
)

<li class="nxl-item">
    <a class="nxl-link" href="/admin/pages">
        <span class="nxl-micon"><i class="feather-file-text"></i></span>
        <span class="nxl-mtext">Pages</span>
    </a>
</li>

@endif

@php $user = auth()->user(); @endphp

@if($user->hasPermission('testimonials.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="{{ url('/admin/testimonials') }}">
        <span class="nxl-micon"><i class="feather-message-circle"></i></span>
        <span class="nxl-mtext">Testimonials</span>
    </a>
</li>
@endif

@php $user = auth()->user(); @endphp

@if($user->hasPermission('process_steps.view') || $user->is_admin)

<li class="nxl-item">
    <a class="nxl-link" href="/admin/process-steps">
        <span class="nxl-micon"><i class="feather-layers"></i></span>
        <span class="nxl-mtext">Process Steps</span>
    </a>
</li>

@endif

@php $user = auth()->user(); @endphp

@if($user->hasPermission('weekly_deals.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="/admin/weekly-deals">
        <span class="nxl-micon"><i class="feather-tag"></i></span>
        <span class="nxl-mtext">Weekly Deals</span>
    </a>
</li>
@endif
@php $user = auth()->user(); @endphp

@if($user->hasPermission('teams.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="/admin/teams">
        <span class="nxl-micon"><i class="feather-users"></i></span>
        <span class="nxl-mtext">Teams</span>
    </a>
</li>
@endif
@php $user = auth()->user(); @endphp

@if($user->hasPermission('about.view') || $user->is_admin)
<li class="nxl-item">
    <a class="nxl-link" href="/admin/about">
        <span class="nxl-micon"><i class="feather-info"></i></span>
        <span class="nxl-mtext">About Section</span>
    </a>
</li>
@endif
                </ul>
                <div class="card text-center">
                    <div class="card-body">
                        <i class="feather-sunrise fs-4 text-dark"></i>
                        <h6 class="mt-4 text-dark fw-bolder">View Website</h6>
                      <p class="fs-11 my-3 text-dark"> Open the website to see your changes.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary text-dark w-100">View Now</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>