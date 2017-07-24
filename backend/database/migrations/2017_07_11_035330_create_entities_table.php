<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{

    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url')->unique();
            $table->string('image')->nullable();

            // Constraints declaration
            $table->timestamps();
    
            // F.K
            
        });


    }

    public function down()
    {
        Schema::drop('entities');
    }
}
