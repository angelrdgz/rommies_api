<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShoppingListTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('shopping_list_types')){
            Schema::create('shopping_list_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('image');
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
        Schema::dropIfExists('table_shopping_list_types');
    }
}
