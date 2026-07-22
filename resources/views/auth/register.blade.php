@extends('layouts.app')

@section('content')

<main class="main-bg">

<section class="contact-section pt-75 pb-70">
<div class="container">
<div class="row">

<div class="col-lg-8">

<div class="contact-wrapper p-r z-1 mb-50">

<h3>Create Account</h3>
<p class="mb-20">Join us and start shopping</p>

{{-- SUCCESS --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

{{-- ERROR --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form class="pesco-contact-form" method="POST" action="/register">
@csrf

<div class="row">

    {{-- NAME --}}
    <div class="col-lg-6">
        <div class="form-group">
            <input type="text" name="name" placeholder="Full Name" class="form_control" required>
        </div>
    </div>

    {{-- EMAIL --}}
    <div class="col-lg-6">
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form_control" required>
        </div>
    </div>

    {{-- PHONE --}}
    <div class="col-lg-6">
        <div class="form-group">
            <input type="text" name="phone" placeholder="Phone Number" class="form_control">
        </div>
    </div>

    {{-- PASSWORD --}}
    <div class="col-lg-6">
        <div class="form-group position-relative">
            <input type="password" id="password1" name="password" placeholder="Password" class="form_control" required>
            <span onclick="togglePassword('password1')" class="eye-icon">👁️</span>
        </div>
    </div>

    {{-- CONFIRM PASSWORD --}}
    <div class="col-lg-12">
        <div class="form-group position-relative">
            <input type="password" id="password2" name="password_confirmation" placeholder="Confirm Password" class="form_control" required>
            <span onclick="togglePassword('password2')" class="eye-icon">👁️</span>
        </div>
    </div>

    {{-- BUTTON --}}
    <div class="col-lg-12">
        <div class="form_group">
            <button type="submit" class="theme-btn style-one">
                Register Now
            </button>
        </div>
    </div>

</div>

</form>

<div class="text-center mt-3">
<p>
Already have an account? 
<a href="/login">Login</a>
</p>
</div>

</div>
</div>

{{-- RIGHT SIDE IMAGE SAME AS CONTACT --}}
<div class="col-lg-4">
    <div class="contact-img-text text-center mb-50 d-none d-lg-block">
        <img src="assets/images/contact/text-img.png" alt="Text">
    </div>
</div>

</div>
</div>
</section>

</main>

{{-- PASSWORD TOGGLE --}}
<script>
function togglePassword(id){
    let input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

<style>
.eye-icon{
    position:absolute;
    right:15px;
    top:12px;
    cursor:pointer;
}
</style>

@endsection