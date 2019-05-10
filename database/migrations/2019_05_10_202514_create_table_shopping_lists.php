<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShoppingLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('shopping_lists')){
            Schema::create('shopping_lists', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 50);
                $table->integer('type_id');
                $table->boolean('completed')->default('0');
                $table->timestamps();
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
        Schema::dropIfExists('table_shopping_lists');
    }
}
