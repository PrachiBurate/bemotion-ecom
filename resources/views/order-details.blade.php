@extends('layouts.app')

@section('content')

<section class="pt-120 pb-120">

<div class="container">

<h2>

Order Details

</h2>

<hr>

<div class="row mb-5">

<div class="col-md-6">

<h5>Order Number</h5>

{{ $order->order_number }}

</div>

<div class="col-md-6">

<h5>Status</h5>

{{ ucfirst($order->order_status) }}

</div>

</div>

<table class="table table-bordered">

<thead>

<tr>

<th>Product</th>

<th>Image</th>

<th>Price</th>

<th>Qty</th>

<th>Total</th>

</tr>

</thead>

<tbody>

@foreach($order->items as $item)

<tr>

<td>

{{ $item->product->name }}

</td>

<td>

<img
src="{{ asset('assets/images/products/'.$item->product->image) }}"
width="80">

</td>

<td>

₹{{ number_format($item->price,2) }}

</td>

<td>

{{ $item->quantity }}

</td>

<td>

₹{{ number_format($item->total,2) }}

</td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

<th colspan="4">

Grand Total

</th>

<th>

₹{{ number_format($order->total,2) }}

</th>

</tr>

</tfoot>

</table>

<a href="{{ route('my.orders') }}"
class="theme-btn style-one">

Back

</a>

</div>

</section>

@endsection