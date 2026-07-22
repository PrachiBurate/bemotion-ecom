@extends('admin.layouts.app')

@section('content')
@php $user = auth()->user(); @endphp

<main class="nxl-container">
    <div class="nxl-content">

        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Orders</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Orders
                    </li>
                </ol>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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

        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">All Orders</h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Order Status</th>
                                <th>Items</th>
                                <th>Date</th>
                                <th width="180">Update Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($orders as $order)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>

                                <td>
                                    <strong>{{ $order->name }}</strong><br>
                                    <small>{{ $order->email }}</small>
                                </td>

                                <td>{{ $order->phone }}</td>

                                <td>
                                    ₹{{ number_format($order->total,2) }}
                                </td>

                                <td>

                                    @if($order->payment_status=='paid')

                                        <span class="badge bg-success">
                                            Paid
                                        </span>

                                    @elseif($order->payment_status=='failed')

                                        <span class="badge bg-danger">
                                            Failed
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($order->order_status=='pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($order->order_status=='processing')

                                        <span class="badge bg-info">
                                            Processing
                                        </span>

                                    @elseif($order->order_status=='shipped')

                                        <span class="badge bg-primary">
                                            Shipped
                                        </span>

                                    @elseif($order->order_status=='delivered')

                                        <span class="badge bg-success">
                                            Delivered
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @foreach($order->items as $item)

                                        <div class="mb-2">

                                            <strong>
                                                {{ $item->product->name ?? 'Product Deleted' }}
                                            </strong>

                                            <br>

                                            Qty :
                                            {{ $item->quantity }}

                                            ×

                                            ₹{{ number_format($item->price,2) }}

                                        </div>

                                    @endforeach

                                </td>

                                <td>

                                    {{ $order->created_at->format('d M Y') }}

                                    <br>

                                    <small>
                                        {{ $order->created_at->format('h:i A') }}
                                    </small>

                                </td>

                                <td>
        @if($user->hasPermission('orders.update') || $user->is_admin)

                                    <form action="{{ url('/admin/orders/status/'.$order->id) }}"
                                          method="POST">

                                        @csrf

                                        <select
                                            class="form-select"
                                            name="status"
                                            onchange="this.form.submit()">

                                            <option value="pending"
                                                {{ $order->order_status=='pending'?'selected':'' }}>
                                                Pending
                                            </option>

                                            <option value="processing"
                                                {{ $order->order_status=='processing'?'selected':'' }}>
                                                Processing
                                            </option>

                                            <option value="shipped"
                                                {{ $order->order_status=='shipped'?'selected':'' }}>
                                                Shipped
                                            </option>

                                            <option value="delivered"
                                                {{ $order->order_status=='delivered'?'selected':'' }}>
                                                Delivered
                                            </option>

                                            <option value="cancelled"
                                                {{ $order->order_status=='cancelled'?'selected':'' }}>
                                                Cancelled
                                            </option>

                                        </select>

                                    </form>
@endif
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="text-center py-5">

                                    <h5>No Orders Found</h5>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</main>

@endsection