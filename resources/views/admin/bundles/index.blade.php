@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp
<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h5>Bundle Management</h5>
   @if($user->hasPermission('bundles.create') || $user->is_admin)

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBundle">
        + Add Bundle
    </button>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
<div class="card-body">

<table class="table table-bordered align-middle">
<thead>
<tr>
<th>#</th>
<th>Image</th>
<th>Name</th>
<th>Products</th>
<th>Price</th>
<th>Offer Price</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse($bundles as $bundle)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($bundle->image)
<img src="{{ asset('assets/images/bundles/'.$bundle->image) }}" width="60">
@endif
</td>

<td>{{ $bundle->name }}</td>

<td>
@foreach($bundle->items as $item)
<div>{{ $item->product->name ?? '—' }} (x{{ $item->quantity }})</div>
@endforeach
</td>

<td>₹{{ number_format($bundle->price, 2) }}</td>
<td>{{ $bundle->offer_price !== null ? '₹'.number_format($bundle->offer_price, 2) : '—' }}</td>

<td>
<span class="badge {{ $bundle->status ? 'bg-success':'bg-danger' }}">
{{ $bundle->status ? 'Active':'Inactive' }}
</span>
</td>

<td>
   @if($user->hasPermission('bundles.edit') || $user->is_admin)

<button class="btn btn-warning btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#edit{{ $bundle->id }}">
Edit
</button>
@endif
   @if($user->hasPermission('bundles.delete') || $user->is_admin)

<form method="POST"
      action="{{ url('/admin/bundles/delete/'.$bundle->id) }}"
      class="d-inline"
      onsubmit="return confirm('Delete this bundle?');">
@csrf
<button class="btn btn-danger btn-sm">Delete</button>
</form>
@endif

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center">No Bundles Found</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>

</div>
</main>

{{-- ADD BUNDLE --}}
<div class="modal fade" id="addBundle">
<div class="modal-dialog modal-xl">

<form method="POST"
      action="{{ url('/admin/bundles/store') }}"
      enctype="multipart/form-data">

@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Add Bundle</h5>
<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
</div>

<div class="modal-body">

<label class="form-label">Name</label>
<input type="text" class="form-control mb-1" name="name" value="{{ old('name') }}" placeholder="Bundle Name">
@error('name')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Description</label>
<textarea class="form-control mb-2" name="description" placeholder="Description">{{ old('description') }}</textarea>

<div class="row">
<div class="col-md-6">
<label class="form-label">Price</label>
<input type="number" step="0.01" min="0" class="form-control mb-1" name="price" value="{{ old('price') }}" placeholder="Price">
@error('price')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label">Offer Price (optional)</label>
<input type="number" step="0.01" min="0" class="form-control mb-1" name="offer_price" value="{{ old('offer_price') }}" placeholder="Offer Price">
@error('offer_price')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
</div>

<label class="form-label">Image (optional)</label>
<input type="file" class="form-control mb-1" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
@error('image')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Status</label>
<select class="form-control mb-3" name="status">
<option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
<option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
</select>

<h5>Products</h5>
@error('products')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<div id="productRows">

<div class="row productRow mb-2">

<div class="col-md-6">
<select class="form-control" name="products[0][product_id]">
<option value="">Select Product</option>
@foreach($products as $product)
<option value="{{ $product->id }}">{{ $product->name }}</option>
@endforeach
</select>
</div>

<div class="col-md-3">
<input type="number" min="1" class="form-control" value="1" name="products[0][quantity]">
</div>

<div class="col-md-3">
<button type="button" class="btn btn-danger removeRow">Remove</button>
</div>

</div>

</div>

<button type="button" class="btn btn-success mt-2" id="addProduct">+ Add Product</button>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Save Bundle</button>
</div>

</div>

</form>

</div>
</div>

{{-- EDIT MODALS --}}
@foreach($bundles as $bundle)

<div class="modal fade" id="edit{{ $bundle->id }}">
<div class="modal-dialog modal-xl">

<form method="POST"
      action="{{ url('/admin/bundles/update/'.$bundle->id) }}"
      enctype="multipart/form-data">

@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Bundle</h5>
<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
</div>

<div class="modal-body">

<label class="form-label">Name</label>
<input class="form-control mb-2" name="name" value="{{ $bundle->name }}">

