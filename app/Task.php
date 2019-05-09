<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function roomies(){
    	return $this->hasMany('App\TaskAssigned');
    }
}
