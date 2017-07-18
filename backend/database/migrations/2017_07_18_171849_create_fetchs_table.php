<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFetchsTable extends Migration
{

    public function up()
    {
        Schema::create('fetchs', function(Blueprint $table) {
            $table->increments('id');
            $table->json('data');
            $table->integer('handle_id')->unsigned();

            // Constraints declaration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('fetchs');
    }
}
