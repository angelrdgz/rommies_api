<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('complaint_comments')){
            Schema::create('complaint_comments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('complaint_id');
                $table->integer('user_id');
                $table->string('comment');
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
        Schema::dropIfExists('complaint_comments');
    }
}
