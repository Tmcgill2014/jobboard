<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany('App\Comment', 'job_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

}
