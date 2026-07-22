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
<div class="alert alert-success mt-2">{{ session('success') }}</div>
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
            <form action="/admin/weekly-deals/delete/{{ $d->id }}" method="POST">
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

<form method="POST" action="/admin/weekly-deals/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Add Weekly Deal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>

        <input type="text" name="discount" placeholder="Discount (UP TO 80%)" class="form-control mb-2">

        <input type="datetime-local" name="end_date" class="form-control mb-2">

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
@foreach($weeklyDeals as $d)
<div class="modal fade" id="edit{{ $d->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/weekly-deals/update/{{ $d->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">
    <div class="modal-header">
        <h5>Edit Deal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="title" value="{{ $d->title }}" class="form-control mb-2">

        <input type="text" name="discount" value="{{ $d->discount }}" class="form-control mb-2">

        <input type="datetime-local" name="end_date" value="{{ $d->end_date }}" class="form-control mb-2">

        <input type="file" name="image" class="form-control mb-2">

        @if($d->image)
        <img src="{{ asset('assets/images/banner/'.$d->image) }}" width="80">
        @endif

        <select name="status" class="form-control">
            <option value="1" {{ $d->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$d->status ? 'selected' : '' }}>Inactive</option>
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