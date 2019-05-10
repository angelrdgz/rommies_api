<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAssigned extends Model
{
    protected $table = 'task_assigned';

    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function task(){
    	return $this->belongsTo('App\Task')->where('completed', 0);
    }
}
