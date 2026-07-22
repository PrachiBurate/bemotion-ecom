{{-- 
resources/views/admin/combos/index.blade.php
--}}
@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between">
    <h5>Combo Management</h5>
   @if($user->hasPermission('combos.create') || $user->is_admin)
    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addCombo">
        + Add Combo
    </button>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger mt-3">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card mt-3">
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

@forelse($combos as $combo)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($combo->image)
<img src="{{ asset('assets/images/combos/'.$combo->image) }}" width="70">
@endif
</td>

<td>{{ $combo->name }}</td>

<td>
@foreach($combo->items as $item)
<div>
{{ $item->product->name ?? '—' }}
(x{{ $item->quantity }})
</div>
@endforeach
</td>

<td>₹{{ number_format($combo->price, 2) }}</td>
<td>{{ $combo->offer_price !== null ? '₹'.number_format($combo->offer_price, 2) : '—' }}</td>

<td>
<span class="badge {{ $combo->status ? 'bg-success':'bg-danger' }}">
{{ $combo->status ? 'Active':'Inactive' }}
</span>
</td>

<td>
      @if($user->hasPermission('combos.edit') || $user->is_admin)
<button
    class="btn btn-warning btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#edit{{ $combo->id }}">
    Edit
</button>
@endif
  @if($user->hasPermission('combos.delete') || $user->is_admin)
<form action="/admin/combos/delete/{{ $combo->id }}"
method="POST"
class="d-inline"
onsubmit="return confirm('Delete this combo?');">

@csrf

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>
@endif
</td>

</tr>

@empty
<tr>
    <td colspan="8" class="text-center text-muted">No combos found.</td>
</tr>
@endforelse

</tbody>

</table>

</div>
</div>

</div>
</main>


<div class="modal fade" id="addCombo">
<div class="modal-dialog modal-xl">

<form method="POST"
action="/admin/combos/store"
enctype="multipart/form-data">

@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Add Combo</h5>
<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<label class="form-label">Combo Name</label>
<input type="text"
name="name"
class="form-control mb-1"
value="{{ old('name') }}"
placeholder="Combo Name">
@error('name')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Description</label>
<textarea
name="description"
class="form-control mb-3"
placeholder="Description">{{ old('description') }}</textarea>

<div class="row">
<div class="col-md-6">
<label class="form-label">Price</label>
<input type="number"
step="0.01" min="0"
name="price"
class="form-control mb-1"
value="{{ old('price') }}"
placeholder="Price">
@error('price')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label">Offer Price (optional)</label>
<input type="number"
step="0.01" min="0"
name="offer_price"
class="form-control mb-1"
value="{{ old('offer_price') }}"
placeholder="Offer Price">
@error('offer_price')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
</div>
</div>

<label class="form-label">Image (optional)</label>
<input type="file"
name="image"
class="form-control mb-1"
accept="image/png,image/jpeg,image/jpg,image/webp">
@error('image')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<label class="form-label">Status</label>
<select
name="status"
class="form-control mb-3">

<option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
<option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>

</select>

<hr>

<h5>Products</h5>
@error('products')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

<div id="productRows">

<div class="row productRow mb-2">

<div class="col-md-6">

<select
name="products[0][product_id]"
class="form-control">

<option value="">Select Product</option>

@foreach($products as $product)

<option value="{{ $product->id }}">
{{ $product->name }}
</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<input
type="number"
min="1"
name="products[0][quantity]"
class="form-control"
value="1">

</div>

<div class="col-md-3">

<button
type="button"
class="btn btn-danger removeRow">
Remove
</button>

</div>

</div>

</div>

<button
type="button"
id="addProduct"
class="btn btn-success mt-3">

+ Add Product

</button>

</div>

<div class="modal-footer">

<button class="btn btn-primary">
Save Combo
</button>

</div>

</div>

</form>

</div>
</div>
@foreach($combos as $combo)

<div class="modal fade" id="edit{{ $combo->id }}">
<div class="modal-dialog modal-xl">

<form method="POST"
      action="/admin/combos/update/{{ $combo->id }}"
      enctype="multipart/form-data">

@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Combo</h5>

