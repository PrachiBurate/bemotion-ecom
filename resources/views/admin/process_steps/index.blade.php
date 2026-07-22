@extends('admin.layouts.app')

@section('content')

@php
    $user = auth()->user();

    // Common Font Awesome (solid) icons — extend this list as needed.
    // Must match the pattern fa-xxxx used by the validation regex in the controller.
    $availableIcons = [
        'fa-search', 'fa-credit-card', 'fa-box', 'fa-truck', 'fa-shopping-cart', 'fa-user',
        'fa-check', 'fa-check-circle', 'fa-clock', 'fa-calendar', 'fa-calendar-check',
        'fa-envelope', 'fa-phone', 'fa-map-marker-alt', 'fa-home', 'fa-building',
        'fa-cog', 'fa-cogs', 'fa-wrench', 'fa-tools', 'fa-clipboard-list', 'fa-clipboard-check',
        'fa-file', 'fa-file-alt', 'fa-file-invoice', 'fa-file-signature', 'fa-signature',
        'fa-shield-alt', 'fa-lock', 'fa-unlock', 'fa-key', 'fa-star', 'fa-heart',
        'fa-thumbs-up', 'fa-comments', 'fa-comment-dots', 'fa-headset', 'fa-handshake',
        'fa-money-bill-wave', 'fa-wallet', 'fa-receipt', 'fa-chart-line', 'fa-chart-bar',
        'fa-users', 'fa-user-check', 'fa-user-plus', 'fa-gift', 'fa-boxes', 'fa-warehouse',
        'fa-shipping-fast', 'fa-plane', 'fa-globe', 'fa-link', 'fa-download', 'fa-upload',
        'fa-search-plus', 'fa-clipboard', 'fa-pen', 'fa-edit', 'fa-flag-checkered',
        'fa-rocket', 'fa-bell', 'fa-eye', 'fa-thumbtack',
    ];
@endphp

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
            <form action="/admin/process-steps/delete/{{ $s->id }}" method="POST" onsubmit="return confirm('Delete this step?');">
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

<form method="POST" action="/admin/process-steps/store" novalidate>
@csrf

<div class="modal-content">
<div class="modal-header">
    <h5>Add Process Step</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-2">
    <label class="form-label">Title</label>
    <input type="text" name="title" value="{{ old('title') }}"
        class="form-control @error('title') is-invalid @enderror"
        placeholder="Title" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <label class="form-label">Description</label>
    <textarea name="description"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Description">{{ old('description') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ICON PICKER --}}
<div class="mb-2">
    <label class="form-label">Icon</label>

    <input type="text" class="form-control mb-2 icon-search" placeholder="Search icons...">

    <input type="hidden" name="icon" value="{{ old('icon', 'fa-search') }}" class="icon-input @error('icon') is-invalid @enderror">

    <div class="icon-box mb-1">
        @foreach($availableIcons as $icon)
        <i class="fas {{ $icon }} icon-item {{ old('icon', 'fa-search') == $icon ? 'active' : '' }}"
           data-icon="{{ $icon }}" title="{{ $icon }}"></i>
        @endforeach
    </div>

    @error('icon')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <label class="form-label">Step Number</label>
    <input type="number" name="step_number" value="{{ old('step_number') }}"
        class="form-control @error('step_number') is-invalid @enderror"
        placeholder="Step Number">
    @error('step_number')
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
@foreach($steps as $s)
<div class="modal fade" id="edit{{ $s->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/process-steps/update/{{ $s->id }}" novalidate>
@csrf
<input type="hidden" name="_step_id" value="{{ $s->id }}">

@php $isFailedEdit = old('_step_id') == $s->id; @endphp

<div class="modal-content">

<div class="modal-header">
    <h5>Edit Process Step</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-2">
    <label class="form-label">Title</label>
    <input type="text" name="title"
        value="{{ $isFailedEdit ? old('title') : $s->title }}"
        class="form-control @if($isFailedEdit) @error('title') is-invalid @enderror @endif">
    @if($isFailedEdit)
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

<div class="mb-2">
    <label class="form-label">Description</label>
    <textarea name="description"
        class="form-control @if($isFailedEdit) @error('description') is-invalid @enderror @endif">{{ $isFailedEdit ? old('description') : $s->description }}</textarea>
    @if($isFailedEdit)
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

{{-- ICON PICKER --}}
@php $currentIcon = $isFailedEdit ? old('icon') : $s->icon; @endphp

<div class="mb-2">
    <label class="form-label">Icon</label>

    <input type="text" class="form-control mb-2 icon-search" placeholder="Search icons...">

    <input type="hidden" name="icon" value="{{ $currentIcon }}"
        class="icon-input @if($isFailedEdit) @error('icon') is-invalid @enderror @endif">

    <div class="icon-box mb-1">
        @foreach($availableIcons as $icon)
        <i class="fas {{ $icon }} icon-item {{ $currentIcon == $icon ? 'active' : '' }}"
           data-icon="{{ $icon }}" title="{{ $icon }}"></i>
        @endforeach
    </div>

    @if($isFailedEdit)
        @error('icon')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    @endif
</div>

<div class="mb-2">
    <label class="form-label">Step Number</label>
    <input type="number" name="step_number"
        value="{{ $isFailedEdit ? old('step_number') : $s->step_number }}"
        class="form-control @if($isFailedEdit) @error('step_number') is-invalid @enderror @endif">
    @if($isFailedEdit)
        @error('step_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

<div class="mb-2">
    <label class="form-label">Status</label>
    <select name="status" class="form-control @if($isFailedEdit) @error('status') is-invalid @enderror @endif">
        <option value="1" {{ ($isFailedEdit ? old('status') : $s->status) == '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ ($isFailedEdit ? old('status') : $s->status) == '0' ? 'selected' : '' }}>Inactive</option>
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
    var stepId = @json(old('_step_id'));
    var modalId = stepId ? 'edit' + stepId : 'addStep';
    var modalEl = document.getElementById(modalId);
    if (modalEl) {
        new bootstrap.Modal(modalEl).show();
    }
});
</script>
@endif

@endsection

{{-- ================= CSS ================= --}}
<style>
.icon-box {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    max-height: 220px;
    overflow-y: auto;
    padding: 8px;
    border: 1px solid #eee;
    border-radius: 6px;
}

.icon-item {
    font-size: 18px;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
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
    border-color: #198754;
}

.icon-item.d-none-search {
    display: none;
}
</style>

{{-- ================= JS ================= --}}
<script>
// Icon selection
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("icon-item")) {
        var parent = e.target.closest(".modal-body");

        parent.querySelectorAll(".icon-item").forEach(function(el) {
            el.classList.remove("active");
        });

        e.target.classList.add("active");

        var icon = e.target.getAttribute("data-icon");
        parent.querySelector(".icon-input").value = icon;
    }
});

// Icon search filter (scoped per modal so Add and each Edit modal filter independently)
document.addEventListener("input", function(e) {
    if (e.target.classList.contains("icon-search")) {
        var term = e.target.value.trim().toLowerCase();
        var modalBody = e.target.closest(".modal-body");

        modalBody.querySelectorAll(".icon-item").forEach(function(el) {
            var name = el.getAttribute("data-icon").toLowerCase();
            el.style.display = name.includes(term) ? "" : "none";
        });
    }
});
</script>