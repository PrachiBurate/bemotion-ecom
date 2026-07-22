<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

 <meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="" />
<meta name="keyword" content="" />
<meta name="author" content="flexilecode" />

<!-- Title -->
<title>@yield('title', 'Admin Dashboard')</title>

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-assets/images/favicon.ico') }}" />

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('admin-assets/vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendors/css/daterangepicker.min.css') }}" />

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/theme.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- IE Support -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>

    @include('admin.partials.sidebar')
    @include('admin.partials.header')

    <div class="content">
        @yield('content')
    </div>

 <!-- Vendors JS (must be on top) -->
<script src="{{ asset('admin-assets/vendors/js/vendors.min.js') }}"></script>

<script src="{{ asset('admin-assets/vendors/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendors/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendors/js/circle-progress.min.js') }}"></script>

<!-- Apps Init -->
<script src="{{ asset('admin-assets/js/common-init.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/dashboard-init.min.js') }}"></script>

<!-- Theme Customizer -->
<script src="{{ asset('admin-assets/js/theme-customizer-init.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js"></script>
<script>
$(function () {

    $('.iconpicker').iconpicker({
        placement: 'bottomRight',
        animation: true,
        hideOnSelect: true,
        searchInFooter: true
    });

    // 🔥 FIX FOR MODAL
    $(document).on('shown.bs.modal', function () {
        $('.iconpicker').iconpicker('update');
    });

});


</script>
@yield('scripts')

</body>
</html>