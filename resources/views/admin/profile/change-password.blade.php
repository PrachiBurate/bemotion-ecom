@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp
<style>
.toggle-password {
    position: absolute;
    top: 38px;
    right: 15px;
    cursor: pointer;
    color: #888;
}
</style>
<main class="nxl-container">
<div class="nxl-content">

<!-- ================= HEADER ================= -->
<div class="page-header d-flex justify-content-between align-items-center">
    
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Change Password</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">Change Password</li>
        </ul>
    </div>

</div>

<!-- ================= MESSAGES ================= -->
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-2">{{ session('error') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger mt-2">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- ================= FORM CARD ================= -->
<div class="card mt-3">
<div class="card-body">

<form method="POST" action="{{ route('profile.password.update') }}">
@csrf

<div class="mb-3 position-relative">
    <label class="form-label">Old Password</label>

    <input type="password"
           name="old_password"
           class="form-control password-field @error('old_password') is-invalid @enderror"
           placeholder="Enter old password"
           required>

    <i class="feather-eye toggle-password"></i>

    @error('old_password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 position-relative">
    <label class="form-label">New Password</label>

    <input type="password"
           name="new_password"
           class="form-control password-field @error('new_password') is-invalid @enderror"
           placeholder="Enter new password"
           required>

    <i class="feather-eye toggle-password"></i>

    @error('new_password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 position-relative">
    <label class="form-label">Confirm Password</label>

    <input type="password"
           name="confirm_password"
           class="form-control password-field @error('confirm_password') is-invalid @enderror"
           placeholder="Confirm new password"
           required>

    <i class="feather-eye toggle-password"></i>

    @error('confirm_password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="text-end">
<button class="btn btn-success">Update Password</button>
</div>

</form>

</div>
</div>

</div>
</main>
<script>
document.querySelectorAll('.toggle-password').forEach((icon, index) => {
    icon.addEventListener('click', function () {
        let input = this.previousElementSibling;

        if (input.type === "password") {
            input.type = "text";
            this.classList.remove("feather-eye");
            this.classList.add("feather-eye-off");
        } else {
            input.type = "password";
            this.classList.remove("feather-eye-off");
            this.classList.add("feather-eye");
        }
    });
});
</script>
@endsection