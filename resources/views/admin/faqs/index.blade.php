@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- ================= HEADER ================= -->
<div class="page-header d-flex justify-content-between align-items-center">
    
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">FAQ Management</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">FAQ Management</li>
        </ul>
    </div>

    <div class="page-header-right-items">
        @if($user->hasPermission('faqs.create') || $user->is_admin)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaq">
            + Add FAQ
        </button>
        @endif
    </div>

</div>

<!-- ================= SUCCESS MESSAGE ================= -->
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<!-- ================= TABLE CARD ================= -->
<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No.</th>
    <th>Question</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($faqs as $faq)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $faq->question }}</td>

    <td>
        <span class="badge {{ $faq->status ? 'bg-success' : 'bg-danger' }}">
            {{ $faq->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        <div class="d-flex gap-2">

            {{-- EDIT --}}
            @if($user->hasPermission('faqs.edit') || $user->is_admin)
            <button class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#edit{{ $faq->id }}">
                Edit
            </button>
            @endif

            {{-- DELETE --}}
            @if($user->hasPermission('faqs.delete') || $user->is_admin)
            <form action="/faqs/delete/{{ $faq->id }}" method="POST">
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

<!-- ================= ADD FAQ MODAL ================= -->
<div class="modal fade" id="addFaq">
<div class="modal-dialog">

<form method="POST" action="/faqs/store">
@csrf

<div class="modal-content">

    <div class="modal-header">
        <h5>Add FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="question"
            class="form-control mb-2"
            placeholder="Question" required>

        <textarea name="answer"
            class="form-control mb-2"
            placeholder="Answer" required></textarea>

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

{{-- ================= EDIT MODALS OUTSIDE TABLE ================= --}}
@foreach($faqs as $faq)
<div class="modal fade" id="edit{{ $faq->id }}">
<div class="modal-dialog">
<form method="POST" action="/faqs/update/{{ $faq->id }}">
@csrf

<div class="modal-content">

    <div class="modal-header">
        <h5>Edit FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="question"
            value="{{ $faq->question }}"
            class="form-control mb-2"
            placeholder="Question" required>

        <textarea name="answer"
            class="form-control mb-2"
            placeholder="Answer" required>{{ $faq->answer }}</textarea>

        <select name="status" class="form-control">
            <option value="1" {{ $faq->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$faq->status ? 'selected' : '' }}>Inactive</option>
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