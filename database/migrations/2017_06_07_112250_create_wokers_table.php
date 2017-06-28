<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWokersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fam');
            $table->string('name');
            $table->string('ot');
            $table->integer('parent')->unsigned()->nullable();
            $table->foreign('parent')->references('id')->on('workers');
            $table->integer('firm')->unsigned()->nullable();
            $table->foreign('firm')->references('id')->on('firms');
            $table->integer('firm_1c')->unsigned()->nullable();
            $table->foreign('firm_1c')->references('id')->on('firms');
            $table->string('dolgn')->nullable();
            $table->string('dolgn_1c')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('status_1c_id')->unsigned()->nullable();
            $table->foreign('status_1c_id')->references('id')->on('statuses');
            $table->dateTime('last_recourse')->nullable();
            $table->date('data_rogd');
            $table->date('data_prinyat')->nullable();
            $table->date('data_prinyat_1c')->nullable();
            $table->date('data_yvolen')->nullable();
            $table->text('adress_propiski')->nullable();
            $table->text('adress_propiski_1c')->nullable();
            $table->text('adress')->nullable();
            $table->text('adress_1c')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_1c')->nullable();
            $table->string('poliklinika')->nullable();
            $table->string('poliklinika_1c')->nullable();
            $table->text('prim')->nullable();
            $table->text('prim_ok')->nullable();
            $table->text('find_xesh')->nullable();
            $table->text('history')->nullable();
            $table->string('otkaz')->nullable();
            $table->text('obnov')->nullable();
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
        Schema::dropIfExists('wokers');
    }
}
