<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'offer_price',
        'status'
    ];

   public function items()
{
    return $this->hasMany(BundleItem::class, 'bundle_id');
}
}