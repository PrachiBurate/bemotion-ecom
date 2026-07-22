<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/OfficeLocation.php
class OfficeLocation extends Model
{
    protected $fillable = [
        'title','address','phone1','phone2','email','status'
    ];
}