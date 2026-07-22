@extends('layouts.app')

@section('content')

<section class="pt-120 pb-120">

<div class="container">

<h2 class="mb-4">
My Orders
</h2>

<table class="table table-bordered">

<thead>

<tr>

<th>#</th>

<th>Order No</th>

<th>Total</th>

<th>Payment</th>

<th>Status</th>

<th>Date</th>

<th></th>

</tr>

</thead>

<tbody>

@forelse($orders as $order)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $order->order_number }}</td>

<td>
₹{{ number_format($order->total,2) }}
</td>

<td>

<span class="badge bg-warning">
{{ ucfirst($order->payment_status) }}
</span>

</td>

<td>

<span class="badge bg-info">
{{ ucfirst($order->order_status) }}
</span>

</td>

<td>

{{ $order->created_at->format('d M Y') }}

</td>

<td>

<a href="{{ route('order.details',$order->id) }}"
class="btn btn-sm btn-primary">

View

</a>

</td>

</tr>

@empty

<tr>

<td colspan="7">

No Orders Found.

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $orders->links() }}

</div>

</section>

@endsection