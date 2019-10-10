<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SpecifiedFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('specifiedFiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('File_Id')->unsigned();   
            $table->foreign('File_Id')->references('id')->on('files');
            $table->integer('owner_id')->unsigned();               
            $table->foreign('owner_id')->references('id')->on('users');
            $table->integer('receiver_id')->unsigned();               
            $table->foreign('receiver_id')->references('id')->on('users');
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
        //
                        Schema::dropIfExists('specifiedFiles');

    }
}
