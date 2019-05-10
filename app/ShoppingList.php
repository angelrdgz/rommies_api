<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    public function roomies(){
    	return $this->hasMany('App\ShoppingListRoomie');
    }

    public function items(){
    	return $this->hasMany('App\ShoppingListItem');
    }

    public function type(){
    	return $this->belongsTo('App\ShoppingListType');
    }
}