<button type="button"
        class="btn-close"
        data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<label class="form-label">Combo Name</label>
<input
type="text"
name="name"
value="{{ $combo->name }}"
class="form-control mb-3"
placeholder="Combo Name">

<label class="form-label">Description</label>
<textarea
name="description"
class="form-control mb-3"
placeholder="Description">{{ $combo->description }}</textarea>

<div class="row">
<div class="col-md-6">
<label class="form-label">Price</label>
<input
type="number"
step="0.01" min="0"
name="price"
value="{{ $combo->price }}"
class="form-control mb-3"
placeholder="Price">
</div>
<div class="col-md-6">
<label class="form-label">Offer Price (optional)</label>
<input
type="number"
step="0.01" min="0"
name="offer_price"
value="{{ $combo->offer_price }}"
class="form-control mb-3"
placeholder="Offer Price">
</div>
</div>

<label class="form-label">Image (optional)</label>
<input
type="file"
name="image"
class="form-control mb-1"
accept="image/png,image/jpeg,image/jpg,image/webp">
<small class="text-muted d-block mb-3">Leave empty to keep the current image.</small>

@if($combo->image)

<img
src="{{ asset('assets/images/combos/'.$combo->image) }}"
width="100"
class="mb-3">

@endif

<label class="form-label">Status</label>
<select
name="status"
class="form-control mb-3">

<option value="1"
{{ $combo->status ? 'selected' : '' }}>
Active
</option>

<option value="0"
{{ !$combo->status ? 'selected' : '' }}>
Inactive
</option>

</select>

<hr>

<h5>Products</h5>

<div id="editProductRows{{ $combo->id }}">

@foreach($combo->items as $i=>$item)

<div class="row productRow mb-2">

<div class="col-md-6">

<select
name="products[{{ $i }}][product_id]"
class="form-control">

<option value="">Select Product</option>

@foreach($products as $product)

<option
value="{{ $product->id }}"
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
name="products[{{ $i }}][quantity]"
value="{{ $item->quantity }}">

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
class="btn btn-success addEditProduct mt-3"
data-target="{{ $combo->id }}">

+ Add Product

</button>

</div>

<div class="modal-footer">

<button class="btn btn-primary">

Update Combo

</button>

</div>

</div>

</form>

</div>
</div>

@endforeach

</div>
@endsection

@push('scripts')

<script>

let index=1;

document.getElementById('addProduct').onclick=function(){

let html=`<div class="row productRow mb-2">

<div class="col-md-6">

<select
name="products[${index}][product_id]"
class="form-control">

<option value="">Select Product</option>

@foreach($products as $product)

<option value="{{ $product->id }}">
{{ $product->name }}
</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<input
type="number"
min="1"
name="products[${index}][quantity]"
class="form-control"
value="1">

</div>

<div class="col-md-3">

<button
type="button"
class="btn btn-danger removeRow">

Remove

</button>

</div>

</div>`;

document.getElementById('productRows')
.insertAdjacentHTML('beforeend',html);

index++;

};

document.addEventListener('click',function(e){

if(e.target.classList.contains('removeRow')){

e.target.closest('.productRow').remove();

}

});

const products = @json(
    $products->map(function ($p) {
        return [
            'id' => $p->id,
            'name' => $p->name
        ];
    })->values()
);

document.addEventListener("click", function(e){

    if(e.target.classList.contains("addEditProduct")){

        let comboId = e.target.dataset.target;

        let container =
            document.getElementById("editProductRows"+comboId);

        let index =
            container.querySelectorAll(".productRow").length;

        let options =
            '<option value="">Select Product</option>';

        products.forEach(function(product){

            options +=
            `<option value="${product.id}">
                ${product.name}
            </option>`;

        });

        let html = `
        <div class="row productRow mb-2">

            <div class="col-md-6">

                <select
                name="products[${index}][product_id]"
                class="form-control">

                    ${options}

                </select>

            </div>

            <div class="col-md-3">

                <input
                type="number"
                min="1"
                name="products[${index}][quantity]"
                class="form-control"
                value="1">

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

        container.insertAdjacentHTML(
            "beforeend",
            html
        );

    }

});
</script>
@endpush