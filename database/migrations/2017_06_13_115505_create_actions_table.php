<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('complaint_id')->unsigned();
            $table->foreign('complaint_id')->references('id')->on('complaints');  
            $table->integer('action_type_id')->unsigned();
            $table->foreign('action_type_id')->references('id')->on('action_types');
            $table->text('text')->nullable();
            $table->dateTime('data')->nullable();  
            $table->dateTime('report')->nullable();    
            $table->dateTime('enable')->nullable();
            $table->integer('lpy_id')->unsigned()->nullable();
            $table->foreign('lpy_id')->references('id')->on('lpies');
            $table->text('history')->nullable();
            $table->string('money')->nullable();
            $table->integer('invoice_id')->nullable()->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices');        
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
        Schema::dropIfExists('actions');
    }
}
