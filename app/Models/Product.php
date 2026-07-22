<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
    'category_id',
    'subcategory_id',
    'brand_id',
    'name',
    'slug',
    'description',
    'price',
    'sale_price',
    'image',
    'stock',
    'status',
    'quantity',
    'stock_status',
    'is_featured',
    'is_trending'
];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}