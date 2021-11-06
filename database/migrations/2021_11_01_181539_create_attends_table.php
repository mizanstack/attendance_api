<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->string('start_work_time')->nullable();
            $table->string('end_work_time')->nullable();
            $table->string('start_break_time')->nullable();
            $table->string('end_break_time')->nullable();
            $table->string('memo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attends');
    }
}
