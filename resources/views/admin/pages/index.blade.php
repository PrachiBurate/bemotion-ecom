@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Pages Management</h5>
        </div>

        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
        </ul>
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
    <th>Title</th>
    <th>Slug</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($pages as $p)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $p->title }}</td>

    <td>{{ $p->slug }}</td>

    <td>
        <span class="badge {{ $p->status ? 'bg-success' : 'bg-danger' }}">
            {{ $p->status ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <td>
        @if($user->hasPermission('pages.edit') || $user->is_admin)
        <button class="btn btn-warning btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#edit{{ $p->id }}">
            Edit
        </button>
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

<!-- ================= EDIT MODALS ================= -->
@foreach($pages as $p)

@if($user->hasPermission('pages.edit') || $user->is_admin)

<div class="modal fade" id="edit{{ $p->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/admin/pages/update/{{ $p->id }}">
@csrf

<div class="modal-content">

    <div class="modal-header">
        <h5>Edit {{ $p->title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="text" name="title" value="{{ $p->title }}" class="form-control mb-2" required>

        {{-- 🔒 SLUG READONLY --}}
        <input type="text" name="slug" value="{{ $p->slug }}" class="form-control mb-2" readonly>

 <textarea name="content"
    id="editor{{ $p->id }}"
    class="form-control">{{ old('content', $p->content) }}</textarea>

        <select name="status" class="form-control">
            <option value="1" {{ $p->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$p->status ? 'selected' : '' }}>Inactive</option>
        </select>

    </div>

    <div class="modal-footer">
        <button class="btn btn-success">Update</button>
    </div>

</div>

</form>
</div>
</div>

@endif
@endforeach

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
@foreach($pages as $p)
ClassicEditor.create(document.querySelector('#editor{{ $p->id }}'), {
    ckfinder: {
        uploadUrl: "{{ url('admin/pages/upload-image') }}?_token={{ csrf_token() }}"
    }
});
@endforeach
</script>

@endsection