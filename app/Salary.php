<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salary extends Model

{
	$salary = 0;

    public function pay()
    {
    	return $this->belongsTo('App\Job', 'job_id');
    }

}
