@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<div class="page-header">
   <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Blog Comments</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Blog Comments</li>
                    </ul>
                </div>
    
   
</div>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>
@endif
<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No</th>
    <th>Blog</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($comments as $comment)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $comment->blog->title ?? 'N/A' }}</td>

    <td>{{ $comment->name }}</td>

    <td>{{ $comment->email }}</td>

    <td style="max-width:250px;">
        {{ \Illuminate\Support\Str::limit($comment->message, 50) }}
    </td>

    <td>
        <span class="badge {{ $comment->status ? 'bg-success' : 'bg-danger' }}">
            {{ $comment->status ? 'Approved' : 'Pending' }}
        </span>
    </td>

    <td class="d-flex gap-2">

        {{-- STATUS --}}
        @if($user->hasPermission('comments.edit') || $user->is_admin)
        <form action="/blog-comments/status/{{ $comment->id }}" method="POST">
            @csrf
           <button
    class="btn btn-sm btn-info"
    onclick="return confirm('Are you want to change the comment status?')">
    {{ $comment->status ? 'Disable' : 'Approve' }}
</button>
        </form>
        @endif

        {{-- DELETE --}}
        @if($user->hasPermission('comments.delete') || $user->is_admin)
        <form action="/blog-comments/delete/{{ $comment->id }}" method="POST">
            @csrf
          <button
    class="btn btn-sm btn-danger"
    onclick="return confirm('Are you sure you want to delete this comment?')">
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
<script>
document.querySelectorAll("form").forEach(form => {

    form.addEventListener("submit", function () {

        let btn = this.querySelector("button");

        if(btn){

            btn.disabled = true;

            btn.innerHTML = "Please Wait...";

        }

    });

});
</script>
@endsection