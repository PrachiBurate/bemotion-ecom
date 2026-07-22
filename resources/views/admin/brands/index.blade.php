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
@foreach($brands as $b)
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
            <form action="/admin/brands/delete/{{ $b->id }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
            @endif

        </div>
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

        <input type="text" name="name" placeholder="Brand Name" class="form-control mb-2" required>

        <input type="file" name="logo" class="form-control mb-2">

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

        <input type="text" name="name" value="{{ $b->name }}" class="form-control mb-2" required>

        <input type="file" name="logo" class="form-control mb-2">

        @if($b->logo)
        <img src="{{ asset('assets/images/brands/'.$b->logo) }}" width="80" class="mb-2">
        @endif

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