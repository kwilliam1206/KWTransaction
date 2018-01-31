<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('county_id',false,true)->nullable();
            $table->integer('state_id',false,true)->nullable();
            $table->string('postal_code',10)->nullable();
            $table->integer('city_id',false,true)->nullable();
            $table->string('subdivision')->nullable();
            $table->integer('beds',false,true)->nullable();
            $table->decimal('baths',10,2)->nullable();
            $table->integer('year_built',false,true)->nullable();
            $table->decimal('habitable_area_sq_m',10,2)->nullable();
            $table->string('address');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('county_id')->references('id')->on('counties');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('properties');
    }
}
