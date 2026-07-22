<?php 
// app/Models/Testimonial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'image',
        'message',
        'rating',
        'status'
    ];
}