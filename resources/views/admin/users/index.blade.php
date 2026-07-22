@extends('admin.layouts.app')

@section('content')

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between">


<div class="page-header-left d-flex align-items-center">
    <div class="page-header-title">
        <h5 class="m-b-10">User Management</h5>
    </div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item">Users Management</li>
    </ul>
</div>

<div class="page-header-right-items">
 @if(auth()->user()->hasPermission('users.create'))
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
    + Add User
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

<div class="card mt-3">
<div class="card-body">

<table class="table table-hover">
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($users as $user)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role->name ?? '-' }}</td>


<td>
  <div class="d-flex gap-2">

    @if(auth()->user()->hasPermission('users.edit'))
    <button class="btn btn-sm btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#edit{{ $user->id }}">
        Edit
    </button>
    @endif

    @if(auth()->user()->hasPermission('users.delete'))
    <form action="/users/delete/{{ $user->id }}" method="POST">
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

{{-- ================= ADD USER MODAL ================= --}}

<div class="modal fade" id="addUser">
<div class="modal-dialog">
<form method="POST" action="/users/store">
@csrf

<div class="modal-content">


<div class="modal-header">
    <h5>Add User</h5>
</div>

<div class="modal-body">

    <input type="text" name="name" placeholder="Name" class="form-control mb-3" required>

    <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>

    <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>

    {{-- PASSWORD --}}
    <div class="input-group mb-3">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <span class="input-group-text toggle-password" data-target="password">
            <i class="feather-eye"></i>
        </span>
    </div>

    {{--   FIXED POSITION --}}
    <select name="role_id" class="form-control" required>
        <option value="">Select Role</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>

</div>

<div class="modal-footer">
    <button class="btn btn-primary">Create</button>
</div>


</div>

</form>
</div>
</div>

{{-- ================= EDIT USER MODALS ================= --}}
@foreach($users as $user)

<div class="modal fade" id="edit{{ $user->id }}">
<div class="modal-dialog">
<form method="POST" action="/users/update/{{ $user->id }}">
@csrf

<div class="modal-content">


<div class="modal-header">
    <h5>Edit User</h5>
</div>

<div class="modal-body">

    <input type="text" name="name" value="{{ $user->name }}" class="form-control mb-3" required>

    <input type="text" name="username" value="{{ $user->username }}" class="form-control mb-3" required>

    <input type="email" name="email" value="{{ $user->email }}" class="form-control mb-3" required>

    {{-- PASSWORD --}}
    <div class="input-group mb-3">
        <input type="password" name="password" id="edit_password{{ $user->id }}" class="form-control" placeholder="New Password (optional)">
        <span class="input-group-text toggle-password" data-target="edit_password{{ $user->id }}">
            <i class="feather-eye"></i>
        </span>
    </div>

    <select name="role_id" class="form-control" required>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
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

{{-- ================= JS ================= --}}

<script>
document.querySelectorAll(".toggle-password").forEach(btn => {
    btn.addEventListener("click", function () {
        let input = document.getElementById(this.dataset.target);
        let icon = this.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            icon.setAttribute("data-feather", "eye-off");
        } else {
            input.type = "password";
            icon.setAttribute("data-feather", "eye");
        }

        feather.replace();
    });
});
</script>

@endsection
