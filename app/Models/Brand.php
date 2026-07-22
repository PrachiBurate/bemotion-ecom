<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Brand.php
class Brand extends Model
{
    protected $fillable = ['name','logo','status'];
}