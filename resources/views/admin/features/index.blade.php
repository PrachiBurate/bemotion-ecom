@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Features Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Features Management</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('features.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeature">
            + Add Feature
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
    <th>Icon</th>
    <th>Title</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($features as $f)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>
        <i class="fas {{ $f->icon }}" style="font-size:20px;"></i>
    </td>

    <td>{{ $f->title }}</td>

    <td>
        <span class="badge {{ $f->status ? 'bg-success' : 'bg-danger' }}">
            {{ $f->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            {{-- EDIT --}}
            @if($user->hasPermission('features.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#edit{{ $f->id }}">
                Edit
            </button>
            @endif

            {{-- DELETE --}}
            @if($user->hasPermission('features.delete') || $user->is_admin)
            <form action="/admin/features/delete/{{ $f->id }}" method="POST">
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
<div class="modal fade" id="addFeature">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/features/store">
@csrf

<div class="modal-content">
<div class="modal-header">
    <h5>Add Feature</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="icon" placeholder="Icon (ex: fa-truck)" class="form-control mb-2" required>

<input type="text" name="title" placeholder="Title" class="form-control mb-2" required>

<textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

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
@foreach($features as $f)
<div class="modal fade" id="edit{{ $f->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/features/update/{{ $f->id }}">
@csrf

<div class="modal-content">

<div class="modal-header">
    <h5>Edit Feature</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="icon" value="{{ $f->icon }}" class="form-control mb-2">

<input type="text" name="title" value="{{ $f->title }}" class="form-control mb-2">

<textarea name="description" class="form-control mb-2">{{ $f->description }}</textarea>

<select name="status" class="form-control">
    <option value="1" {{ $f->status ? 'selected' : '' }}>Active</option>
    <option value="0" {{ !$f->status ? 'selected' : '' }}>Inactive</option>
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