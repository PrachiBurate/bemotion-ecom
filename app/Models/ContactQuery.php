<?php 
// app/Models/FaqQuery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


// app/Models/ContactQuery.php
class ContactQuery extends Model
{
    protected $fillable = ['name','email','message','status'];
}

