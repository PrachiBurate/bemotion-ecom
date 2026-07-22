@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between">
<h5>Products Management</h5>

@if($user->hasPermission('products.create') || $user->is_admin)
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
+ Add Product
</button>
@endif
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
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
@foreach($products as $p)
<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($p->image)
<img src="{{ asset('assets/images/products/'.$p->image) }}" width="60">
@endif
</td>

<td>{{ $p->name }}</td>
<td>{{ $p->category->name ?? '' }}</td>
<td>{{ $p->subcategory->name ?? '' }}</td>
<td>{{ $p->brand->name ?? '' }}</td>
<td>₹{{ $p->price }}</td>
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

<td >

{{-- EDIT --}}
@if($user->hasPermission('products.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $p->id }}">
Edit
</button>
@endif
<br>
{{-- STOCK TOGGLE --}}
@if($user->hasPermission('products.outofstock') || $user->is_admin)
<form method="POST" action="/admin/products/stock/{{ $p->id }}">
@csrf

@if($p->stock_status == 'in_stock')
<button class="btn btn-danger btn-sm">Out of Stock</button>
@else
<button class="btn btn-success btn-sm">In Stock</button>
@endif

</form>
@endif

<br>

{{-- DELETE --}}
@if($user->hasPermission('products.delete') || $user->is_admin)
<form action="/admin/products/delete/{{ $p->id }}" method="POST">
@csrf
<button class="btn btn-dark btn-sm">Delete</button>
</form>
@endif

</td>

</tr>
@endforeach
</tbody>

</table>

</div>
</div>

</div>
</main>

<!-- ADD MODAL -->
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

<input type="text" name="name" class="form-control mb-2" placeholder="Product Name">
<label>
    <input type="checkbox" name="is_featured" value="1"> Featured
</label>

<label>
    <input type="checkbox" name="is_trending" value="1"> Trending
</label>
<select name="category_id" class="form-control mb-2">
<option value="">Category</option>
@foreach($categories as $c)
<option value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
</select>

<select name="subcategory_id" class="form-control mb-2">
<option value="">Subcategory</option>
@foreach($subcategories as $s)
<option value="{{ $s->id }}">{{ $s->name }}</option>
@endforeach
</select>

<select name="brand_id" class="form-control mb-2">
<option value="">Brand</option>
@foreach($brands as $b)
<option value="{{ $b->id }}">{{ $b->name }}</option>
@endforeach
</select>

<input type="number" name="price" class="form-control mb-2" placeholder="Price">
<input type="number" name="quantity" class="form-control mb-2" placeholder="Quantity">

<input type="file" name="image" class="form-control mb-2">

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

<!-- EDIT MODALS -->
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

<input type="text" name="name" value="{{ $p->name }}" class="form-control mb-2">
<label>
    <input type="checkbox" name="is_featured" value="1"
        {{ $p->is_featured ? 'checked' : '' }}>
    Featured
</label>

<label>
    <input type="checkbox" name="is_trending" value="1"
        {{ $p->is_trending ? 'checked' : '' }}>
    Trending
</label>
<select name="category_id" class="form-control mb-2">
@foreach($categories as $c)
<option value="{{ $c->id }}" {{ $p->category_id == $c->id ? 'selected' : '' }}>
{{ $c->name }}
</option>
@endforeach
</select>

<select name="subcategory_id" class="form-control mb-2">
@foreach($subcategories as $s)
<option value="{{ $s->id }}" {{ $p->subcategory_id == $s->id ? 'selected' : '' }}>
{{ $s->name }}
</option>
@endforeach
</select>

<select name="brand_id" class="form-control mb-2">
@foreach($brands as $b)
<option value="{{ $b->id }}" {{ $p->brand_id == $b->id ? 'selected' : '' }}>
{{ $b->name }}
</option>
@endforeach
</select>

<input type="number" name="price" value="{{ $p->price }}" class="form-control mb-2">
<input type="number" name="quantity" value="{{ $p->quantity }}" class="form-control mb-2">

<input type="file" name="image" class="form-control mb-2">

@if($p->image)
<img src="{{ asset('assets/images/products/'.$p->image) }}" width="80">
@endif

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

@endsection