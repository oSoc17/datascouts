<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{

    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            // $table->increments('id');
            $table->primary('url');
            $table->string('name');
            $table->string('url');
            $table->string('image')->nullable();

            // Constraints declaration
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('entities');
    }
}