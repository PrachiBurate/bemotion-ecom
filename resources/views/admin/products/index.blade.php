@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between align-items-center">
<h5 class="m-0">Products Management</h5>

@if($user->hasPermission('products.create') || $user->is_admin)
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
+ Add Product
</button>
@endif
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

<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
<th>No.</th>
<th>Image</th>
<th>Name</th>
<th>Category</th>
<th>Subcategory</th>
<th>Brand</th>
<th>Price</th>
<th>Qty</th>
<th>Stock</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@forelse($products as $p)
<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($p->image)
<img src="{{ asset('assets/images/products/'.$p->image) }}" width="60">
@if($p->images->count())
<span class="badge bg-secondary">+{{ $p->images->count() }}</span>
@endif
@endif
</td>

<td>{{ $p->name }}</td>
<td>{{ $p->category->name ?? '—' }}</td>
<td>{{ $p->subcategory->name ?? '—' }}</td>
<td>{{ $p->brand->name ?? '—' }}</td>
<td>₹{{ number_format($p->price, 2) }}</td>
<td>{{ $p->quantity }}</td>

<td>
<span class="badge {{ $p->stock_status == 'in_stock' ? 'bg-success' : 'bg-danger' }}">
{{ $p->stock_status == 'in_stock' ? 'In Stock' : 'Out of Stock' }}
</span>
</td>

<td>
<span class="badge {{ $p->status ? 'bg-success' : 'bg-danger' }}">
{{ $p->status ? 'Active' : 'Inactive' }}
</span>
</td>

<td>

