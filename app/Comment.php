<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    
    public function job()
    {
        return $this->belongsTo('App\Job', 'job_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
