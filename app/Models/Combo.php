<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Combo extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'price',
        'offer_price',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(ComboItem::class);
    }
}