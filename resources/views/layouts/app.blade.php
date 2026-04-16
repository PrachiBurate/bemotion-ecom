<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="eCommerce,shop,fashion">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Pesco - eCommerce</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/flaticon_pesco.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
  <div class="preloader">
            <div class="loader">
                <img src="assets/images/loader.gif" alt="Loader">
            </div>
        </div>
          <!--======  Start Overlay  ======-->
        <div class="offcanvas__overlay"></div>
        <!--====== Start Sidemenu-wrapper-cart Area ======-->
        <div class="sidemenu-wrapper-cart">
            <div class="sidemenu-content">
                <div class="widget widget-shopping-cart">
                    <h4>My cart</h4>
                    <div class="sidemenu-cart-close"><i class="far fa-times"></i></div>
                    <div class="widget-shopping-cart-content">
                        <ul class="pesco-mini-cart-list">
                            <li class="sidebar-cart-item">
                                <a href="#" class="remove-cart"><i class="far fa-trash-alt"></i></a>
                                <a href="#">
                                    <img src="assets/images/products/cart-1.jpg" alt="cart image">
                                    leggings with mesh panels
                                </a>
                                <span class="quantity">1 × <span><span class="currency">$</span>940.00</span></span>
                            </li>
                            <li class="sidebar-cart-item">
                                <a href="#" class="remove-cart"><i class="far fa-trash-alt"></i></a>
                                <a href="#">
                                    <img src="assets/images/products/cart-2.jpg" alt="cart image">
                                    Summer dress with belt
                                </a>
                                <span class="quantity">1 × <span><span class="currency">$</span>940.00</span></span>
                            </li>
                            <li class="sidebar-cart-item">
                                <a href="#" class="remove-cart"><i class="far fa-trash-alt"></i></a>
                                <a href="#">
                                    <img src="assets/images/products/cart-3.jpg" alt="cart image">
                                    Floral print sundress
                                </a>
                                <span class="quantity">1 × <span><span class="currency">$</span>940.00</span></span>
                            </li>
                            <li class="sidebar-cart-item">
                                <a href="#" class="remove-cart"><i class="far fa-trash-alt"></i></a>
                                <a href="#">
                                    <img src="assets/images/products/cart-4.jpg" alt="cart image">
                                    Sheath Gown Red Colors
                                </a>
                                <span class="quantity">1 × <span><span class="currency">$</span>940.00</span></span>
                            </li>
                        </ul>
                        <div class="cart-mini-total">
                            <div class="cart-total">
                                <span><strong>Subtotal:</strong></span> <span class="amount">1 × <span><span class="currency">$</span>940.00</span></span>
                            </div>
                        </div>
                        <div class="cart-button-box">
                            <a href="checkout.html" class="theme-btn style-one">Proceed to checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--====== End Sidemenu-wrapper-cart Area ======-->
    @include('partials.header')

    @yield('content')

    @include('partials.footer')
   <!--====== Back To Top  ======-->
        <div class="back-to-top" ><i class="far fa-angle-up"></i></div>
        <script src="{{ asset('assets/vendor/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap js -->
<script src="{{ asset('assets/vendor/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Slick js -->
<script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>

<!-- Magnific js -->
<script src="{{ asset('assets/vendor/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>

<!-- Nice-select js -->
<script src="{{ asset('assets/vendor/nice-select/js/jquery.nice-select.min.js') }}"></script>

<!-- Jquery UI js -->
<script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- SimplyCountdown js -->
<script src="{{ asset('assets/vendor/simplyCountdown.min.js') }}"></script>

<!-- Aos js -->
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

<!-- Main js -->
<script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>