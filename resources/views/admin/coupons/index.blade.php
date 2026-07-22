@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- ================= HEADER ================= -->
<div class="page-header d-flex justify-content-between align-items-center">
    
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Coupons</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">Coupons</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('coupons.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoupon">
            + Add Coupon
        </button>
        @endif
    </div>

</div>

<!-- SUCCESS -->
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<!-- ================= TABLE ================= -->
<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
<th>No.</th>
<th>Code</th>
<th>Description</th>
<th>Type</th>
<th>Value</th>
<th>Min Amount</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($coupons as $c)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $c->code }}</td>
<td>{{ $c->description }}</td>
<td>{{ ucfirst($c->type) }}</td>
<td>{{ $c->value }}</td>
<td>{{ $c->min_amount }}</td>

<td>
<span class="badge {{ $c->status ? 'bg-success' : 'bg-danger' }}">
{{ $c->status ? 'Active' : 'Inactive' }}
</span>
</td>

<td>
<div class="d-flex gap-2">

{{-- EDIT --}}
@if($user->hasPermission('coupons.edit') || $user->is_admin)
<button class="btn btn-sm btn-warning"
    data-bs-toggle="modal"
    data-bs-target="#edit{{ $c->id }}">
    Edit
</button>
@endif

{{-- STATUS --}}
@if($user->hasPermission('coupons.edit') || $user->is_admin)
<form method="POST" action="/admin/coupons/status/{{ $c->id }}">
@csrf
<button class="btn btn-sm {{ $c->status ? 'btn-danger' : 'btn-secondary' }}">
{{ $c->status ? 'Deactivate' : 'Activate' }}
</button>
</form>
@endif

{{-- DELETE --}}
@if($user->hasPermission('coupons.delete') || $user->is_admin)
<form method="POST" action="/admin/coupons/delete/{{ $c->id }}">
@csrf
<button class="btn btn-sm btn-dark">Delete</button>
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
<div class="modal fade" id="addCoupon">
<div class="modal-dialog">

<form method="POST" action="/admin/coupons/store">
@csrf

<div class="modal-content">
<div class="modal-header">
<h5>Add Coupon</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="code" class="form-control mb-2" placeholder="Code" required>

<input type="text" name="description" class="form-control mb-2" placeholder="Description">

<select name="type" class="form-control mb-2">
<option value="flat">Flat</option>
<option value="percent">Percent</option>
</select>

<input type="number" name="value" class="form-control mb-2" placeholder="Value" required>

<input type="number" name="min_amount" class="form-control mb-2" placeholder="Min Amount">

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
@foreach($coupons as $c)
<div class="modal fade" id="edit{{ $c->id }}">
<div class="modal-dialog">

<form method="POST" action="/admin/coupons/update/{{ $c->id }}">
@csrf

<div class="modal-content">
<div class="modal-header">
<h5>Edit Coupon</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="code" value="{{ $c->code }}" class="form-control mb-2" required>

<input type="text" name="description" value="{{ $c->description }}" class="form-control mb-2">

<select name="type" class="form-control mb-2">
<option value="flat" {{ $c->type=='flat'?'selected':'' }}>Flat</option>
<option value="percent" {{ $c->type=='percent'?'selected':'' }}>Percent</option>
</select>

<input type="number" name="value" value="{{ $c->value }}" class="form-control mb-2">

<input type="number" name="min_amount" value="{{ $c->min_amount }}" class="form-control mb-2">

<select name="status" class="form-control">
<option value="1" {{ $c->status ? 'selected':'' }}>Active</option>
<option value="0" {{ !$c->status ? 'selected':'' }}>Inactive</option>
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