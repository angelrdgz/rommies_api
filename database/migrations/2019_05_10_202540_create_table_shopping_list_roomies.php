<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShoppingListRoomies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('shopping_list_roomies')){
            Schema::create('shopping_list_roomies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('shopping_list_id');
                $table->integer('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_shopping_list_roomies');
    }
}
