@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div class="page-header-left">
        <h5>Bulk Orders</h5>
    </div>
</div>

{{-- SUCCESS --}}
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
<th>No.</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>City</th>
<th>Message</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($orders as $o)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $o->name }}</td>
<td>{{ $o->email }}</td>
<td>{{ $o->phone }}</td>
<td>{{ $o->city }}</td>
<td>{{ $o->message }}</td>

<td>
<span class="badge {{ $o->status ? 'bg-success' : 'bg-warning' }}">
{{ $o->status ? 'Processed' : 'New' }}
</span>
</td>

<td class="d-flex gap-2">

{{-- MARK AS PROCESSED --}}
@if(!$o->status && ($user->hasPermission('bulk_orders.update') || $user->is_admin))
<form method="POST" action="/admin/bulk-orders/status/{{ $o->id }}">
@csrf
<button class="btn btn-success btn-sm">Mark Done</button>
</form>
@endif

{{-- DELETE --}}
@if($user->hasPermission('bulk_orders.delete') || $user->is_admin)
<form method="POST" action="/admin/bulk-orders/delete/{{ $o->id }}">
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

@endsection