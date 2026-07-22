@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Subcategories</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Subcategories</li>
        </ul>
    </div>

    @if($user->hasPermission('subcategories.create') || $user->is_admin)
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSub">
        + Add Subcategory
    </button>
    @endif
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
<th>Category</th>
<th>Name</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($subcategories as $s)
<tr>
<td>{{ $loop->iteration }}</td>

<td>
@if($s->image)
<img src="{{ asset('assets/images/subcategories/'.$s->image) }}" width="60">
@endif
</td>

<td>{{ $s->category->name }}</td>
<td>{{ $s->name }}</td>

<td>
<span class="badge {{ $s->status ? 'bg-success' : 'bg-danger' }}">
{{ $s->status ? 'Active' : 'Inactive' }}
</span>
</td>

<td class="d-flex gap-2">

@if($user->hasPermission('subcategories.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $s->id }}">
Edit
</button>
@endif

@if($user->hasPermission('subcategories.delete') || $user->is_admin)
<form action="/admin/subcategories/delete/{{ $s->id }}" method="POST">
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
<div class="modal fade" id="addSub">
<div class="modal-dialog">

<form method="POST" action="/admin/subcategories/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Add Subcategory</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<select name="category_id" class="form-control mb-2" required>
<option value="">Select Category</option>
@foreach($categories as $c)
<option value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
</select>

<input type="text" name="name" class="form-control mb-2" placeholder="Subcategory Name" required>

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
@foreach($subcategories as $s)
<div class="modal fade" id="edit{{ $s->id }}">
<div class="modal-dialog">

<form method="POST" action="/admin/subcategories/update/{{ $s->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Subcategory</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<select name="category_id" class="form-control mb-2" required>
@foreach($categories as $c)
<option value="{{ $c->id }}" {{ $s->category_id == $c->id ? 'selected' : '' }}>
{{ $c->name }}
</option>
@endforeach
</select>

<input type="text" name="name" value="{{ $s->name }}" class="form-control mb-2" required>

<input type="file" name="image" class="form-control mb-2">

@if($s->image)
<img src="{{ asset('assets/images/subcategories/'.$s->image) }}" width="80" class="mb-2">
@endif

<select name="status" class="form-control">
<option value="1" {{ $s->status ? 'selected' : '' }}>Active</option>
<option value="0" {{ !$s->status ? 'selected' : '' }}>Inactive</option>
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