<label class="form-label">Description</label>
<textarea class="form-control mb-2" name="description">{{ $bundle->description }}</textarea>

<div class="row">
<div class="col-md-6">
<label class="form-label">Price</label>
<input class="form-control mb-2" type="number" step="0.01" min="0" name="price" value="{{ $bundle->price }}">
</div>
<div class="col-md-6">
<label class="form-label">Offer Price (optional)</label>
<input class="form-control mb-2" type="number" step="0.01" min="0" name="offer_price" value="{{ $bundle->offer_price }}">
</div>
</div>

<label class="form-label">Image (optional)</label>
<input class="form-control mb-1" type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
<small class="text-muted d-block mb-2">Leave empty to keep the current image.</small>

@if($bundle->image)
<img src="{{ asset('assets/images/bundles/'.$bundle->image) }}" width="80" class="mb-2">
@endif

<label class="form-label">Status</label>
<select class="form-control mb-3" name="status">
<option value="1" {{ $bundle->status?'selected':'' }}>Active</option>
<option value="0" {{ !$bundle->status?'selected':'' }}>Inactive</option>
</select>

<hr>

<h5>Products</h5>

<div id="editProductRows{{ $bundle->id }}">

@foreach($bundle->items as $i => $item)

<div class="row productRow mb-2">

    <div class="col-md-6">

        <select
            class="form-control"
            name="products[{{ $i }}][product_id]">

            <option value="">Select Product</option>

            @foreach($products as $product)

            <option value="{{ $product->id }}"
                {{ $item->product_id == $product->id ? 'selected' : '' }}>

                {{ $product->name }}

            </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-3">

        <input
            type="number"
            min="1"
            class="form-control"
            value="{{ $item->quantity }}"
            name="products[{{ $i }}][quantity]">

    </div>

    <div class="col-md-3">

        <button
            type="button"
            class="btn btn-danger removeRow">

            Remove

        </button>

    </div>

</div>

@endforeach

</div>

<button
    type="button"
    class="btn btn-success mt-2 addEditProduct"
    data-id="{{ $bundle->id }}">

    + Add Product

</button>
</div>

<div class="modal-footer">
<button class="btn btn-primary">Update Bundle</button>
</div>

</div>

</form>

</div>
</div>

@endforeach

@endsection

@section('scripts')
<script>
let productOptions = `
<option value="">Select Product</option>
@foreach($products as $product)
<option value="{{ $product->id }}">
{{ $product->name }}
</option>
@endforeach
`;

document.addEventListener("click", function(e){

    if(e.target.id === "addProduct"){

        let rows = document.querySelectorAll("#productRows .productRow").length;

        let html = `
        <div class="row productRow mb-2">

            <div class="col-md-6">
                <select
                    class="form-control"
                    name="products[${rows}][product_id]">

                    ${productOptions}

                </select>
            </div>

            <div class="col-md-3">
                <input
                    class="form-control"
                    type="number"
                    min="1"
                    value="1"
                    name="products[${rows}][quantity]">
            </div>

            <div class="col-md-3">
                <button
                    type="button"
                    class="btn btn-danger removeRow">

                    Remove

                </button>
            </div>

        </div>
        `;

        document
            .getElementById("productRows")
            .insertAdjacentHTML("beforeend", html);

    }

    if(e.target.classList.contains("addEditProduct")){

        let id = e.target.dataset.id;

        let container = document.getElementById("editProductRows"+id);

        let rows = container.querySelectorAll(".productRow").length;

        let html = `
        <div class="row productRow mb-2">

            <div class="col-md-6">

                <select
                    class="form-control"
                    name="products[${rows}][product_id]">

                    ${productOptions}

                </select>

            </div>

            <div class="col-md-3">

                <input
                    type="number"
                    min="1"
                    value="1"
                    class="form-control"
                    name="products[${rows}][quantity]">

            </div>

            <div class="col-md-3">

                <button
                    type="button"
                    class="btn btn-danger removeRow">

                    Remove

                </button>

            </div>

        </div>
        `;

        container.insertAdjacentHTML("beforeend", html);

    }

    if(e.target.classList.contains("removeRow")){

        let row = e.target.closest(".productRow");

        let parent = row.parentNode;

        if(parent.querySelectorAll(".productRow").length > 1){

            row.remove();

        }

    }

});

</script>
@endsection