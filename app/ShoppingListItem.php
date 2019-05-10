<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingListItem extends Model
{
    protected $table = 'shopping_list_items';
    public $timestamps = false;
}
