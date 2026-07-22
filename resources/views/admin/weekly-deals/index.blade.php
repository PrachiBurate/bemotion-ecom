@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Weekly Deal Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Weekly Deal</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('weekly_deals.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeal">
            + Add Deal
        </button>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    <strong>Please fix the following:</strong>
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
    <th>Discount</th>
    <th>End Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($weeklyDeals as $d)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>
        @if($d->image)
        <img src="{{ asset('assets/images/banner/'.$d->image) }}" width="80">
        @endif
    </td>

    <td>{{ $d->title }}</td>
    <td>{{ $d->discount }}</td>
    <td>{{ $d->end_date }}</td>

    <td>
        <span class="badge {{ $d->status ? 'bg-success' : 'bg-danger' }}">
            {{ $d->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            @if($user->hasPermission('weekly_deals.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $d->id }}">
                Edit
            </button>
            @endif

            @if($user->hasPermission('weekly_deals.delete') || $user->is_admin)
            <form action="/admin/weekly-deals/delete/{{ $d->id }}" method="POST" onsubmit="return confirm('Delete this deal?');">
                @csrf
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

<!-- ADD MODAL -->
<div class="modal fade" id="addDeal">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/weekly-deals/store" enctype="multipart/form-data" novalidate>
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Add Weekly Deal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <div class="mb-2">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                placeholder="Title" class="form-control @error('title') is-invalid @enderror" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Discount</label>
            <input type="text" name="discount" value="{{ old('discount') }}"
                placeholder="Discount (UP TO 80%)" class="form-control @error('discount') is-invalid @enderror">
            @error('discount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">End Date</label>
            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                class="form-control @error('end_date') is-invalid @enderror">
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Image</label>
            <input type="file" name="image" accept="image/*"
                class="form-control @error('image') is-invalid @enderror" required>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-primary">Create</button>
    </div>
</div>

</form>
</div>
</div>

<!-- EDIT MODALS -->
@foreach($weeklyDeals as $d)
<div class="modal fade" id="edit{{ $d->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/weekly-deals/update/{{ $d->id }}" enctype="multipart/form-data" novalidate>
@csrf
<input type="hidden" name="_deal_id" value="{{ $d->id }}">

@php $isFailedEdit = old('_deal_id') == $d->id; @endphp

<div class="modal-content">
    <div class="modal-header">
        <h5>Edit Deal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <div class="mb-2">
            <label class="form-label">Title</label>
            <input type="text" name="title"
                value="{{ $isFailedEdit ? old('title') : $d->title }}"
                class="form-control @if($isFailedEdit) @error('title') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">Discount</label>
            <input type="text" name="discount"
                value="{{ $isFailedEdit ? old('discount') : $d->discount }}"
                class="form-control @if($isFailedEdit) @error('discount') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('discount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">End Date</label>
            <input type="datetime-local" name="end_date"
                value="{{ $isFailedEdit ? old('end_date') : $d->end_date }}"
                class="form-control @if($isFailedEdit) @error('end_date') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-2">
            <label class="form-label">Image (leave blank to keep current)</label>
            <input type="file" name="image" accept="image/*"
                class="form-control @if($isFailedEdit) @error('image') is-invalid @enderror @endif">
            @if($isFailedEdit)
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        @if($d->image)
        <img src="{{ asset('assets/images/banner/'.$d->image) }}" width="80" class="mb-2 d-block">
        @endif

        <div class="mb-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-control @if($isFailedEdit) @error('status') is-invalid @enderror @endif">
                <option value="1" {{ ($isFailedEdit ? old('status') : $d->status) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isFailedEdit ? old('status') : $d->status) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if($isFailedEdit)
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-success">Update</button>
    </div>

</div>

</form>
</div>
</div>
@endforeach

@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    var dealId = @json(old('_deal_id'));
    var modalId = dealId ? 'edit' + dealId : 'addDeal';
    var modalEl = document.getElementById(modalId);
    if (modalEl) {
        new bootstrap.Modal(modalEl).show();
    }
});
</script>
@endif

@endsection