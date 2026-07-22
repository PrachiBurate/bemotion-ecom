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
<th>Product</th>
<th>Offer</th>
<th>Type</th>
<th>Dates</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@forelse($deals as $d)
<tr>

<td>{{ $d->product->name ?? '—' }}</td>

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
<form method="POST" action="/admin/deals/delete/{{ $d->id }}" onsubmit="return confirm('Delete this deal?');">
@csrf
<button class="btn btn-danger btn-sm">Delete</button>
</form>
@endif

</td>

</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">No deals found.</td>
</tr>
@endforelse
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

<label class="form-label">Product</label>
<select name="product_id" class="form-control mb-2" required>
<option value="">Select Product</option>
@foreach($products as $p)
<option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
@endforeach
</select>
@error('product_id')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Title (optional)</label>
<input type="text" name="title" class="form-control mb-2" placeholder="Title (Buy 1 Get 1 Free)" value="{{ old('title') }}">
@error('title')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<div class="row">
<div class="col-6">
    <label class="form-label">Buy Quantity</label>
    <input type="number" min="1" name="buy_quantity" class="form-control mb-2" placeholder="Buy Quantity" value="{{ old('buy_quantity') }}" required>
    @error('buy_quantity')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
<div class="col-6">
    <label class="form-label">Get Quantity</label>
    <input type="number" min="1" name="get_quantity" class="form-control mb-2" placeholder="Get Quantity" value="{{ old('get_quantity') }}" required>
    @error('get_quantity')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
</div>

<label class="form-label">Offer Type</label>
<select name="get_type" id="get_type-add" class="form-control mb-2" required>
<option value="free" {{ old('get_type') == 'free' ? 'selected' : '' }}>Free</option>
<option value="discount" {{ old('get_type') == 'discount' ? 'selected' : '' }}>Discount</option>
</select>

<label class="form-label">Banner Image (optional)</label>
<input type="file" name="image" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp">
@error('image')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<div id="discountField-add">
    <label class="form-label">Discount %</label>
    <input type="number" step="0.01" min="0" max="100" name="discount_percent" class="form-control mb-2" placeholder="Discount %" value="{{ old('discount_percent') }}">
    @error('discount_percent')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>

<label class="form-label">Max Free Qty (optional)</label>
<input type="number" min="1" name="max_free_qty" class="form-control mb-2" placeholder="Max Free Qty" value="{{ old('max_free_qty') }}">
@error('max_free_qty')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<div class="row">
<div class="col-6">
    <label class="form-label">Start Date</label>
    <input type="date" name="start_date" class="form-control mb-2" value="{{ old('start_date') }}">
    @error('start_date')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
<div class="col-6">
    <label class="form-label">End Date</label>
    <input type="date" name="end_date" class="form-control mb-2" value="{{ old('end_date') }}">
    @error('end_date')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
</div>

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

<label class="form-label">Product</label>
<select name="product_id" class="form-control mb-2" required>
@foreach($products as $p)
<option value="{{ $p->id }}" {{ $d->product_id == $p->id ? 'selected' : '' }}>
{{ $p->name }}
</option>
@endforeach
</select>

<label class="form-label">Title (optional)</label>
<input type="text" name="title" value="{{ $d->title }}" class="form-control mb-2">

<div class="row">
<div class="col-6">
    <label class="form-label">Buy Quantity</label>
    <input type="number" min="1" name="buy_quantity" value="{{ $d->buy_quantity }}" class="form-control mb-2" required>
</div>
<div class="col-6">
    <label class="form-label">Get Quantity</label>
    <input type="number" min="1" name="get_quantity" value="{{ $d->get_quantity }}" class="form-control mb-2" required>
</div>
</div>

<label class="form-label">Offer Type</label>
<select name="get_type" id="get_type-edit{{ $d->id }}" class="form-control mb-2" required>
<option value="free" {{ $d->get_type=='free'?'selected':'' }}>Free</option>
<option value="discount" {{ $d->get_type=='discount'?'selected':'' }}>Discount</option>
</select>

<label class="form-label">Banner Image (optional)</label>
<input type="file" name="image" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp">
<small class="text-muted d-block mb-2">Leave empty to keep the current image.</small>

@if($d->image)
<img src="{{ asset('assets/images/banner/'.$d->image) }}" width="80" class="mb-2 d-block">
@endif

<div id="discountField-edit{{ $d->id }}">
    <label class="form-label">Discount %</label>
    <input type="number" step="0.01" min="0" max="100" name="discount_percent" value="{{ $d->discount_percent }}" class="form-control mb-2">
</div>

<label class="form-label">Max Free Qty (optional)</label>
<input type="number" min="1" name="max_free_qty" value="{{ $d->max_free_qty }}" class="form-control mb-2">

<div class="row">
<div class="col-6">
    <label class="form-label">Start Date</label>
    <input type="date" name="start_date" value="{{ $d->start_date }}" class="form-control mb-2">
</div>
<div class="col-6">
    <label class="form-label">End Date</label>
    <input type="date" name="end_date" value="{{ $d->end_date }}" class="form-control mb-2">
</div>
</div>

<label class="form-label">Status</label>
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

<script>
// Show/hide discount % field based on offer type (UX only — server still validates)
function bindDealTypeToggle(selectId, fieldId) {
    const select = document.getElementById(selectId);
    const field = document.getElementById(fieldId);
    if (!select || !field) return;

    function toggle() {
        field.style.display = select.value === 'discount' ? 'block' : 'none';
    }

    select.addEventListener('change', toggle);
    toggle();
}

bindDealTypeToggle('get_type-add', 'discountField-add');
@foreach($deals as $d)
bindDealTypeToggle('get_type-edit{{ $d->id }}', 'discountField-edit{{ $d->id }}');
@endforeach
</script>

@endsection