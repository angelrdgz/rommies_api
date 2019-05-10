<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShoppingListItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('shopping_list_items')){
            Schema::create('shopping_list_items', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('shopping_list_id');
                $table->string('name', 150);
                $table->decimal('quantity', 5,2);
                $table->decimal('price', 8,2);
                $table->boolean('checked')->default('0');
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
        Schema::dropIfExists('table_shopping_list_items');
    }
}
