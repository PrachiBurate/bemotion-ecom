@extends('layouts.app')

@section('content')
<main class="main-bg">

    <section class="page-banner">
        <div class="page-banner-wrapper p-r z-1">
            <div class="container">
                <div class="page-banner-content">
                    <h1>Checkout</h1>
                    <ul class="breadcrumb-link">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="far fa-long-arrow-right"></i></li>
                        <li class="active">Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="checkout-section pt-120 pb-80">
        <div class="container">

            <form class="checkout-form"
                  method="POST"
                  action="{{ route('checkout.placeOrder') }}">
                @csrf

                <div class="row">

                    <div class="col-xl-7">

                        <div class="billing-wrapper">

                            <h3 class="title">Billing Details</h3>

                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text"
                                       class="form_control"
                                       name="name"
                                       value="{{ old('name',$customer->name) }}">
                            </div>

                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email"
                                       class="form_control"
                                       name="email"
                                       value="{{ old('email',$customer->email) }}">
                            </div>

                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="text"
                                       class="form_control"
                                       name="phone"
                                       value="{{ old('phone',$customer->phone) }}">
                            </div>

                            <div class="form-group">
                                <label>Address *</label>
                                <textarea class="form_control"
                                          name="address">{{ old('address') }}</textarea>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <input class="form_control"
                                           name="city"
                                           placeholder="City"
                                           value="{{ old('city') }}">
                                </div>

                                <div class="col-md-4">
                                    <input class="form_control"
                                           name="state"
                                           placeholder="State"
                                           value="{{ old('state') }}">
                                </div>

                                <div class="col-md-4">
                                    <input class="form_control"
                                           name="pincode"
                                           placeholder="Pincode"
                                           value="{{ old('pincode') }}">
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-5">

                        <div class="order-summary-wrapper">

                            <h3>Order Summary</h3>

                            <div class="order-list">

                                @foreach($cart as $item)

                                <div class="d-flex justify-content-between mb-3">

                                    <div>
                                        {{ $item->product->name }}
                                        × {{ $item->quantity }}
                                    </div>

                                    <div>
                                        ₹{{ number_format($item->price * $item->quantity,2) }}
                                    </div>

                                </div>

                                @endforeach

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <strong>Subtotal</strong>
                                    <strong>₹{{ number_format($subtotal,2) }}</strong>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <span>Shipping</span>
                                    <span>₹{{ number_format($shipping,2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <span>Tax</span>
                                    <span>₹{{ number_format($tax,2) }}</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong>₹{{ number_format($total,2) }}</strong>
                                </div>

                            </div>

                        </div>

                        <div class="payment-method-wrapper mt-4">

                            <h4>Payment Method</h4>

                            <label>
                                <input type="radio"
                                       name="payment_method"
                                       value="COD"
                                       checked>
                                Cash On Delivery
                            </label>

                            <br>

                            <label>
                                <input type="radio"
                                       name="payment_method"
                                       value="Bank Transfer">
                                Bank Transfer
                            </label>

                            <br>

                            <label>
                                <input type="radio"
                                       name="payment_method"
                                       value="Check">
                                Check
                            </label>

                            <button type="submit"
                                    class="theme-btn style-one w-100 mt-4">
                                Place Order
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>
    </section>

</main>
@endsection
