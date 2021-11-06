<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role')->comment('1: Admin, 2: Member');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->date('entry_date')->nullable();
            $table->date('leave_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        \DB::table('users')->insert([
            ['role' => 1, 'name' => 'Mizanur Rahman', 'first_name' => 'Mizanur', 'last_name' => 'Rahman', 'email' => 'mizan.stack@gmail.com', 'password' => bcrypt(1234), 'entry_date' => '2022-10-28', 'leave_date' => null, 'created_at' => '2022-10-28 19:18:44', 'updated_at' => '2022-10-28 19:18:44', 'status' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
