@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between">
<h5>Deals Management</h5>

@if($user->hasPermission('deals.create') || $user->is_admin)
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeal">
+ Add Deal
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
<th>Product</th>
<th>Offer</th>
<th>Type</th>
<th>Dates</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($deals as $d)
<tr>

<td>{{ $d->product->name ?? '' }}</td>

<td>
Buy {{ $d->buy_quantity }} Get {{ $d->get_quantity }}
@if($d->get_type == 'free')
Free
@else
{{ $d->discount_percent }}% Off
@endif
</td>

<td>{{ ucfirst($d->get_type) }}</td>

<td>
{{ $d->start_date ?? '-' }} <br>
{{ $d->end_date ?? '-' }}
</td>

<td>
<span class="badge {{ $d->status ? 'bg-success':'bg-danger' }}">
{{ $d->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- EDIT --}}
@if($user->hasPermission('deals.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $d->id }}">
Edit
</button>
@endif
<br>
{{-- DELETE --}}
@if($user->hasPermission('deals.delete') || $user->is_admin)
<form method="POST" action="/admin/deals/delete/{{ $d->id }}">
@csrf
<button class="btn btn-danger btn-sm">Delete</button>
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
<div class="modal fade" id="addDeal">
<div class="modal-dialog">
<form method="POST" action="/admin/deals/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">
<div class="modal-header">
<h5>Add Deal</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<select name="product_id" class="form-control mb-2" required>
<option value="">Select Product</option>
@foreach($products as $p)
<option value="{{ $p->id }}">{{ $p->name }}</option>
@endforeach
</select>

<input type="text" name="title" class="form-control mb-2" placeholder="Title (Buy 1 Get 1 Free)">

<input type="number" name="buy_quantity" class="form-control mb-2" placeholder="Buy Quantity" required>

<input type="number" name="get_quantity" class="form-control mb-2" placeholder="Get Quantity" required>

<select name="get_type" class="form-control mb-2">
<option value="free">Free</option>
<option value="discount">Discount</option>
</select>
<input type="file" name="image" class="form-control mb-2">
<input type="number" name="discount_percent" class="form-control mb-2" placeholder="Discount %">

<input type="number" name="max_free_qty" class="form-control mb-2" placeholder="Max Free Qty">

<input type="date" name="start_date" class="form-control mb-2">
<input type="date" name="end_date" class="form-control mb-2">

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
@foreach($deals as $d)
<div class="modal fade" id="edit{{ $d->id }}">
<div class="modal-dialog">

<form method="POST" action="/admin/deals/update/{{ $d->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Deal</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<select name="product_id" class="form-control mb-2">
@foreach($products as $p)
<option value="{{ $p->id }}" {{ $d->product_id == $p->id ? 'selected' : '' }}>
{{ $p->name }}
</option>
@endforeach
</select>

<input type="text" name="title" value="{{ $d->title }}" class="form-control mb-2">

<input type="number" name="buy_quantity" value="{{ $d->buy_quantity }}" class="form-control mb-2">

<input type="number" name="get_quantity" value="{{ $d->get_quantity }}" class="form-control mb-2">

<select name="get_type" class="form-control mb-2">
<option value="free" {{ $d->get_type=='free'?'selected':'' }}>Free</option>
<option value="discount" {{ $d->get_type=='discount'?'selected':'' }}>Discount</option>
</select>
<input type="file" name="image" class="form-control mb-2">

@if($d->image)
<img src="{{ asset('assets/images/banner/'.$d->image) }}" width="80">
@endif
<input type="number" name="discount_percent" value="{{ $d->discount_percent }}" class="form-control mb-2">

<input type="number" name="max_free_qty" value="{{ $d->max_free_qty }}" class="form-control mb-2">

<input type="date" name="start_date" value="{{ $d->start_date }}" class="form-control mb-2">
<input type="date" name="end_date" value="{{ $d->end_date }}" class="form-control mb-2">

<select name="status" class="form-control">
<option value="1" {{ $d->status ? 'selected':'' }}>Active</option>
<option value="0" {{ !$d->status ? 'selected':'' }}>Inactive</option>
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