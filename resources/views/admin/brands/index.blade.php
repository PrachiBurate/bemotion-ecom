@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Brands Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Brands Management</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('brands.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrand">
            + Add Brand
        </button>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger mt-2">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- TABLE -->
<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No.</th>
    <th>Logo</th>
    <th>Name</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@forelse($brands as $b)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>
        @if($b->logo)
        <img src="{{ asset('assets/images/brands/'.$b->logo) }}" width="60">
        @endif
    </td>

    <td>{{ $b->name }}</td>

    <td>
        <span class="badge {{ $b->status ? 'bg-success' : 'bg-danger' }}">
            {{ $b->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            {{-- EDIT --}}
            @if($user->hasPermission('brands.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#edit{{ $b->id }}">
                Edit
            </button>
            @endif

            {{-- DELETE --}}
            @if($user->hasPermission('brands.delete') || $user->is_admin)
            <form action="/admin/brands/delete/{{ $b->id }}" method="POST" onsubmit="return confirm('Delete this brand?');">
                @csrf
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
            @endif

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">No brands found.</td>
</tr>
@endforelse
</tbody>
</table>

</div>
</div>

</div>
</main>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addBrand">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/brands/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Add Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <label class="form-label">Name</label>
        <input type="text" name="name" placeholder="Brand Name" class="form-control mb-2" value="{{ old('name') }}" required>
        @error('name')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">Logo (optional)</label>
        <input type="file" name="logo" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml">
        <small class="text-muted d-block mb-2">JPG, PNG, WEBP or SVG. Max 2MB.</small>
        @error('logo')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
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
@foreach($brands as $b)
<div class="modal fade" id="edit{{ $b->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/brands/update/{{ $b->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

    <div class="modal-header">
        <h5>Edit Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ $b->name }}" class="form-control mb-2" required>

        <label class="form-label">Logo (optional)</label>
        <input type="file" name="logo" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml">
        <small class="text-muted d-block mb-2">Leave empty to keep the current logo. Max 2MB.</small>

        @if($b->logo)
        <img src="{{ asset('assets/images/brands/'.$b->logo) }}" width="80" class="mb-2 d-block">
        @endif

        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ $b->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$b->status ? 'selected' : '' }}>Inactive</option>
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