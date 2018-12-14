<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('send_from')->unsigned();
            $table->integer('send_to')->unsigned();
            $table->text('message');
            $table->string('subject');
            $table->boolean('read')->default(0);
            $table->timestamps();

            $table->foreign('send_from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('send_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
