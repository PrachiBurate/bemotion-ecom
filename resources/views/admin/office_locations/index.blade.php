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

<!-- ERRORS -->
@if($errors->any())
<div class="alert alert-danger mt-2">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
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
@forelse($offices as $o)
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
            <form action="/admin/offices/delete/{{ $o->id }}" method="POST" onsubmit="return confirm('Delete this office?');">
                @csrf
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
            @endif

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">No office locations found.</td>
</tr>
@endforelse
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

        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control mb-2" value="{{ old('title') }}" placeholder="Title" required>
        @error('title')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">Address</label>
        <textarea name="address" class="form-control mb-2" placeholder="Address" required>{{ old('address') }}</textarea>
        @error('address')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">Phone 1</label>
        <input type="text" name="phone1" class="form-control mb-2" value="{{ old('phone1') }}" placeholder="Phone 1" required>
        @error('phone1')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">Phone 2 (optional)</label>
        <input type="text" name="phone2" class="form-control mb-2" value="{{ old('phone2') }}" placeholder="Phone 2">
        @error('phone2')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control mb-2" value="{{ old('email') }}" placeholder="Email" required>
        @error('email')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

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

        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ $o->title }}" class="form-control mb-2" required placeholder="Title">

        <label class="form-label">Address</label>
        <textarea name="address" class="form-control mb-2" required placeholder="Address">{{ $o->address }}</textarea>

        <label class="form-label">Phone 1</label>
        <input type="text" name="phone1" value="{{ $o->phone1 }}" class="form-control mb-2" required placeholder="Phone 1">

        <label class="form-label">Phone 2 (optional)</label>
        <input type="text" name="phone2" value="{{ $o->phone2 }}" class="form-control mb-2" placeholder="Phone 2">

        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ $o->email }}" class="form-control mb-2" required placeholder="Email">

        <label class="form-label">Status</label>
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