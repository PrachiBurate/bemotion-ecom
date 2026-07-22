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
            <form action="/admin/teams/delete/{{ $t->id }}" method="POST" onsubmit="return confirm('Delete this team member?');">
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

<form method="POST" action="/admin/teams/store" enctype="multipart/form-data" novalidate>
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Add Team</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Name" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Position</label>
            <input type="text" name="position" value="{{ old('position') }}"
                placeholder="Position" class="form-control @error('position') is-invalid @enderror">
            @error('position')
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
            <label class="form-label">Facebook Link</label>
            <input type="text" name="facebook" value="{{ old('facebook') }}"
                placeholder="Facebook Link" class="form-control @error('facebook') is-invalid @enderror">
            @error('facebook')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">LinkedIn Link</label>
            <input type="text" name="linkedin" value="{{ old('linkedin') }}"
                placeholder="LinkedIn Link" class="form-control @error('linkedin') is-invalid @enderror">
            @error('linkedin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Instagram Link</label>
            <input type="text" name="instagram" value="{{ old('instagram') }}"
                placeholder="Instagram Link" class="form-control @error('instagram') is-invalid @enderror">
            @error('instagram')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Twitter Link</label>
            <input type="text" name="twitter" value="{{ old('twitter') }}"
                placeholder="Twitter Link" class="form-control @error('twitter') is-invalid @enderror">
            @error('twitter')
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
@foreach($teams as $t)
<div class="modal fade" id="edit{{ $t->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/teams/update/{{ $t->id }}" enctype="multipart/form-data" novalidate>
@csrf
<input type="hidden" name="_team_id" value="{{ $t->id }}">

@php $isFailedEdit = old('_team_id') == $t->id; @endphp

<div class="modal-content">

    <div class="modal-header">
        <h5>Edit Team</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" name="name"
                value="{{ $isFailedEdit ? old('name') : $t->name }}"
                class="form-control @if($isFailedEdit) @error('name') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">Position</label>
            <input type="text" name="position"
                value="{{ $isFailedEdit ? old('position') : $t->position }}"
                class="form-control @if($isFailedEdit) @error('position') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('position')
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
        <img src="{{ asset('assets/images/team/'.$t->image) }}" width="80" class="mb-2 d-block">
        @endif

        <div class="mb-2">
            <label class="form-label">Facebook Link</label>
            <input type="text" name="facebook"
                value="{{ $isFailedEdit ? old('facebook') : $t->facebook }}"
                class="form-control @if($isFailedEdit) @error('facebook') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('facebook')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">LinkedIn Link</label>
            <input type="text" name="linkedin"
                value="{{ $isFailedEdit ? old('linkedin') : $t->linkedin }}"
                class="form-control @if($isFailedEdit) @error('linkedin') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('linkedin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">Instagram Link</label>
            <input type="text" name="instagram"
                value="{{ $isFailedEdit ? old('instagram') : $t->instagram }}"
                class="form-control @if($isFailedEdit) @error('instagram') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('instagram')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">Twitter Link</label>
            <input type="text" name="twitter"
                value="{{ $isFailedEdit ? old('twitter') : $t->twitter }}"
                class="form-control @if($isFailedEdit) @error('twitter') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('twitter')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

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
    var teamId = @json(old('_team_id'));
    var modalId = teamId ? 'edit' + teamId : 'addTeam';
    var modalEl = document.getElementById(modalId);
    if (modalEl) {
        new bootstrap.Modal(modalEl).show();
    }
});
</script>
@endif

@endsection