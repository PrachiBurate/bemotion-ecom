@extends('admin.layouts.app')

@section('content')

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Roles Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Roles Management</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if(auth()->user()->hasPermission('roles.create'))
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRole">
            + Add Role
        </button>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-2">{{ session('error') }}</div>
@endif

<!-- ROLES TABLE -->
<div class="card mt-3">
<div class="card-body">
<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th style="width:60px;">Sr. No.</th>
            <th>Role</th>
            <!-- <th>Permissions</th> -->
            <th style="width:160px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $role)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td><span class="fw-semibold">{{ $role->name }}</span></td>
            <!-- <td>
                @forelse($role->permissions as $permission)
                    <span class="badge bg-primary me-1 mb-1">{{ $permission->name }}</span>
                @empty
                    <span class="text-muted">No permissions assigned</span>
                @endforelse
            </td> -->
            <td>
                <div class="d-flex gap-2">
                    @if(auth()->user()->hasPermission('roles.edit'))
                    <button class="btn btn-sm btn-warning" type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#edit{{ $role->id }}">
                        Edit
                    </button>
                    @endif

                    @if(auth()->user()->hasPermission('roles.delete'))
                    <form action="{{ url('/roles/delete/'.$role->id) }}" method="POST"
                          onsubmit="return confirm('Delete the role \'{{ $role->name }}\'? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted py-4">No roles found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>

</div>
</main>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addRole" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="POST" action="{{ url('/roles/store') }}">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <label class="form-label">Role Name</label>
        <input type="text"
               name="name"
               class="form-control @error('name', 'store') is-invalid @enderror"
               placeholder="Role Name"
               value="{{ old('name') }}"
               required>

        @error('name', 'store')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h6 class="mb-0">Permissions</h6>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="selectAllAdd">
                <label class="form-check-label fw-bold" for="selectAllAdd">Select All</label>
            </div>
        </div>

        <div class="row">
            @foreach($permissions as $perm)
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="border rounded p-2">
                    <div class="form-check">
                        <input class="form-check-input permission-add"
                               type="checkbox"
                               name="permissions[]"
                               value="{{ $perm->id }}"
                               id="permAdd{{ $perm->id }}"
                               {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permAdd{{ $perm->id }}">
                            {{ ucwords(str_replace('.', ' → ', $perm->name)) }}
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @error('permissions', 'store')
        <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary">Save</button>
    </div>
</div>

</form>
</div>
</div>

<!-- ================= EDIT MODALS ================= -->
@foreach($roles as $role)
<div class="modal fade" id="edit{{ $role->id }}" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="POST" action="{{ url('/roles/update/'.$role->id) }}">
@csrf
@method('PUT')

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <label class="form-label">Role Name</label>
        <input type="text"
               name="name"
               value="{{ session('open_modal') === 'edit'.$role->id ? old('name') : $role->name }}"
               class="form-control @error('name', 'update_'.$role->id) is-invalid @enderror"
               required>

        @error('name', 'update_'.$role->id)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h6 class="mb-0">Permissions</h6>
            <div class="form-check">
                <input type="checkbox" class="form-check-input select-all-edit" id="selectAllEdit{{ $role->id }}">
                <label class="form-check-label fw-bold" for="selectAllEdit{{ $role->id }}">Select All</label>
            </div>
        </div>

        <div class="row">
            @foreach($permissions as $perm)
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="border rounded p-2">
                    <div class="form-check">
                        <input class="form-check-input permission-edit-{{ $role->id }}"
                               type="checkbox"
                               name="permissions[]"
                               value="{{ $perm->id }}"
                               id="permEdit{{ $role->id }}_{{ $perm->id }}"
                               {{ $role->permissions->contains($perm->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permEdit{{ $role->id }}_{{ $perm->id }}">
                            {{ ucwords(str_replace('.', ' → ', $perm->name)) }}
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @error('permissions', 'update_'.$role->id)
        <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success">Update</button>
    </div>
</div>

</form>
</div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===========================
    // ADD ROLE - SELECT ALL
    // ===========================
    const addSelect = document.getElementById('selectAllAdd');

    if (addSelect) {
        const addPermissions = document.querySelectorAll('.permission-add');

        const syncAddSelectAll = function () {
            addSelect.checked = addPermissions.length > 0 &&
                [...addPermissions].every(cb => cb.checked);
        };

        addSelect.addEventListener('change', function () {
            addPermissions.forEach(cb => cb.checked = addSelect.checked);
        });

        addPermissions.forEach(cb => cb.addEventListener('change', syncAddSelectAll));

        syncAddSelectAll();
    }

    // ===========================
    // EDIT ROLE - SELECT ALL (per role)
    // ===========================
    document.querySelectorAll('.select-all-edit').forEach(function (select) {

        const roleId = select.id.replace('selectAllEdit', '');
        const permissions = document.querySelectorAll('.permission-edit-' + roleId);

        const syncEditSelectAll = function () {
            select.checked = permissions.length > 0 &&
                [...permissions].every(cb => cb.checked);
        };

        select.addEventListener('change', function () {
            permissions.forEach(cb => cb.checked = select.checked);
        });

        permissions.forEach(cb => cb.addEventListener('change', syncEditSelectAll));

        syncEditSelectAll();
    });

    // ===========================
    // RE-OPEN MODAL AFTER VALIDATION ERROR
    // ===========================
    @if(session('open_modal'))
        const modalEl = document.getElementById('{{ session('open_modal') }}');
        if (modalEl && window.bootstrap) {
            new bootstrap.Modal(modalEl).show();
        }
    @endif

});
</script>

@endsection