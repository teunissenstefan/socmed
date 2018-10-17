<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->tinyInteger('id')->unsigned()->unique();
            $table->string('gender',10)->unique();
        });

        DB::table('genders')->insert(array('id' => '1','gender' => 'Male'));
        DB::table('genders')->insert(array('id' => '2','gender' => 'Female'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}