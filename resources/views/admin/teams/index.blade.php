@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Team Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Team Management</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('teams.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeam">
            + Add Team
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
    <th>Position</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($teams as $t)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>
        @if($t->image)
        <img src="{{ asset('assets/images/team/'.$t->image) }}" width="60">
        @endif
    </td>

    <td>{{ $t->name }}</td>
    <td>{{ $t->position }}</td>

    <td>
        <span class="badge {{ $t->status ? 'bg-success' : 'bg-danger' }}">
            {{ $t->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            @if($user->hasPermission('teams.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $t->id }}">
                Edit
            </button>
            @endif

            @if($user->hasPermission('teams.delete') || $user->is_admin)
            <form action="/admin/teams/delete/{{ $t->id }}" method="POST">
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
<div class="modal fade" id="addTeam">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/teams/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Add Team</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="name" placeholder="Name" class="form-control mb-2" required>
        <input type="text" name="position" placeholder="Position" class="form-control mb-2">

        <input type="file" name="image" class="form-control mb-2">

        <input type="text" name="facebook" placeholder="Facebook Link" class="form-control mb-2">
        <input type="text" name="linkedin" placeholder="LinkedIn Link" class="form-control mb-2">
        <input type="text" name="instagram" placeholder="Instagram Link" class="form-control mb-2">
        <input type="text" name="twitter" placeholder="Twitter Link" class="form-control mb-2">

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
@foreach($teams as $t)
<div class="modal fade" id="edit{{ $t->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/teams/update/{{ $t->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

    <div class="modal-header">
        <h5>Edit Team</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="name" value="{{ $t->name }}" class="form-control mb-2">

        <input type="text" name="position" value="{{ $t->position }}" class="form-control mb-2">

        <input type="file" name="image" class="form-control mb-2">

        @if($t->image)
        <img src="{{ asset('assets/images/team/'.$t->image) }}" width="80">
        @endif

        <input type="text" name="facebook" value="{{ $t->facebook }}" class="form-control mb-2">
        <input type="text" name="linkedin" value="{{ $t->linkedin }}" class="form-control mb-2">
        <input type="text" name="instagram" value="{{ $t->instagram }}" class="form-control mb-2">
        <input type="text" name="twitter" value="{{ $t->twitter }}" class="form-control mb-2">

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