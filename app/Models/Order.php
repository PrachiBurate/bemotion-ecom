<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'order_number',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'payment_method',
        'payment_status',
        'order_status',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
    ];

    /**
     * Customer
     */
   public function items()
{
    return $this->hasMany(OrderItem::class);
}

public function transaction()
{
    return $this->hasOne(Transaction::class);
}

public function customer()
{
    return $this->belongsTo(Customer::class);
}
}