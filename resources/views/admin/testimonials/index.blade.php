@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Testimonials Management</h5>
        </div>

        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Testimonials</li>
        </ul>
    </div>

    <div>
        @if($user->hasPermission('testimonials.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestimonial">
            + Add Testimonial
        </button>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<!-- TABLE -->
<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No.</th>
    <th>Image</th>
    <th>Name</th>
    <th>Message</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($testimonials as $t)
<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($t->image)
<img src="{{ asset('assets/images/testimonials/'.$t->image) }}" width="60">
@endif
</td>

<td>{{ $t->name }}</td>

<td>{{ Str::limit($t->message, 50) }}</td>

<td>
<span class="badge {{ $t->status ? 'bg-success' : 'bg-danger' }}">
{{ $t->status ? 'Active' : 'Inactive' }}
</span>
</td>

<td class="d-flex gap-2">

{{-- EDIT --}}
@if($user->hasPermission('testimonials.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#edit{{ $t->id }}">
    Edit
</button>
@endif

{{-- DELETE --}}
@if($user->hasPermission('testimonials.delete') || $user->is_admin)
<form action="/admin/testimonials/delete/{{ $t->id }}" method="POST">
@csrf
<button class="btn btn-danger btn-sm">Delete</button>
</form>
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

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addTestimonial">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/testimonials/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Add Testimonial</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="name" placeholder="Customer Name" class="form-control mb-2" required>

<textarea name="message" class="form-control mb-2" placeholder="Message" required></textarea>

<input type="file" name="image" class="form-control mb-2">

<select name="status" class="form-control">
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Create</button>
</div>

</div>

</form>
</div>
</div>

<!-- ================= EDIT MODALS ================= -->
@foreach($testimonials as $t)
<div class="modal fade" id="edit{{ $t->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/testimonials/update/{{ $t->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Testimonial</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="name" value="{{ $t->name }}" class="form-control mb-2" required>

<textarea name="message" class="form-control mb-2" required>{{ $t->message }}</textarea>

<input type="file" name="image" class="form-control mb-2">

@if($t->image)
<img src="{{ asset('assets/images/testimonials/'.$t->image) }}" width="80" class="mb-2">
@endif

<select name="status" class="form-control">
<option value="1" {{ $t->status ? 'selected' : '' }}>Active</option>
<option value="0" {{ !$t->status ? 'selected' : '' }}>Inactive</option>
</select>

</div>

<div class="modal-footer">
<button class="btn btn-success">Update</button>
</div>

</div>

</form>
</div>
</div>
@endforeach

@endsection