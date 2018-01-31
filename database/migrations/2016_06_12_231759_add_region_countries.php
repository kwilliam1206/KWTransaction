<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegionCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('region_countries', function (Blueprint $table) {
            $table->integer('country_id',false,true)->nullable();
            $table->integer('region_id',false,true)->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('region_countries');
    }
}
