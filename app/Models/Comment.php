<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'blog_id',
        'name',
        'email',
        'message'
    ];
    public function blog()
{
    return $this->belongsTo(\App\Models\Blog::class);
}
}