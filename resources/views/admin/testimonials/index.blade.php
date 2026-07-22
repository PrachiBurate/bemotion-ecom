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
<form action="/admin/testimonials/delete/{{ $t->id }}" method="POST" onsubmit="return confirm('Delete this testimonial?');">
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

<form method="POST" action="/admin/testimonials/store" enctype="multipart/form-data" novalidate>
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Add Testimonial</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-2">
    <label class="form-label">Customer Name</label>
    <input type="text" name="name" value="{{ old('name') }}"
        placeholder="Customer Name"
        class="form-control @error('name') is-invalid @enderror" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <label class="form-label">Message</label>
    <textarea name="message"
        class="form-control @error('message') is-invalid @enderror"
        placeholder="Message" required>{{ old('message') }}</textarea>
    @error('message')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <label class="form-label">Rating</label>
    <select name="rating" class="form-control @error('rating') is-invalid @enderror">
        @for ($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    @error('rating')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <label class="form-label">Image</label>
    <input type="file" name="image" accept="image/*"
        class="form-control @error('image') is-invalid @enderror" required>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <label class="form-label">Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

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

<form method="POST" action="/admin/testimonials/update/{{ $t->id }}" enctype="multipart/form-data" novalidate>
@csrf

{{-- lets us know, on validation failure, which edit modal to reopen and repopulate --}}
<input type="hidden" name="_testimonial_id" value="{{ $t->id }}">

<div class="modal-content">

<div class="modal-header">
<h5>Edit Testimonial</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

@php
    // Only apply old() values to the modal that was actually being edited when validation failed
    $isFailedEdit = old('_testimonial_id') == $t->id;
@endphp

<div class="mb-2">
    <label class="form-label">Customer Name</label>
    <input type="text" name="name"
        value="{{ $isFailedEdit ? old('name') : $t->name }}"
        class="form-control @if($isFailedEdit) @error('name') is-invalid @enderror @endif" required>
    @if($isFailedEdit)
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

<div class="mb-2">
    <label class="form-label">Message</label>
    <textarea name="message"
        class="form-control @if($isFailedEdit) @error('message') is-invalid @enderror @endif"
        required>{{ $isFailedEdit ? old('message') : $t->message }}</textarea>
    @if($isFailedEdit)
        @error('message')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

<div class="mb-2">
    <label class="form-label">Rating</label>
    <select name="rating" class="form-control @if($isFailedEdit) @error('rating') is-invalid @enderror @endif">
        @for ($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}" {{ ($isFailedEdit ? old('rating') : $t->rating) == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    @if($isFailedEdit)
        @error('rating')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

<div class="mb-2">
    <label class="form-label">Image (leave blank to keep current)</label>
    <input type="file" name="image" accept="image/*"
        class="form-control @if($isFailedEdit) @error('image') is-invalid @enderror @endif">
    @if($isFailedEdit)
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

@if($t->image)
<img src="{{ asset('assets/images/testimonials/'.$t->image) }}" width="80" class="mb-2 d-block">
@endif

<div class="mb-2">
    <label class="form-label">Status</label>
    <select name="status" class="form-control @if($isFailedEdit) @error('status') is-invalid @enderror @endif">
        <option value="1" {{ ($isFailedEdit ? old('status') : $t->status) == '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ ($isFailedEdit ? old('status') : $t->status) == '0' ? 'selected' : '' }}>Inactive</option>
    </select>
    @if($isFailedEdit)
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

</div>

<div class="modal-footer">
<button class="btn btn-success">Update</button>
</div>

</div>

</form>
</div>
</div>
@endforeach

@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    var testimonialId = @json(old('_testimonial_id'));
    var modalId = testimonialId ? 'edit' + testimonialId : 'addTestimonial';
    var modalEl = document.getElementById(modalId);
    if (modalEl) {
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
});
</script>
@endif

@endsection