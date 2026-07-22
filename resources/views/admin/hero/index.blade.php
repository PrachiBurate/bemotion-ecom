@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Hero Slider Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Hero Slider</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('hero.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHero">
            + Add Slider
        </button>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
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
    <th>Image</th>
    <th>Title</th>
    <th>Price</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($sliders as $s)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>
        @if($s->image)
        <img src="{{ asset('assets/images/hero/'.$s->image) }}" width="80">
        @endif
    </td>

    <td>{{ $s->title }}</td>
    <td>{{ $s->price }}</td>

    <td>
        <span class="badge {{ $s->status ? 'bg-success' : 'bg-danger' }}">
            {{ $s->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            @if($user->hasPermission('hero.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#edit{{ $s->id }}">
                Edit
            </button>
            @endif

            @if($user->hasPermission('hero.delete') || $user->is_admin)
            <form action="/admin/hero/delete/{{ $s->id }}" method="POST"
                  onsubmit="return confirm('Delete this slider? This cannot be undone.');">
                @csrf
                @method('DELETE')
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
<div class="modal fade" id="addHero" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/hero/store" enctype="multipart/form-data" class="needs-validation" novalidate>
@csrf

<div class="modal-content">
<div class="modal-header">
    <h5>Add Hero Slider</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-2">
    <input type="text" name="subtitle" placeholder="Subtitle" class="form-control" maxlength="150">
</div>

<div class="mb-2">
    <input type="text" name="title" placeholder="Title" class="form-control" required minlength="3" maxlength="150">
    <div class="invalid-feedback">Title is required (min 3 characters).</div>
</div>

<div class="mb-2">
    <textarea name="description" class="form-control" placeholder="Description" rows="3"></textarea>
</div>

<div class="mb-2">
    <input type="number" name="price" placeholder="Price" class="form-control" required min="0" step="0.01">
    <div class="invalid-feedback">Please enter a valid price (0 or more).</div>
</div>

<div class="mb-2">
    <input type="text" name="button_text" placeholder="Button Text" class="form-control" maxlength="50">
</div>

<div class="mb-2">
    <input type="text" name="button_link" placeholder="Button Link" class="form-control" maxlength="255">
</div>

<div class="mb-2">
  <input type="file"
       id="addImage"
       name="image"
       class="form-control"
       accept=".jpg,.jpeg,.png,.webp"
       required>

<small class="text-muted">
    Allowed: JPG, JPEG, PNG, WEBP | Max Size: 2 MB
</small>

<div class="text-danger mt-1 image-error"></div>
    <div class="invalid-feedback">Please select an image.</div>
</div>

<div class="mb-2">
    <select name="status" class="form-select" required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
</div>

</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="submit">Create</button>
</div>
</div>

</form>
</div>
</div>

<!-- ================= EDIT MODALS ================= -->
@foreach($sliders as $s)
<div class="modal fade" id="edit{{ $s->id }}" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg">

<form action="{{ route('admin.hero.update',$s->id) }}"
      method="POST"
      enctype="multipart/form-data" class="needs-validation"
      novalidate>

    @csrf
    @method('PUT')

{{-- If your route for this update action is defined with Route::post(), remove the @method('PUT') line above. --}}

<div class="modal-content">

<div class="modal-header">
    <h5>Edit Hero Slider</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-2">
    <input
        type="text"
        name="subtitle"
        class="form-control"
        placeholder="Enter Subtitle"
        value="{{ $s->subtitle }}"
        maxlength="150">
</div>

<div class="mb-2">
    <input
        type="text"
        name="title"
        class="form-control"
        placeholder="Enter Hero Title"
        value="{{ $s->title }}"
        required
        minlength="3"
        maxlength="150">
    <div class="invalid-feedback">
        Title is required (minimum 3 characters).
    </div>
</div>

<div class="mb-2">
    <textarea
        name="description"
        class="form-control"
        rows="3"
        placeholder="Enter Hero Description">{{ $s->description }}</textarea>
</div>

<div class="mb-2">
    <input
        type="number"
        name="price"
        class="form-control"
        placeholder="Enter Product Price"
        value="{{ $s->price }}"
        required
        min="0"
        step="0.01">
    <div class="invalid-feedback">
        Please enter a valid price.
    </div>
</div>

<div class="mb-2">
    <input
        type="text"
        name="button_text"
        class="form-control"
        placeholder="Enter Button Text"
        value="{{ $s->button_text }}"
        maxlength="50">
</div>

<div class="mb-2">
    <input
        type="text"
        name="button_link"
        class="form-control"
        placeholder="Example: /shop"
        value="{{ $s->button_link }}"
        maxlength="255">
</div>

<div class="mb-3">

    <label class="form-label fw-semibold">
        Hero Image
    </label>

    <input
        type="file"
        class="form-control hero-image"
        name="image"
        accept=".jpg,.jpeg,.png,.webp">

    <small class="text-muted">
        Leave empty to keep the existing image.
        <br>
        Allowed: JPG, JPEG, PNG, WEBP | Maximum 2 MB
    </small>

    <div class="text-danger mt-1 image-error"></div>

    @if($s->image)
        <div class="mt-3">
            <p class="mb-1 fw-semibold">Current Image</p>

            <img
                src="{{ asset('assets/images/hero/'.$s->image) }}"
                class="img-thumbnail"
                style="width:160px;height:100px;object-fit:cover;">
        </div>
    @endif

</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Status</label>

    <select name="status" class="form-select" required>
        <option value="1" {{ old('status', $s->status) == 1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0" {{ old('status', $s->status) == 0 ? 'selected' : '' }}>
            Inactive
        </option>
    </select>

    @error('status')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
</div>

<div class="modal-footer">
    <button class="btn btn-success" type="submit">Update</button>
</div>

</div>

</form>
</div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
// Bootstrap 5 custom validation: block submit and show feedback until all required fields are valid
(function () {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const MAX_SIZE = 2 * 1024 * 1024; // 2 MB

    document.querySelectorAll('form').forEach(function(form){

        form.addEventListener('submit', function(e){

            const input = form.querySelector('input[type="file"][name="image"]');

            if(!input) return;

            const errorBox = input.parentElement.querySelector('.image-error');

            if(errorBox){
                errorBox.innerHTML = "";
            }

            if(input.files.length === 0){
                return;
            }

            const file = input.files[0];

            const allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            if(!allowedTypes.includes(file.type)){

                e.preventDefault();

                errorBox.innerHTML =
                    '<div class="alert alert-danger p-2 mb-0">Only JPG, PNG and WEBP images are allowed.</div>';

                input.value = "";

                return;
            }

            if(file.size > MAX_SIZE){

                e.preventDefault();

                errorBox.innerHTML =
                    '<div class="alert alert-danger p-2 mb-0">Image size cannot exceed 2 MB.</div>';

                input.value = "";

                return;
            }

        });

    });

});
</script>
@endpush