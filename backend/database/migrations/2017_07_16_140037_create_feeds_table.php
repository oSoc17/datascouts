<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{

    public function up()
    {
        Schema::create('feeds', function(Blueprint $table) {
            $table->increments('id');
            // No Support yet for type JSON
            $table->mediumText('data');

            $table->string('medium_id')
                    ->index()
                    ->nullable();

            
            // F.K
            $table->unsignedInteger('handle_id');

            // Constraints declaration
            $table->timestamps();

        });


    }

    public function down()
    {
        Schema::drop('feeds');
    }
}
