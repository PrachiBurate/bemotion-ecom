<?php 

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'role_id',
        'status',
        'phone',
        'profile_image',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'status' => 'boolean',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

  public function role()
{
    return $this->belongsTo(Role::class);
}

public function hasPermission($slug)
{
    if ($this->is_admin == 1) {
        return true;
    }

    if (!$this->role) {
        return false;
    }

    //   FORCE LOAD (IMPORTANT FIX)
    $permissions = $this->role->permissions()->get();

    return $permissions->contains('slug', $slug);
}
}