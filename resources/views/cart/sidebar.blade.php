<div class="cart-body">

    <ul class="pesco-mini-cart-list">

    @foreach($cart as $item)

    <li class="sidebar-cart-item">

        <a href="#">

            <img src="{{ asset('assets/images/products/'.$item->product->image) }}">

            {{ $item->product->name }}

        </a>

        <div class="d-flex justify-content-between align-items-center mt-2">

            <div class="cart-qty">

                <button class="qtyMinus" data-id="{{ $item->id }}">-</button>

                <span class="mx-2">{{ $item->quantity }}</span>

                <button class="qtyPlus" data-id="{{ $item->id }}">+</button>

            </div>

            <div>
                ₹{{ number_format($item->price * $item->quantity,2) }}
            </div>

        </div>

        <a href="javascript:void(0)"
           class="removeCart text-danger"
           data-id="{{ $item->id }}">
            <i class="far fa-trash-alt"></i>
        </a>

    </li>

    @endforeach

    </ul>

</div>

<div class="cart-footer">

    <div class="cart-mini-total">

        <div class="cart-total">

            <strong>Subtotal :</strong>

            ₹{{ number_format($subtotal,2) }}

        </div>

    </div>

    <div class="cart-button-box">
       @if(Auth::guard('customer')->check())

<a href="/checkout" class="theme-btn style-one">
    Proceed To Checkout
</a>

@else

<a href="/login" class="theme-btn style-one">
    Login To Checkout
</a>

@endif
    </div>

</div>