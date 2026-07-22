@extends('layouts.app')

@section('content')
<main class="main-bg">
    <section class="page-banner">
        <div class="container py-5">
            <h1>Shop</h1>
        </div>
    </section>

    <section class="shop-page-section pt-120 pb-80">
        <div class="container">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-xl-3">

                    <form method="GET" action="{{ route('shops') }}">

                        <div class="product-widget mb-4">
                            <h4>Categories</h4>

                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="category[]"
                                        value="{{ $category->id }}">
                                    <label class="form-check-label">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="product-widget mb-4">
                            <h4>Brands</h4>

                            @foreach($brands as $brand)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="brand[]"
                                        value="{{ $brand->id }}">
                                    <label class="form-check-label">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button class="theme-btn style-one w-100">
                            Apply Filters
                        </button>

                    </form>

                </div>

                <!-- Products -->
                <div class="col-xl-9">

                    <div class="row">

    @forelse($products as $p)

    <div class="col-xl-4 col-lg-6 col-md-6">

        <div class="product-item style-one mb-40">

            <div class="product-thumbnail">

                <img src="{{ asset('assets/images/products/'.$p->image) }}" alt="{{ $p->name }}">

                {{-- Discount --}}
                @if($p->sale_price)
                    <div class="discount">
                        {{ round((($p->price - $p->sale_price) / $p->price) * 100) }}% Off
                    </div>
                @endif

                {{-- Hover --}}
                <div class="hover-content">

                    <a href="javascript:void(0)"
                       class="icon-btn wishlistBtn"
                       data-id="{{ $p->id }}">

                        <i class="{{ in_array($p->id, $wishlistIds ?? []) ? 'fas' : 'far' }} fa-heart"></i>

                    </a>

                    <a href="{{ asset('assets/images/products/'.$p->image) }}"
                       class="img-popup icon-btn">

                        <i class="fa fa-eye"></i>

                    </a>

                </div>

                {{-- Add to Cart --}}
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
                      <a href="{{ asset('assets/images/products/'.$p->image) }}" class="img-popup icon-btn">
                <i class="fa fa-eye"></i>
            </a> 
                    </h4>

                </div>

                <div class="product-price">

                    @if($p->sale_price)

                        <span class="price prev-price">
                            ₹{{ number_format($p->price,2) }}
                        </span>

                        <span class="price new-price">
                            ₹{{ number_format($p->sale_price,2) }}
                        </span>

                    @else

                        <span class="price new-price">
                            ₹{{ number_format($p->price,2) }}
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

    @empty

        <div class="col-12">
            <div class="alert alert-warning text-center">
                No products found.
            </div>
        </div>

    @endforelse

</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>

                </div>

            </div>
        </div>
    </section>
</main>
@endsection
