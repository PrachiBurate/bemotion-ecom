<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyDeal extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'discount',
        'end_date',
        'image',
        'status'
    ];
}