<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFetchersTable extends Migration
{

    public function up()
    {
        Schema::create('fetches', function(Blueprint $table) {
            $table->increments('id');
            // No Support yet for type JSON
            $table->mediumText('data');

            $table->string('medium_id')
                    ->index()
                    ->nullable();

            
            // F.K
            $table->integer('handle_id')->unsigned();

            // Constraints declaration
            $table->timestamps();

        });


    }

    public function down()
    {
        Schema::drop('fetches');
    }
}
