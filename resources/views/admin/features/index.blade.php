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

@if($errors->any())
<div class="alert alert-danger mt-2">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
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
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@forelse($features as $f)
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
            <form action="/admin/features/delete/{{ $f->id }}" method="POST" onsubmit="return confirm('Delete this feature?');">
                @csrf
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
            @endif

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">No features found.</td>
</tr>
@endforelse
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

    <label class="form-label">Icon</label>
    <div class="d-flex align-items-center gap-2 mb-2">
        <div class="icon-preview-box">
            <i id="icon-preview-add" class="fas fa-question"></i>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm icon-picker-btn" data-target="add">
            Choose Icon
        </button>
        <input type="hidden" name="icon" id="icon-add" value="{{ old('icon') }}" required>
    </div>
    @error('icon')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

    <label class="form-label">Title</label>
    <input type="text" name="title" placeholder="Title" class="form-control mb-2" value="{{ old('title') }}" required>
    @error('title')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

    <label class="form-label">Description</label>
    <textarea name="description" class="form-control mb-2" placeholder="Description">{{ old('description') }}</textarea>
    @error('description')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

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

    <label class="form-label">Icon</label>
    <div class="d-flex align-items-center gap-2 mb-2">
        <div class="icon-preview-box">
            <i id="icon-preview-edit{{ $f->id }}" class="fas {{ $f->icon }}"></i>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm icon-picker-btn" data-target="edit{{ $f->id }}">
            Choose Icon
        </button>
        <input type="hidden" name="icon" id="icon-edit{{ $f->id }}" value="{{ $f->icon }}" required>
    </div>

    <label class="form-label">Title</label>
    <input type="text" name="title" value="{{ $f->title }}" class="form-control mb-2" required>

    <label class="form-label">Description</label>
    <textarea name="description" class="form-control mb-2">{{ $f->description }}</textarea>

    <label class="form-label">Status</label>
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

<!-- ================= SHARED ICON PICKER MODAL ================= -->
<div class="modal fade" id="iconPickerModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Select an Icon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="iconSearchInput" class="form-control mb-3" placeholder="Search icons... (e.g. truck, user, cart)">
        <div id="iconGrid" class="icon-grid"></div>
      </div>
    </div>
  </div>
</div>

<style>
.icon-preview-box {
    width: 42px;
    height: 42px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    background: #f8f9fa;
}
.icon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
    gap: 8px;
    max-height: 400px;
}
.icon-grid-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px 4px;
    border: 1px solid #eee;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    text-align: center;
    background: #fff;
    transition: all .15s ease;
}
.icon-grid-item:hover {
    background: #eef4ff;
    border-color: #4a7dff;
}
.icon-grid-item small {
    font-size: 9px;
    margin-top: 4px;
    color: #666;
    word-break: break-all;
}
</style>

