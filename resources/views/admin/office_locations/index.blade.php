@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- ================= HEADER ================= -->
<div class="page-header d-flex justify-content-between align-items-center">
    
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Office Locations</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Office Locations</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('office_locations.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOffice">
            + Add Office
        </button>
        @endif
    </div>

</div>

<!-- SUCCESS -->
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<!-- ================= TABLE ================= -->
<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No.</th>
    <th>Title</th>
    <th>Address</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($offices as $o)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $o->title }}</td>
    <td>{{ $o->address }}</td>

    <td>
        <span class="badge {{ $o->status ? 'bg-success' : 'bg-danger' }}">
            {{ $o->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            {{-- EDIT --}}
            @if($user->hasPermission('office_locations.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#edit{{ $o->id }}">
                Edit
            </button>
            @endif

            {{-- DELETE --}}
            @if($user->hasPermission('office_locations.delete') || $user->is_admin)
            <form action="/admin/offices/delete/{{ $o->id }}" method="POST">
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
<div class="modal fade" id="addOffice">
<div class="modal-dialog">

<form method="POST" action="/admin/offices/store">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Add Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>

        <textarea name="address" class="form-control mb-2" placeholder="Address" required></textarea>

        <input type="text" name="phone1" class="form-control mb-2" placeholder="Phone 1" required>

        <input type="text" name="phone2" class="form-control mb-2" placeholder="Phone 2">

        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

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
@foreach($offices as $o)
<div class="modal fade" id="edit{{ $o->id }}">
<div class="modal-dialog">

<form method="POST" action="/admin/offices/update/{{ $o->id }}">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Edit Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="title" value="{{ $o->title }}" class="form-control mb-2" required placeholder="Title">

        <textarea name="address" class="form-control mb-2" required placeholder="Address">{{ $o->address }}</textarea>

        <input type="text" name="phone1" value="{{ $o->phone1 }}" class="form-control mb-2" required placeholder="Phone 1">

        <input type="text" name="phone2" value="{{ $o->phone2 }}" class="form-control mb-2" placeholder="Phone 2">

        <input type="email" name="email" value="{{ $o->email }}" class="form-control mb-2" required placeholder="Email">

        <select name="status" class="form-control">
            <option value="1" {{ $o->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$o->status ? 'selected' : '' }}>Inactive</option>
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