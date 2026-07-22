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

<!-- ================= FORM CARD ================= -->
<div class="card mt-3">
<div class="card-body">

<form method="POST" action="/admin/settings/update" enctype="multipart/form-data">
@csrf

<div class="row">

<div class="col-md-6">
<label>Site Name</label>
<input type="text" name="site_name" 
value="{{ $setting->site_name ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Slogan</label>
<input type="text" name="slogan" 
value="{{ $setting->slogan ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Contact Number</label>
<input type="text" name="contact_number" 
value="{{ $setting->contact_number ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Email</label>
<input type="email" name="email" 
value="{{ $setting->email ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Facebook URL</label>
<input type="text" name="facebook_url" 
value="{{ $setting->facebook_url ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Instagram URL</label>
<input type="text" name="instagram_url" 
value="{{ $setting->instagram_url ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>LinkedIn URL</label>
<input type="text" name="linkedin_url" 
value="{{ $setting->linkedin_url ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Twitter URL</label>
<input type="text" name="twitter_url" 
value="{{ $setting->twitter_url ?? '' }}" 
class="form-control mb-2">
</div>

<div class="col-md-6">
<label>Logo (155x44)</label>
<input type="file" name="logo" class="form-control mb-2">

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