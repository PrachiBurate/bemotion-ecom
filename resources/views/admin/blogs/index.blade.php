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
<div class="alert alert-success mt-2">
    {{ session('success') }}
</div>
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
<button
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this blog?')">
Delete
</button>
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

<input
type="text"
name="title"
class="form-control mb-2"
placeholder="Blog Title"
required
minlength="5"
maxlength="255"
pattern="^(?! )[A-Za-z0-9\s&(),.'\-]+$"
title="Minimum 5 characters. Special characters are limited."
autocomplete="off">

<div class="invalid-feedback">
Please enter a valid blog title.
</div>

<textarea name="content" id="addEditor" class="form-control"></textarea>

<small class="text-danger d-none" id="contentError">
Blog content is required.
</small>

<input
type="file"
name="image"
id="blogImage"
class="form-control mb-2"
accept=".jpg,.jpeg,.png,.webp"
required>

<div class="invalid-feedback">
Upload JPG, PNG or WEBP image (Maximum 2MB).
</div>

<img
id="previewImage"
src=""
class="img-thumbnail mt-2 d-none"
width="150">
<select
name="status"
class="form-control"
required>

<option value="">Select Status</option>
<option value="1">Active</option>
<option value="0">Inactive</option>

</select>

<div class="invalid-feedback">
Please select status.
</div>

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
    document.querySelectorAll("form").forEach(form=>{

form.addEventListener("submit",function(){

const btn=this.querySelector("button[type='submit'],button:not([type])");

if(btn){

btn.disabled=true;

btn.innerHTML="Please Wait...";

}

});

});

document.querySelectorAll("input[type=file]").forEach(input=>{

input.addEventListener("change",function(){

const file=this.files[0];

if(!file) return;

const allowed=['image/jpeg','image/png','image/webp'];

if(!allowed.includes(file.type)){

alert("Only JPG, PNG and WEBP images are allowed.");

this.value='';

return;

}

if(file.size>2*1024*1024){

alert("Image size must be less than 2 MB.");

this.value='';

return;

}

});

});

const image=document.getElementById('blogImage');

if(image){

image.addEventListener('change',function(){

const file=this.files[0];

if(file){

const preview=document.getElementById('previewImage');

preview.src=URL.createObjectURL(file);

preview.classList.remove('d-none');

}

});

}
document.querySelectorAll("input[type=text]").forEach(input=>{

input.addEventListener("input",function(){

this.value=this.value.replace(/^\s+/,"");

});

});

document.querySelectorAll("input[type=text]").forEach(input=>{

input.addEventListener("blur",function(){

this.value=this.value.trim().replace(/\s+/g," ");

});

});
// Add Editor
let addEditor;

ClassicEditor
.create(document.querySelector('#addEditor'),{

ckfinder:{
uploadUrl:"{{ url('admin/blogs/upload-image') }}?_token={{ csrf_token() }}"
}

})

.then(editor=>{

addEditor=editor;

});
document.querySelector('#addBlog form').addEventListener('submit',function(e){

const text=addEditor.getData().replace(/<[^>]*>/g,'').trim();

if(text===''){

e.preventDefault();

document.getElementById('contentError').classList.remove('d-none');

return false;

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