<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $fillable = [
        'subtitle',
        'title',
        'description',
        'price',
        'button_text',
        'button_link',
        'image',
        'status'
    ];
}