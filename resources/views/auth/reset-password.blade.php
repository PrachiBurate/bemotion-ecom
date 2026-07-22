@extends('layouts.app')

@section('content')

<section class="contact-section pt-75 pb-70">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="contact-wrapper">

<h3>Reset Password</h3>

<form method="POST" action="{{ route('password.update') }}">
@csrf

<input type="hidden" name="token" value="{{ $token }}">

<input
type="email"
name="email"
value="{{ $email }}"
class="form_control mb-3"
readonly>

<input
type="password"
name="password"
placeholder="New Password"
class="form_control mb-3"
required>

<input
type="password"
name="password_confirmation"
placeholder="Confirm Password"
class="form_control mb-3"
required>

<button class="theme-btn style-one">
Reset Password
</button>

</form>

</div>

</div>

</div>

</div>

</section>

@endsection