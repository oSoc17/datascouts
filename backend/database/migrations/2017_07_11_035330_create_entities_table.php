<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{

    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            // $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('url')->unique();
            $table->string('image')->nullable();

            // F.K
            $table->uuid('user_uuid')->nullable();

            // Constraints declaration
            $table->timestamps();
            $table->primary('uuid');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('entities');
    }
}
