<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
    'product_id',
    'title',
    'buy_quantity',
    'get_quantity',
    'get_type',
    'discount_percent',
    'max_free_qty',
    'start_date',
    'end_date',
    'status',
    'image' // 👈 ADD THIS
];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}