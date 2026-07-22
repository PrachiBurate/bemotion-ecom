@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left">
        <h5>Process Steps Management</h5>
    </div>

    @if($user->hasPermission('process_steps.create') || $user->is_admin)
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStep">
        + Add Step
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
    <th>Icon</th>
    <th>Title</th>
    <th>Step</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($steps as $s)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>
        <i class="fas {{ $s->icon }}"></i>
    </td>

    <td>{{ $s->title }}</td>

    <td>{{ $s->step_number }}</td>

    <td>
        <span class="badge {{ $s->status ? 'bg-success' : 'bg-danger' }}">
            {{ $s->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            @if($user->hasPermission('process_steps.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#edit{{ $s->id }}">
                Edit
            </button>
            @endif

            @if($user->hasPermission('process_steps.delete') || $user->is_admin)
            <form action="/admin/process-steps/delete/{{ $s->id }}" method="POST">
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
<div class="modal fade" id="addStep">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/process-steps/store">
@csrf

<div class="modal-content">
<div class="modal-header">
    <h5>Add Process Step</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="title" class="form-control mb-2" placeholder="Title" required>

<textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

{{-- ICON PICKER --}}
<input type="hidden" name="icon" value="fa-search" class="icon-input">

<div class="icon-box mb-3">
    <i class="fas fa-search icon-item active"></i>
    <i class="fas fa-credit-card icon-item"></i>
    <i class="fas fa-box icon-item"></i>
    <i class="fas fa-truck icon-item"></i>
    <i class="fas fa-shopping-cart icon-item"></i>
    <i class="fas fa-user icon-item"></i>
</div>

<input type="number" name="step_number" class="form-control mb-2" placeholder="Step Number">

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
@foreach($steps as $s)
<div class="modal fade" id="edit{{ $s->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/process-steps/update/{{ $s->id }}">
@csrf

<div class="modal-content">

<div class="modal-header">
    <h5>Edit Process Step</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="title" value="{{ $s->title }}" class="form-control mb-2">

<textarea name="description" class="form-control mb-2">{{ $s->description }}</textarea>

{{-- ICON PICKER --}}
<input type="hidden" name="icon" value="{{ $s->icon }}" class="icon-input">

@php
$icons = ['fa-search','fa-credit-card','fa-box','fa-truck','fa-shopping-cart','fa-user'];
@endphp

<div class="icon-box mb-3">
@foreach($icons as $icon)
    <i class="fas {{ $icon }} icon-item {{ $s->icon == $icon ? 'active' : '' }}"></i>
@endforeach
</div>

<input type="number" name="step_number" value="{{ $s->step_number }}" class="form-control mb-2">

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

{{-- ================= CSS ================= --}}
<style>
.icon-box {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.icon-item {
    font-size: 20px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
}

.icon-item:hover {
    background: #0d6efd;
    color: #fff;
}

.icon-item.active {
    background: #198754;
    color: #fff;
}
</style>

{{-- ================= JS ================= --}}
<script>
document.addEventListener("click", function(e) {

    if (e.target.classList.contains("icon-item")) {

        let parent = e.target.closest(".modal-body");

        // remove active from all icons
        parent.querySelectorAll(".icon-item").forEach(function(el) {
            el.classList.remove("active");
        });

        // add active to clicked
        e.target.classList.add("active");

        // get icon class (fa-xxxx)
        let classes = e.target.className.split(" ");
        let icon = classes.find(c => c.startsWith("fa-") && c !== "fa");

        // set hidden input value
        parent.querySelector(".icon-input").value = icon;
    }

});
</script>