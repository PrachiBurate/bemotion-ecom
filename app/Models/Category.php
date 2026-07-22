<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// app/Models/Category.php
class Category extends Model
{
protected $fillable = ['name','image','status'];

  public function subcategories()
{
    return $this->hasMany(Subcategory::class, 'category_id');
}
}