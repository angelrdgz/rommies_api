<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('task_assigned')){
            Schema::create('task_assigned', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('task_id');
                $table->integer('user_id');
            });
        }
    }

    /**|
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_assigned');
    }
}
