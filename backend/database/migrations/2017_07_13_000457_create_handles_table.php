<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandlesTable extends Migration
{

    public function up()
    {
        Schema::create('handles', function(Blueprint $table) {
            // $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('url')->unique();
            $table->uuid('provider_uuid');
            $table->uuid('service_uuid');
            
            // Constraints declaration
            $table->timestamps();
            $table->primary('uuid');
        //     $table->foreign('provider_uuid')
        //         ->references('uuid')
        //         ->on('providers');
        });

        // Schema::tables('handles', function(Blueprint $table) {
        //     $table->foreign('provider_uuid')
        //         ->references('id')
        //         ->on('providers');
        // });
    }

    public function down()
    {
        Schema::drop('handles');
    }
}
