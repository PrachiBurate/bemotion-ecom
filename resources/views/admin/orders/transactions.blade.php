@extends('admin.layouts.app')

@section('content')

@php $user = auth()->user(); @endphp

<main class="nxl-container">
<div class="nxl-content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">

    <div class="page-header-left">
        <h5 class="m-b-10">Transactions</h5>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Transactions</li>
        </ul>
    </div>

</div>

<div class="card mt-3">
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
<th>No.</th>
<th>Order</th>
<th>Amount</th>
<th>Method</th>
<th>Transaction ID</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@foreach($transactions as $t)
<tr>

<td>{{ $loop->iteration }}</td>

<td>#{{ $t->order_id }}</td>

<td>₹{{ $t->amount }}</td>

<td>{{ strtoupper($t->payment_method) }}</td>

<td>{{ $t->transaction_id ?? '-' }}</td>

<td>
<span class="badge {{ $t->status=='success'?'bg-success':'bg-danger' }}">
{{ ucfirst($t->status) }}
</span>
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