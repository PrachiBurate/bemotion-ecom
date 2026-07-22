<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Subcategory.php
class Subcategory extends Model
{
 protected $fillable = ['category_id','name','image','status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}