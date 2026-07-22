<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
 protected $fillable = [
    'title',
    'subtitle',
    'description',
    'experience_year',
    'image1',
    'image2',
    'thumb1',
    'thumb2',
    'list1',
    'list2',
    'list3',
    'author_name',
    'author_position',
    'author_image',
    'signature',
    'divider_image',
    'status'
];
}