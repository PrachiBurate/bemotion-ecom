@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header">
    <h5>About Section Management</h5>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    <strong>Please fix the following:</strong>
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card mt-3">
<div class="card-body">

<form method="POST" action="/admin/about/update/{{ $about->id }}" enctype="multipart/form-data" novalidate>
@csrf

<!-- ================= TITLE ================= -->
<label>Title</label>
<input type="text" name="title" value="{{ old('title', $about->title) }}"
    class="form-control mb-1 @error('title') is-invalid @enderror">
@error('title')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<!-- ================= SUBTITLE ================= -->
<label>Subtitle</label>
<input type="text" name="subtitle" value="{{ old('subtitle', $about->subtitle) }}"
    class="form-control mb-1 @error('subtitle') is-invalid @enderror">
@error('subtitle')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<!-- ================= DESCRIPTION ================= -->
<label>Description</label>
<textarea name="description" class="form-control mb-1 @error('description') is-invalid @enderror">{{ old('description', $about->description) }}</textarea>
@error('description')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<!-- ================= EXPERIENCE ================= -->
<label>Experience Years</label>
<input type="number" name="experience_year" value="{{ old('experience_year', $about->experience_year) }}"
    class="form-control mb-1 @error('experience_year') is-invalid @enderror">
@error('experience_year')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<hr>

<!-- ================= MAIN IMAGES ================= -->
<h6>Main Images</h6>

<label>Image 1</label>
<input type="file" name="image1" class="form-control mb-1 @error('image1') is-invalid @enderror">
@error('image1')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->image1)
<img src="{{ asset('assets/images/about/'.$about->image1) }}" width="120" class="mb-3 d-block">
@endif

<label>Image 2</label>
<input type="file" name="image2" class="form-control mb-1 @error('image2') is-invalid @enderror">
@error('image2')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->image2)
<img src="{{ asset('assets/images/about/'.$about->image2) }}" width="120" class="mb-3 d-block">
@endif

<hr>

<!-- ================= THUMB IMAGES ================= -->
<h6>Thumbnail Images</h6>

<label>Thumb 1</label>
<input type="file" name="thumb1" class="form-control mb-1 @error('thumb1') is-invalid @enderror">
@error('thumb1')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->thumb1)
<img src="{{ asset('assets/images/about/'.$about->thumb1) }}" width="100" class="mb-3 d-block">
@endif

<label>Thumb 2</label>
<input type="file" name="thumb2" class="form-control mb-1 @error('thumb2') is-invalid @enderror">
@error('thumb2')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->thumb2)
<img src="{{ asset('assets/images/about/'.$about->thumb2) }}" width="100" class="mb-3 d-block">
@endif

<hr>

<!-- ================= LIST ================= -->
<h6>Features List</h6>

<input type="text" name="list1" value="{{ old('list1', $about->list1) }}"
    class="form-control mb-1 @error('list1') is-invalid @enderror" placeholder="List 1">
@error('list1')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<input type="text" name="list2" value="{{ old('list2', $about->list2) }}"
    class="form-control mb-1 @error('list2') is-invalid @enderror" placeholder="List 2">
@error('list2')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<input type="text" name="list3" value="{{ old('list3', $about->list3) }}"
    class="form-control mb-1 @error('list3') is-invalid @enderror" placeholder="List 3">
@error('list3')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<hr>

<!-- ================= AUTHOR ================= -->
<h6>Author Details</h6>

<label>Name</label>
<input type="text" name="author_name" value="{{ old('author_name', $about->author_name) }}"
    class="form-control mb-1 @error('author_name') is-invalid @enderror">
@error('author_name')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<label>Position</label>
<input type="text" name="author_position" value="{{ old('author_position', $about->author_position) }}"
    class="form-control mb-1 @error('author_position') is-invalid @enderror">
@error('author_position')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

<label>Author Image</label>
<input type="file" name="author_image" class="form-control mb-1 @error('author_image') is-invalid @enderror">
@error('author_image')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->author_image)
<img src="{{ asset('assets/images/about/'.$about->author_image) }}" width="100" class="mb-3 d-block">
@endif

<hr>

<!-- ================= SIGNATURE ================= -->
<h6>Signature</h6>

<input type="file" name="signature" class="form-control mb-1 @error('signature') is-invalid @enderror">
@error('signature')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->signature)
<img src="{{ asset('assets/images/about/'.$about->signature) }}" width="120" class="mb-3 d-block">
@endif

<hr>

<!-- ================= DIVIDER ================= -->
<!-- <h6>Divider Image</h6> -->

<input type="file" name="divider_image" class="form-control mb-1 @error('divider_image') is-invalid @enderror" hidden>
@error('divider_image')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror
@if($about->divider_image)
<img src="{{ asset('assets/images/about/'.$about->divider_image) }}" width="120" class="mb-3 d-block">
@endif

<hr>

<!-- ================= STATUS ================= -->
<label>Status</label>
<select name="status" class="form-control mb-3 @error('status') is-invalid @enderror">
    <option value="1" {{ old('status', $about->status) == '1' ? 'selected' : '' }}>Active</option>
    <option value="0" {{ old('status', $about->status) == '0' ? 'selected' : '' }}>Inactive</option>
</select>
@error('status')
    <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
@enderror

@if($user->hasPermission('about.update') || $user->is_admin)

<!-- ================= SUBMIT ================= -->
<button class="btn btn-success w-100">Update About Section</button>
@endif
</form>

</div>
</div>

</div>
</main>

@endsection