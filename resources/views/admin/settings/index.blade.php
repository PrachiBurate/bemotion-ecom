@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- ================= HEADER ================= -->
<div class="page-header d-flex justify-content-between align-items-center">

    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Website Settings</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">Settings</li>
        </ul>
    </div>

</div>

<!-- SUCCESS -->
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<!-- ERROR (e.g. unauthorized) -->
@if(session('error'))
<div class="alert alert-danger mt-2">{{ session('error') }}</div>
@endif

<!-- VALIDATION ERRORS -->
@if($errors->any())
<div class="alert alert-danger mt-2">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- ================= FORM CARD ================= -->
<div class="card mt-3">
<div class="card-body">

<form method="POST" action="/admin/settings/update" enctype="multipart/form-data">
@csrf

<div class="row">

<div class="col-md-6">
<label>Site Name</label>
<input type="text" name="site_name"
value="{{ old('site_name', $setting->site_name ?? '') }}"
class="form-control mb-2 @error('site_name') is-invalid @enderror">
@error('site_name')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Slogan</label>
<input type="text" name="slogan"
value="{{ old('slogan', $setting->slogan ?? '') }}"
class="form-control mb-2 @error('slogan') is-invalid @enderror">
@error('slogan')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Contact Number</label>
<input type="text" name="contact_number"
value="{{ old('contact_number', $setting->contact_number ?? '') }}"
class="form-control mb-2 @error('contact_number') is-invalid @enderror">
@error('contact_number')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Email</label>
<input type="email" name="email"
value="{{ old('email', $setting->email ?? '') }}"
class="form-control mb-2 @error('email') is-invalid @enderror">
@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Facebook URL</label>
<input type="text" name="facebook_url"
value="{{ old('facebook_url', $setting->facebook_url ?? '') }}"
class="form-control mb-2 @error('facebook_url') is-invalid @enderror">
@error('facebook_url')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Instagram URL</label>
<input type="text" name="instagram_url"
value="{{ old('instagram_url', $setting->instagram_url ?? '') }}"
class="form-control mb-2 @error('instagram_url') is-invalid @enderror">
@error('instagram_url')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>LinkedIn URL</label>
<input type="text" name="linkedin_url"
value="{{ old('linkedin_url', $setting->linkedin_url ?? '') }}"
class="form-control mb-2 @error('linkedin_url') is-invalid @enderror">
@error('linkedin_url')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Twitter URL</label>
<input type="text" name="twitter_url"
value="{{ old('twitter_url', $setting->twitter_url ?? '') }}"
class="form-control mb-2 @error('twitter_url') is-invalid @enderror">
@error('twitter_url')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-6">
<label>Logo (155x44)</label>
<input type="file" name="logo" accept="image/*"
class="form-control mb-2 @error('logo') is-invalid @enderror">
@error('logo')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

@if(!empty($setting->logo))
<img src="{{ asset('assets/images/logo/'.$setting->logo) }}" height="40">
@endif
</div>

</div>

<div class="text-end mt-3">
@if($user->hasPermission('settings.update') || $user->is_admin)
<button class="btn btn-success">Save Settings</button>
@endif
</div>

</form>

</div>
</div>

</div>
</main>

@endsection