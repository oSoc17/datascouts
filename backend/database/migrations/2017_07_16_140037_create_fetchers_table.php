<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFetchersTable extends Migration
{

    public function up()
    {
        Schema::create('fetchers', function(Blueprint $table) {
            $table->increments('id');
            $table->json('data');

            // Constraints declaration
            $table->timestamps();

            // F.K
            $table->integer('handle_id')->unsigned()->index()->nullable();
        });


    }

    public function down()
    {
        Schema::drop('fetchers');
    }
}
