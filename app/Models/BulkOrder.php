<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// app/Models/BulkOrder.php
class BulkOrder extends Model
{
    protected $fillable = ['name','email','phone','city','status'];
}