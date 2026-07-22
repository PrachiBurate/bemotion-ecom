@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Categories</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Categories</li>
        </ul>
    </div>

    <div>
        @if($user->hasPermission('categories.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
            + Add Category
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
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($categories as $c)
<tr>
<td>{{ $loop->iteration }}</td>

<td>
@if($c->image)
<img src="{{ asset('assets/images/categories/'.$c->image) }}" width="60">
@endif
</td>

<td>{{ $c->name }}</td>

<td>
<span class="badge {{ $c->status ? 'bg-success' : 'bg-danger' }}">
{{ $c->status ? 'Active' : 'Inactive' }}
</span>
</td>

<td class="d-flex gap-2">

@if($user->hasPermission('categories.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $c->id }}">
Edit
</button>
@endif

@if($user->hasPermission('categories.delete') || $user->is_admin)
<form action="/admin/categories/delete/{{ $c->id }}" method="POST">
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
<div class="modal fade" id="addCategory">
<div class="modal-dialog">

<form method="POST" action="/admin/categories/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">
<div class="modal-header">
<h5>Add Category</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="name" class="form-control mb-2" placeholder="Category Name" required>

<input type="file" name="image" class="form-control mb-2" required>

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
@foreach($categories as $c)
<div class="modal fade" id="edit{{ $c->id }}">
<div class="modal-dialog">

<form method="POST" action="/admin/categories/update/{{ $c->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Category</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="name" value="{{ $c->name }}" class="form-control mb-2" required>

<input type="file" name="image" class="form-control mb-2">

@if($c->image)
<img src="{{ asset('assets/images/categories/'.$c->image) }}" width="80" class="mb-2">
@endif

<select name="status" class="form-control">
<option value="1" {{ $c->status ? 'selected' : '' }}>Active</option>
<option value="0" {{ !$c->status ? 'selected' : '' }}>Inactive</option>
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