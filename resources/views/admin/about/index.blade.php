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
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<div class="card mt-3">
<div class="card-body">

<form method="POST" action="/admin/about/update/{{ $about->id }}" enctype="multipart/form-data">
@csrf

<!-- ================= TITLE ================= -->
<label>Title</label>
<input type="text" name="title" value="{{ $about->title }}" class="form-control mb-3">

<!-- ================= SUBTITLE ================= -->
<label>Subtitle</label>
<input type="text" name="subtitle" value="{{ $about->subtitle }}" class="form-control mb-3">

<!-- ================= DESCRIPTION ================= -->
<label>Description</label>
<textarea name="description" class="form-control mb-3">{{ $about->description }}</textarea>

<!-- ================= EXPERIENCE ================= -->
<label>Experience Years</label>
<input type="number" name="experience_year" value="{{ $about->experience_year }}" class="form-control mb-3">

<hr>

<!-- ================= MAIN IMAGES ================= -->
<h6>Main Images</h6>

<label>Image 1</label>
<input type="file" name="image1" class="form-control mb-2">
@if($about->image1)
<img src="{{ asset('assets/images/about/'.$about->image1) }}" width="120" class="mb-3">
@endif

<label>Image 2</label>
<input type="file" name="image2" class="form-control mb-2">
@if($about->image2)
<img src="{{ asset('assets/images/about/'.$about->image2) }}" width="120" class="mb-3">
@endif

<hr>

<!-- ================= THUMB IMAGES ================= -->
<h6>Thumbnail Images</h6>

<label>Thumb 1</label>
<input type="file" name="thumb1" class="form-control mb-2">
@if($about->thumb1)
<img src="{{ asset('assets/images/about/'.$about->thumb1) }}" width="100" class="mb-3">
@endif

<label>Thumb 2</label>
<input type="file" name="thumb2" class="form-control mb-2">
@if($about->thumb2)
<img src="{{ asset('assets/images/about/'.$about->thumb2) }}" width="100" class="mb-3">
@endif

<hr>

<!-- ================= LIST ================= -->
<h6>Features List</h6>

<input type="text" name="list1" value="{{ $about->list1 }}" class="form-control mb-2" placeholder="List 1">
<input type="text" name="list2" value="{{ $about->list2 }}" class="form-control mb-2" placeholder="List 2">
<input type="text" name="list3" value="{{ $about->list3 }}" class="form-control mb-3" placeholder="List 3">

<hr>

<!-- ================= AUTHOR ================= -->
<h6>Author Details</h6>

<label>Name</label>
<input type="text" name="author_name" value="{{ $about->author_name }}" class="form-control mb-2">

<label>Position</label>
<input type="text" name="author_position" value="{{ $about->author_position }}" class="form-control mb-2">

<label>Author Image</label>
<input type="file" name="author_image" class="form-control mb-2">
@if($about->author_image)
<img src="{{ asset('assets/images/about/'.$about->author_image) }}" width="100" class="mb-3">
@endif

<hr>

<!-- ================= SIGNATURE ================= -->
<h6>Signature</h6>

<input type="file" name="signature" class="form-control mb-2">
@if($about->signature)
<img src="{{ asset('assets/images/about/'.$about->signature) }}" width="120" class="mb-3">
@endif

<hr>

<!-- ================= DIVIDER ================= -->
<!-- <h6>Divider Image</h6> -->

<input type="file" name="divider_image" class="form-control mb-2" hidden>
@if($about->divider_image)
<img src="{{ asset('assets/images/about/'.$about->divider_image) }}" width="120" class="mb-3">
@endif

<hr>

<!-- ================= STATUS ================= -->
<label>Status</label>
<select name="status" class="form-control mb-3">
    <option value="1" {{ $about->status ? 'selected' : '' }}>Active</option>
    <option value="0" {{ !$about->status ? 'selected' : '' }}>Inactive</option>
</select>
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