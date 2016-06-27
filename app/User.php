<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

public function job()
{
    return $this->hasMany('App\Job', 'author_id');
}

public function comments()
{
    return $this->hasMany('App\Comment', 'user_id');
}

public function can_post()
{
    $role = $this->role;
    if ($role == 'author'|| $role == 'admin')
    {
        return true;
    }
    return false;
}

    public function is_admin()
    {
        $role = $this->role;
        if ($role == 'admin')
        {
            return true;
        }
        return false;
    }
}
