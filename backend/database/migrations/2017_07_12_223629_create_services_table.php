<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{

    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            // $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('url');
            $table->string('logo');
            // Find Better way to store instead of string 
            // For the validation
            $table->string('color');


            // Constraints declaration
            $table->timestamps();
            $table->primary('uuid');
        });
    }

    public function down()
    {
        Schema::drop('services');
    }
}