<script>
// Curated list of common Font Awesome (Free, Solid) icons.
// Format matches how icons are stored in DB: just the "fa-xxxx" suffix.
const FA_ICONS = [
    "fa-house","fa-user","fa-users","fa-gear","fa-gears","fa-bell","fa-envelope","fa-phone",
    "fa-truck","fa-truck-fast","fa-box","fa-boxes-stacked","fa-cart-shopping","fa-cart-plus",
    "fa-store","fa-tags","fa-tag","fa-gift","fa-star","fa-star-half-stroke","fa-heart",
    "fa-thumbs-up","fa-check","fa-check-double","fa-circle-check","fa-shield","fa-shield-halved",
    "fa-lock","fa-unlock","fa-key","fa-clock","fa-calendar","fa-calendar-days","fa-hourglass",
    "fa-map","fa-map-pin","fa-location-dot","fa-globe","fa-plane","fa-ship","fa-car","fa-motorcycle",
    "fa-warehouse","fa-industry","fa-building","fa-city","fa-house-chimney","fa-money-bill",
    "fa-money-bill-wave","fa-coins","fa-wallet","fa-credit-card","fa-receipt","fa-chart-line",
    "fa-chart-bar","fa-chart-pie","fa-file","fa-file-lines","fa-file-invoice","fa-folder",
    "fa-folder-open","fa-print","fa-camera","fa-image","fa-video","fa-microphone","fa-headphones",
    "fa-comment","fa-comments","fa-paper-plane","fa-share","fa-link","fa-paperclip","fa-download",
    "fa-upload","fa-cloud","fa-cloud-arrow-up","fa-cloud-arrow-down","fa-database","fa-server",
    "fa-laptop","fa-desktop","fa-mobile","fa-tablet","fa-wifi","fa-signal","fa-plug","fa-bolt",
    "fa-fire","fa-water","fa-leaf","fa-tree","fa-seedling","fa-recycle","fa-sun","fa-moon",
    "fa-cloud-sun","fa-snowflake","fa-umbrella","fa-wrench","fa-screwdriver-wrench","fa-hammer",
    "fa-toolbox","fa-magnifying-glass","fa-filter","fa-sliders","fa-list","fa-table",
    "fa-clipboard","fa-clipboard-check","fa-clipboard-list","fa-pen","fa-pen-to-square","fa-eraser",
    "fa-trash","fa-plus","fa-minus","fa-xmark","fa-circle-xmark","fa-triangle-exclamation",
    "fa-circle-info","fa-circle-question","fa-arrow-right","fa-arrow-left","fa-arrow-up",
    "fa-arrow-down","fa-rotate","fa-arrows-rotate","fa-thumbtack","fa-flag","fa-award",
    "fa-trophy","fa-medal","fa-crown","fa-gem","fa-handshake","fa-people-group","fa-user-tie",
    "fa-user-check","fa-user-plus","fa-user-gear","fa-graduation-cap","fa-book","fa-book-open",
    "fa-newspaper","fa-briefcase","fa-suitcase","fa-passport","fa-id-card","fa-address-card",
    "fa-headset","fa-life-ring","fa-hand-holding-heart","fa-hand-holding-dollar","fa-scale-balanced",
    "fa-gavel","fa-stethoscope","fa-pills","fa-syringe","fa-hospital","fa-truck-medical",
    "fa-utensils","fa-mug-hot","fa-pizza-slice","fa-basket-shopping","fa-boxes-packing"
];

let currentIconTarget = null;
const iconGrid = document.getElementById('iconGrid');
const iconSearchInput = document.getElementById('iconSearchInput');

function renderIconGrid(filter = '') {
    iconGrid.innerHTML = '';
    const filtered = FA_ICONS.filter(icon => icon.toLowerCase().includes(filter.toLowerCase()));

    if (filtered.length === 0) {
        iconGrid.innerHTML = '<p class="text-muted text-center w-100">No icons found.</p>';
        return;
    }

    filtered.forEach(icon => {
        const item = document.createElement('div');
        item.className = 'icon-grid-item';
        item.innerHTML = `<i class="fas ${icon}"></i><small>${icon}</small>`;
        item.addEventListener('click', () => selectIcon(icon));
        iconGrid.appendChild(item);
    });
}

function selectIcon(icon) {
    if (!currentIconTarget) return;

    const hiddenInput = document.getElementById('icon-' + currentIconTarget);
    const previewIcon = document.getElementById('icon-preview-' + currentIconTarget);

    if (hiddenInput) hiddenInput.value = icon;
    if (previewIcon) previewIcon.className = 'fas ' + icon;

    const modalEl = document.getElementById('iconPickerModal');
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if (modalInstance) modalInstance.hide();
}

document.querySelectorAll('.icon-picker-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        currentIconTarget = btn.getAttribute('data-target');
        iconSearchInput.value = '';
        renderIconGrid();
        const modalEl = document.getElementById('iconPickerModal');
        new bootstrap.Modal(modalEl).show();
    });
});

iconSearchInput.addEventListener('input', (e) => renderIconGrid(e.target.value));

document.addEventListener('DOMContentLoaded', () => renderIconGrid());
</script>

@endsection