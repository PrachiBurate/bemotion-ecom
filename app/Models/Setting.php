<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'site_name',
        'slogan',
        'logo',
        'contact_number',
        'email',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url'
    ];

    //   Optional: Get full logo path
    public function getLogoUrlAttribute()
    {
        return $this->logo 
            ? asset('assets/images/logo/' . $this->logo) 
            : asset('assets/images/logo/default.png');
    }
    
}