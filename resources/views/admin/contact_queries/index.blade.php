@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header d-flex justify-content-between align-items-center">
     <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Contact Queries</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">Contact Queries</li>
        </ul>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No.</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@forelse($queries as $q)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $q->name }}</td>
    <td>{{ $q->email }}</td>
    <td>{{ \Illuminate\Support\Str::limit($q->message, 100) }}</td>

    <td>
        <span class="badge {{ $q->status ? 'bg-success' : 'bg-warning' }}">
            {{ $q->status ? 'Read' : 'New' }}
        </span>
    </td>

    <td class="d-flex gap-2">

        {{-- MARK AS READ --}}
        @if(!$q->status && ($user->hasPermission('contact_queries.update') || $user->is_admin))
        <form method="POST" action="/admin/contact-queries/status/{{ $q->id }}">
            @csrf
            <button class="btn btn-sm btn-success">Mark Read</button>
        </form>
        @endif

        {{-- DELETE --}}
        @if($user->hasPermission('contact_queries.delete') || $user->is_admin)
        <form method="POST" action="/admin/contact-queries/delete/{{ $q->id }}" onsubmit="return confirm('Delete this query?');">
            @csrf
            <button class="btn btn-sm btn-danger">Delete</button>
        </form>
        @endif

    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">No queries found.</td>
</tr>
@endforelse
</tbody>
</table>

</div>
</div>

</div>
</main>

@endsection