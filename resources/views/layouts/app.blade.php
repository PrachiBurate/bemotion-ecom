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

    <!-- Google Fonts: Fraunces (display/serif) + DM Sans (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..600;1,9..144,400..500&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/flaticon_pesco.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
 

    @stack('styles')
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

                <!-- Header -->
                <div class="cart-header">
                    <h4>My Cart</h4>
                    <div class="sidemenu-cart-close">
                        <i class="far fa-times"></i>
                    </div>
                </div>

                <!-- Body -->
                <div class="widget-shopping-cart-content">
                    <ul class="pesco-mini-cart-list"></ul>
                </div>

            </div>
        </div>
    </div><!--====== End Sidemenu-wrapper-cart Area ======-->

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!--====== Back To Top  ======-->
    <div class="back-to-top"><i class="far fa-angle-up"></i></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    <!-- <script src="{{ asset('assets/js/cart.js') }}"></script> -->

    <script>
        function loadCart(){
            $('.widget-shopping-cart-content').load('/cart/sidebar');
        }

        jQuery(document).on('click','.addCart',function(e){
            e.preventDefault();
            let id = jQuery(this).data('id');
            let price = jQuery(this).data('price');

            jQuery.ajax({
                url: "{{ url('/cart/add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id,
                    price: price
                },
              success:function(res){

    loadCart();
    updateHeaderCounts();

    $('.sidemenu-wrapper-cart').addClass('cart-on');
    $('.offcanvas__overlay').addClass('overlay-open');

}
            });
        });

        $(document).ready(function(){
            loadCart();
        });

     

     $(document).on('click','.qtyPlus',function(){

    $.post('/cart/increase',{
        _token:"{{ csrf_token() }}",
        id:$(this).data('id')
    },function(){

        loadCart();
        updateHeaderCounts();

    });

});

$(document).on('click','.qtyMinus',function(){

    $.post('/cart/decrease',{
        _token:"{{ csrf_token() }}",
        id:$(this).data('id')
    },function(){

        loadCart();
        updateHeaderCounts();

    });

});
       $(document).on('click','.removeCart',function(){

    $.post('/cart/remove',{
        _token:"{{ csrf_token() }}",
        id:$(this).data('id')
    },function(){

        loadCart();
        updateHeaderCounts();

    });

});
        $(document).on('click','.wishlistBtn',function(e){
            e.preventDefault();
            let btn=$(this);

            $.ajax({
                url:'/wishlist/toggle',
                type:'POST',
                data:{
                    _token:"{{ csrf_token() }}",
                    product_id:btn.data('id')
                },
               success:function(res){

    let icon = btn.find('i');

    if(res.action == 'added'){
        icon.removeClass('far').addClass('fas');
        btn.addClass('active');
    }else{
        icon.removeClass('fas').addClass('far');
        btn.removeClass('active');
    }

    updateHeaderCounts();

}
            });
        });
    </script>
    <script>
        $(document).on('click','.wishlistRemove',function(){
            let id=$(this).data('id');

            $.ajax({
                url:"{{ url('/wishlist/remove') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:id
                },
                success:function(res){
                    if(res.status){
                        location.reload();
                    }
                }
            });
        });

        $(document).on('click','.moveToCart',function(){
            let product_id=$(this).data('id');

            $.ajax({
                url:"{{ url('/wishlist/move-to-cart') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    product_id:product_id
                },
           success:function(res){

    loadCart();
    updateHeaderCounts();

    $('.sidemenu-wrapper-cart').addClass('cart-on');
    $('.offcanvas__overlay').addClass('overlay-open');

}
            });
        });

        $(document).on('click','.sidemenu-cart-close',function(){

    $('.sidemenu-wrapper-cart').removeClass('cart-on');
    $('.offcanvas__overlay').removeClass('overlay-open');

});


$(document).on('click','.offcanvas__overlay',function(){

    $('.sidemenu-wrapper-cart').removeClass('cart-on');
    $('.offcanvas__overlay').removeClass('overlay-open');

});

function updateHeaderCounts() {
    $.get('/header-counts', function(res) {
        $('.cart-button .pro-count').text(res.cart);
        $('.wishlist-btn .pro-count').text(res.wishlist);
    });
}

$(document).ready(function(){

    loadCart();
    updateHeaderCounts();

});
    </script>
    @stack('scripts')
</body>
</html>