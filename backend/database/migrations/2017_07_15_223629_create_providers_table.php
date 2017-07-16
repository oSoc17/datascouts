<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{

    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');

            // Constraints declaration
            $table->timestamps();

            // F.K
            $table->integer('service_id')->unsigned()->index();
            $table->integer('provider_id')->unsigned()->index();

        });
    }

    public function down()
    {
        Schema::drop('providers');
    }
}
