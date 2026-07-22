<?php 
// app/Models/FaqQuery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqQuery extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'status'
    ];
}