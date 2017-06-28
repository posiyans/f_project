<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('worker_id')->unsigned()->nullable();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->integer('med_actions_id')->unsigned()->nullable();
            //$table->foreign('med_actions_id')->references('id')->on('med_actions_id');
            $table->integer('med_diagnosis_id')->unsigned()->nullable();
            //$table->foreign('med_diagnosis_id')->references('id')->on('med_diagnosis_id');
            $table->integer('med_invoice_id')->unsigned()->nullable();
            //$table->foreign('med_invoice_id')->references('id')->on('med_invoice');
            $table->string('md5');
            $table->text('name');
            $table->text('full_name')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
}
