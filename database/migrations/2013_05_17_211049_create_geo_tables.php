<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code',10);
        });

        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('country_id',false,true)->nullable();
            $table->string('code',10)->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('counties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('state_id',false,true)->nullable();
            $table->integer('country_id',false,true)->nullable();
            $table->string('code',10);
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('country_id',false,true)->nullable();
            $table->integer('state_id',false,true)->nullable();
            $table->string('code',10);
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('city_counties', function (Blueprint $table) {
            $table->integer('city_id',false,true)->nullable();
            $table->integer('county_id',false,true)->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('county_id')->references('id')->on('counties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_counties');
        Schema::drop('cities');
        Schema::drop('counties');
        Schema::drop('states');
        Schema::drop('countries');
    }
}
