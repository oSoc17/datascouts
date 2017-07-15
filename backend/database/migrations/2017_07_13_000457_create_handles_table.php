<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandlesTable extends Migration
{

    public function up()
    {
        Schema::create('handles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url')->unique();

            // Constraints declaration
            $table->timestamps();

            // F.K
            $table->integer('entity_id')->unsigned()->index()->nullable();
            $table->integer('provider_id')->unsigned()->index()->nullable();
            $table->integer('service_id')->unsigned()->index()->nullable();
        //     $table->foreign('provider_id')
        //         ->references('id')
        //         ->on('providers');
        });

        Schema::table('handles', function (Blueprint $table){
            $table->boolean('is_fetching')->default(false);
            $table->timestamp('fetched_at')->useCurrent();	

        });


    }

    public function down()
    {
        Schema::drop('handles');
    }
}
