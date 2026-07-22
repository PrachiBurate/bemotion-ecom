@extends('layouts.app')

@section('content')

<section class="pt-120 pb-120">

<div class="container">

<div class="text-center">

<h2 class="text-success mb-4">
Order Placed Successfully 🎉
</h2>

<p>
Thank you for your order.
</p>

<h5>
Order Number :
<strong>{{ $order->order_number }}</strong>
</h5>

<h4 class="mt-4">

Total :
₹{{ number_format($order->total,2) }}

</h4>

<div class="mt-4">

<a href="{{ url('/shops') }}" class="theme-btn style-one">
Continue Shopping
</a>

<a href="{{ route('my.orders') }}" class="theme-btn style-one">
My Orders
</a>

</div>

</div>

</div>

</section>

@endsection