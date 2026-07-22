@extends('layouts.app')

@section('content')

<section class="contact-section pt-75 pb-70">
<div class="container">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="contact-wrapper">

<h3>Forgot Password</h3>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="form-group">

<input
type="email"
name="email"
placeholder="Enter your email"
class="form_control"
required>

</div>

<button class="theme-btn style-one">
Send Reset Link
</button>

</form>

</div>

</div>

</div>

</div>
</section>

@endsection