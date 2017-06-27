<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMkbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mkbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_klass');
            $table->text('klass');
            $table->string('nom_block');
            $table->text('block');
            $table->string('nom_kode');
            $table->text('kode');
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
        Schema::dropIfExists('mkbs');
    }
}
