<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{

    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('link')->unique();
            $table->string('logo')->nullable();
            // Find Better way to store instead of string 
            // For the validation
            $table->string('color')->nullable();

            // Constraints declaration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('services');
    }
}
