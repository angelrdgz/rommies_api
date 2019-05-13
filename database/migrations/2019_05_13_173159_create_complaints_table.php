<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('complaints')){
            Schema::create('complaints', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title', 100);
                $table->string('description', 250);
                $table->integer('user_id');
                $table->boolean('status')->default("0");
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
        Schema::dropIfExists('complaints');
    }
}
