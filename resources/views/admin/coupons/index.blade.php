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

<!-- ERRORS -->
@if($errors->any())
<div class="alert alert-danger mt-2">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
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
@forelse($coupons as $c)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $c->code }}</td>
<td>{{ $c->description }}</td>
<td>{{ ucfirst($c->type) }}</td>
<td>{{ $c->type == 'percent' ? $c->value.'%' : '₹'.number_format($c->value, 2) }}</td>
<td>{{ $c->min_amount !== null ? '₹'.number_format($c->min_amount, 2) : '—' }}</td>

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
<form method="POST" action="/admin/coupons/delete/{{ $c->id }}" onsubmit="return confirm('Delete this coupon?');">
@csrf
<button class="btn btn-sm btn-dark">Delete</button>
</form>
@endif

</div>
</td>

</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted">No coupons found.</td>
</tr>
@endforelse
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

<label class="form-label">Code</label>
<input type="text" name="code" class="form-control mb-1" placeholder="Code" value="{{ old('code') }}" required style="text-transform:uppercase">
@error('code')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Description</label>
<input type="text" name="description" class="form-control mb-2" placeholder="Description" value="{{ old('description') }}">
@error('description')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Type</label>
<select name="type" id="type-add" class="form-control mb-2">
<option value="flat" {{ old('type') == 'flat' ? 'selected' : '' }}>Flat</option>
<option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent</option>
</select>

<label class="form-label" id="valueLabel-add">Value</label>
<input type="number" step="0.01" min="0" name="value" class="form-control mb-1" placeholder="Value" value="{{ old('value') }}" required>
<small class="text-muted d-block mb-1" id="valueHint-add">Enter a flat amount (₹)</small>
@error('value')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Minimum Order Amount (optional)</label>
<input type="number" step="0.01" min="0" name="min_amount" class="form-control mb-1" placeholder="Min Amount" value="{{ old('min_amount') }}">
@error('min_amount')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

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

<label class="form-label">Code</label>
<input type="text" name="code" value="{{ $c->code }}" class="form-control mb-2" required style="text-transform:uppercase">

<label class="form-label">Description</label>
<input type="text" name="description" value="{{ $c->description }}" class="form-control mb-2">

<label class="form-label">Type</label>
<select name="type" id="type-edit{{ $c->id }}" class="form-control mb-2">
<option value="flat" {{ $c->type=='flat'?'selected':'' }}>Flat</option>
<option value="percent" {{ $c->type=='percent'?'selected':'' }}>Percent</option>
</select>

<label class="form-label" id="valueLabel-edit{{ $c->id }}">Value</label>
<input type="number" step="0.01" min="0" name="value" value="{{ $c->value }}" class="form-control mb-1" required>
<small class="text-muted d-block mb-1" id="valueHint-edit{{ $c->id }}">
    {{ $c->type == 'percent' ? 'Enter a percentage (0–100)' : 'Enter a flat amount (₹)' }}
</small>

<label class="form-label">Minimum Order Amount (optional)</label>
<input type="number" step="0.01" min="0" name="min_amount" value="{{ $c->min_amount }}" class="form-control mb-2">

<label class="form-label">Status</label>
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

<script>
// UX-only: swap the value hint/max based on coupon type. Server-side
// validation (percent capped at 100) is what actually enforces this.
function bindCouponTypeHint(selectId, inputId, hintId, labelId) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);
    const hint = document.getElementById(hintId);

    if (!select) return;

    function update() {
        if (select.value === 'percent') {
            hint.textContent = 'Enter a percentage (0–100)';
            input.setAttribute('max', '100');
        } else {
            hint.textContent = 'Enter a flat amount (₹)';
            input.removeAttribute('max');
        }
    }

    select.addEventListener('change', update);
    update();
}

bindCouponTypeHint('type-add', 'addCoupon input[name="value"]', 'valueHint-add', 'valueLabel-add');
document.querySelector('#addCoupon input[name="value"]').id = 'value-add';
bindCouponTypeHint('type-add', 'value-add', 'valueHint-add', 'valueLabel-add');

@foreach($coupons as $c)
document.querySelector('#edit{{ $c->id }} input[name="value"]').id = 'value-edit{{ $c->id }}';
bindCouponTypeHint('type-edit{{ $c->id }}', 'value-edit{{ $c->id }}', 'valueHint-edit{{ $c->id }}', 'valueLabel-edit{{ $c->id }}');
@endforeach
</script>

@endsection