@if($user->hasPermission('products.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#edit{{ $p->id }}">
Edit
</button>
@endif
<br>

@if($user->hasPermission('products.outofstock') || $user->is_admin)
<form method="POST" action="/admin/products/stock/{{ $p->id }}" class="d-inline">
@csrf
@if($p->stock_status == 'in_stock')
<button class="btn btn-danger btn-sm mb-1">Out of Stock</button>
@else
<button class="btn btn-success btn-sm mb-1">In Stock</button>
@endif
</form>
@endif
<br>

@if($user->hasPermission('products.delete') || $user->is_admin)
<form action="/admin/products/delete/{{ $p->id }}" method="POST" onsubmit="return confirm('Delete this product?');" class="d-inline">
@csrf
<button class="btn btn-dark btn-sm">Delete</button>
</form>
@endif

</td>

</tr>
@empty
<tr>
    <td colspan="11" class="text-center text-muted">No products found.</td>
</tr>
@endforelse
</tbody>

</table>

</div>
</div>

</div>
</main>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addProduct">
<div class="modal-dialog modal-lg">
<form method="POST" action="/admin/products/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">
<div class="modal-header">
<h5>Add Product</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<label class="form-label">Name</label>
<input type="text" name="name" class="form-control mb-2" placeholder="Product Name" value="{{ old('name') }}" required>
@error('name')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<div class="mb-2">
<label class="me-3">
    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> Featured
</label>
<label>
    <input type="checkbox" name="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }}> Trending
</label>
</div>

<label class="form-label">Category</label>
<select name="category_id" class="form-control mb-2" required>
<option value="">Select Category</option>
@foreach($categories as $c)
<option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
@endforeach
</select>
@error('category_id')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Subcategory</label>
<select name="subcategory_id" class="form-control mb-2">
<option value="">Select Subcategory (optional)</option>
@foreach($subcategories as $s)
<option value="{{ $s->id }}" {{ old('subcategory_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
@endforeach
</select>

<label class="form-label">Brand</label>
<select name="brand_id" class="form-control mb-2">
<option value="">Select Brand (optional)</option>
@foreach($brands as $b)
<option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
@endforeach
</select>

<div class="row">
    <div class="col-6">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control mb-2" placeholder="Price" value="{{ old('price') }}" required>
        @error('price')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
    </div>
    <div class="col-6">
        <label class="form-label">Quantity</label>
        <input type="number" min="0" name="quantity" class="form-control mb-2" placeholder="Quantity" value="{{ old('quantity') }}" required>
        @error('quantity')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
    </div>
</div>

<label class="form-label">Main Image</label>
<input type="file" name="image" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp">
@error('image')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Gallery Images (optional, up to 10)</label>
<input type="file" name="gallery[]" id="galleryInput-add" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp" multiple>
<div id="galleryPreview-add" class="d-flex flex-wrap gap-2 mb-2"></div>
@error('gallery')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<hr>

<label class="form-label d-block">Specifications <small class="text-muted">(e.g. Weight → 1.5kg)</small></label>
<div id="specRows-add">
    {{-- rows get added here by JS --}}
</div>
<button type="button" class="btn btn-outline-secondary btn-sm add-spec-row" data-target="add">
    + Add Specification
</button>

<hr>

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
@foreach($products as $p)
<div class="modal fade" id="edit{{ $p->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/products/update/{{ $p->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Product</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<label class="form-label">Name</label>
<input type="text" name="name" value="{{ $p->name }}" class="form-control mb-2" required>

<div class="mb-2">
<label class="me-3">
    <input type="checkbox" name="is_featured" value="1" {{ $p->is_featured ? 'checked' : '' }}> Featured
</label>
<label>
    <input type="checkbox" name="is_trending" value="1" {{ $p->is_trending ? 'checked' : '' }}> Trending
</label>
</div>

<label class="form-label">Category</label>
<select name="category_id" class="form-control mb-2" required>
@foreach($categories as $c)
<option value="{{ $c->id }}" {{ $p->category_id == $c->id ? 'selected' : '' }}>
{{ $c->name }}
</option>
@endforeach
</select>

<label class="form-label">Subcategory</label>
<select name="subcategory_id" class="form-control mb-2">
<option value="">— none —</option>
@foreach($subcategories as $s)
<option value="{{ $s->id }}" {{ $p->subcategory_id == $s->id ? 'selected' : '' }}>
{{ $s->name }}
</option>
@endforeach
</select>

<label class="form-label">Brand</label>
<select name="brand_id" class="form-control mb-2">
<option value="">— none —</option>
@foreach($brands as $b)
<option value="{{ $b->id }}" {{ $p->brand_id == $b->id ? 'selected' : '' }}>
{{ $b->name }}
</option>
@endforeach
</select>

<div class="row">
    <div class="col-6">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ $p->price }}" class="form-control mb-2" required>
    </div>
    <div class="col-6">
        <label class="form-label">Quantity</label>
        <input type="number" min="0" name="quantity" value="{{ $p->quantity }}" class="form-control mb-2" required>
    </div>
</div>

<label class="form-label">Main Image</label>
<input type="file" name="image" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp">
<small class="text-muted d-block mb-2">Leave empty to keep the current main image.</small>

@if($p->image)
<img src="{{ asset('assets/images/products/'.$p->image) }}" width="80" class="mb-2 d-block">
@endif

<label class="form-label">Existing Gallery Images</label>
<div class="d-flex flex-wrap gap-2 mb-2">
    @forelse($p->images as $img)
        <div class="text-center">
            <img src="{{ asset('assets/images/products/gallery/'.$img->image) }}" width="70" class="d-block mb-1 rounded border">
            <label class="small text-danger">
                <input type="checkbox" name="remove_gallery[]" value="{{ $img->id }}"> Remove
            </label>
        </div>
    @empty
        <span class="text-muted small">No gallery images yet.</span>
    @endforelse
</div>

<label class="form-label">Add More Gallery Images (optional)</label>
<input type="file" name="gallery[]" id="galleryInput-edit{{ $p->id }}" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp" multiple>
<div id="galleryPreview-edit{{ $p->id }}" class="d-flex flex-wrap gap-2 mb-2"></div>

<hr>

<label class="form-label d-block">Specifications <small class="text-muted">(e.g. Weight → 1.5kg)</small></label>
<div id="specRows-edit{{ $p->id }}">
    @foreach($p->specifications as $spec)
    <div class="d-flex gap-2 mb-2 spec-row">
        <input type="text" name="spec_key[]" class="form-control" placeholder="Field (e.g. Weight)" value="{{ $spec->key }}">
        <input type="text" name="spec_value[]" class="form-control" placeholder="Value (e.g. 1.5kg)" value="{{ $spec->value }}">
        <button type="button" class="btn btn-outline-danger btn-sm remove-spec-row">&times;</button>
    </div>
    @endforeach
</div>
<button type="button" class="btn btn-outline-secondary btn-sm add-spec-row" data-target="edit{{ $p->id }}">
    + Add Specification
</button>

<hr>

<label class="form-label">Status</label>
<select name="status" class="form-control">
<option value="1" {{ $p->status ? 'selected' : '' }}>Active</option>
<option value="0" {{ !$p->status ? 'selected' : '' }}>Inactive</option>
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

<script>
// -------- Specification rows (add/remove) --------
function specRowTemplate() {
    const row = document.createElement('div');
    row.className = 'd-flex gap-2 mb-2 spec-row';
    row.innerHTML = `
        <input type="text" name="spec_key[]" class="form-control" placeholder="Field (e.g. Weight)">
        <input type="text" name="spec_value[]" class="form-control" placeholder="Value (e.g. 1.5kg)">
        <button type="button" class="btn btn-outline-danger btn-sm remove-spec-row">&times;</button>
    `;
    return row;
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('add-spec-row')) {
        const target = e.target.getAttribute('data-target');
        const container = document.getElementById('specRows-' + target);
        container.appendChild(specRowTemplate());
    }

    if (e.target.classList.contains('remove-spec-row')) {
        e.target.closest('.spec-row').remove();
    }
});

// -------- Gallery image previews --------
function bindGalleryPreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if (!input) return;

    input.addEventListener('change', function () {
        preview.innerHTML = '';
        Array.from(input.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.width = 70;
                img.className = 'rounded border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
}

bindGalleryPreview('galleryInput-add', 'galleryPreview-add');
@foreach($products as $p)
bindGalleryPreview('galleryInput-edit{{ $p->id }}', 'galleryPreview-edit{{ $p->id }}');
@endforeach
</script>

@endsection