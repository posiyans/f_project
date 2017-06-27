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
            $table->string('name');
            $table->string('login')->unique();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('telegram')->nullable();
            $table->string('password');
            $table->integer('firm_id')->unsigned();
            $table->foreign('firm_id')->references('id')->on('firms');
            $table->dateTime('last_conect')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->string('api_token',60)->unique();
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
        Schema::dropIfExists('users');
    }
}
