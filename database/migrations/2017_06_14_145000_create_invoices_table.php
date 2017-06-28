<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomber');
            $table->integer('lpy_id')->unsigned();
            $table->foreign('lpy_id')->references('id')->on('lpies');
            $table->string('symma')->nullable();
            $table->integer('type')->nullable();
            $table->integer('platit')->nullable();
            $table->date('sz')->nullable();
            $table->string('plateshka')->nullable();
            $table->date('plateshka_data')->nullable();
            $table->text('prim')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
