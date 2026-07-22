@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between align-items-center">
 
    <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Banner Settings</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Banner Settings</li>
                    </ul>
                </div>
    
   
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No.</th>
    <th>Banner</th>
    <th>Image</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($banners as $banner)
<tr>
    <td>{{ $banner->id }}</td>

    <td>{{ $banner->title }}</td>

    <td>
        @if($banner->image)
            <img src="{{ asset('assets/images/banner/'.$banner->image) }}" width="120" class="rounded">
        @else
            <span class="text-muted">No Image</span>
        @endif
    </td>

    <td>
        <span class="badge {{ $banner->status ? 'bg-success' : 'bg-danger' }}">
            {{ $banner->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        @if($user->hasPermission('banners.edit') || $user->is_admin)
        <button class="btn btn-warning btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#edit{{ $banner->id }}">
            Edit
        </button>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>
</div>

</div>
</main>

{{-- ================= EDIT MODALS ================= --}}
@foreach($banners as $banner)
<div class="modal fade" id="edit{{ $banner->id }}" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="POST" action="/banners/update/{{ $banner->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

    {{-- HEADER --}}
    <div class="modal-header">
        <h5 class="modal-title">Edit {{ $banner->title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    {{-- BODY --}}
   <div class="modal-body">

    {{-- TITLE (READ ONLY) --}}
    <div class="mb-3">
        <label>Title</label>
        <input type="text" value="{{ $banner->title }}" class="form-control" disabled>
    </div>

    {{-- IMAGE UPLOAD --}}
    <div class="mb-3">
        <label>Upload New Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    {{-- CURRENT IMAGE --}}
    <div class="mb-3">
        <label>Current Image</label><br>

        @if($banner->image)
            <img src="{{ asset('assets/images/banner/'.$banner->image) }}" width="180" class="rounded">
        @else
            <span class="text-muted">No Image Found</span>
        @endif
    </div>

</div>
    {{-- FOOTER --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success">Update</button>
    </div>

</div>

</form>
</div>
</div>
@endforeach

@endsection