@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Blogs Management</h5>
        </div>

        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Blogs</li>
        </ul>
    </div>

    @if($user->hasPermission('blogs.create') || $user->is_admin)
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlog">
        + Add Blog
    </button>
    @endif

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
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($blogs as $blog)
<tr>
<td>{{ $loop->iteration }}</td>

<td>
@if($blog->image)
<img src="{{ asset('assets/images/blog/'.$blog->image) }}" width="80">
@endif
</td>

<td>{{ $blog->title }}</td>

<td>
<span class="badge {{ $blog->status ? 'bg-success' : 'bg-danger' }}">
{{ $blog->status ? 'Active' : 'Inactive' }}
</span>
</td>

<td class="d-flex gap-2">

{{-- EDIT --}}
@if($user->hasPermission('blogs.edit') || $user->is_admin)
<button class="btn btn-warning btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#edit{{ $blog->id }}">
    Edit
</button>
@endif

{{-- DELETE --}}
@if($user->hasPermission('blogs.delete') || $user->is_admin)
<form action="/blogs/delete/{{ $blog->id }}" method="POST">
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

<!-- ================= ADD MODAL ================= -->
@if($user->hasPermission('blogs.create') || $user->is_admin)
<div class="modal fade" id="addBlog">
<div class="modal-dialog modal-lg">

<form method="POST" action="/blogs/store" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Add Blog</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="title" placeholder="Title" class="form-control mb-2" required>

<textarea name="content" id="addEditor" class="form-control"></textarea>

<input type="file" name="image" class="form-control mb-2" required>

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
@endif

<!-- ================= EDIT MODALS ================= -->
@foreach($blogs as $blog)

@if($user->hasPermission('blogs.edit') || $user->is_admin)

<div class="modal fade" id="edit{{ $blog->id }}">
<div class="modal-dialog modal-lg">

<form method="POST" action="/blogs/update/{{ $blog->id }}" enctype="multipart/form-data">
@csrf

<div class="modal-content">

<div class="modal-header">
<h5>Edit Blog</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="title" value="{{ $blog->title }}" class="form-control mb-2" required>

<textarea name="content"
    id="editor{{ $blog->id }}"
    class="form-control">{{ $blog->content }}</textarea>

<input type="file" name="image" class="form-control mb-2">

@if($blog->image)
<img src="{{ asset('assets/images/blog/'.$blog->image) }}" width="100" class="mb-2">
@endif

<select name="status" class="form-control">
<option value="1" {{ $blog->status ? 'selected' : '' }}>Active</option>
<option value="0" {{ !$blog->status ? 'selected' : '' }}>Inactive</option>
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

<!-- ================= CKEDITOR ================= -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
// Add Editor
ClassicEditor.create(document.querySelector('#addEditor'), {
    ckfinder: {
        uploadUrl: "{{ url('admin/blogs/upload-image') }}?_token={{ csrf_token() }}"
    }
});

// Edit Editors
@foreach($blogs as $blog)
ClassicEditor.create(document.querySelector('#editor{{ $blog->id }}'), {
    ckfinder: {
        uploadUrl: "{{ url('admin/blogs/upload-image') }}?_token={{ csrf_token() }}"
    }
});
@endforeach
</script>
@endsection