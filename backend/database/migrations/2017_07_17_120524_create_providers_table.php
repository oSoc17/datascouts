<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{

    public function up()
    {
        Schema::create('providers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('medium_id');
            $table->text('token');
            $table->string('email');
            $table->string('nickname')->nullable();
            $table->string('fullname')->nullable();
            $table->string('avatar')->nullable();
            
            // F.K
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('service_id');
            
            // Constraints declaration
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::drop('providers');
    }
}
