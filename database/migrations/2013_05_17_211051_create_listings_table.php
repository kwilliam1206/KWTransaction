<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('listing_id');
            $table->integer('property_id',false,true)->nullable();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->integer('status_id',false,true)->default(1);
            $table->foreign('status_id')->references('id')->on('listing_statuses');
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
        Schema::drop('listings');
        Schema::drop('listing_statuses');
    }
}
