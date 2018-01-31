<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('kw_id')->unique();
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions');
            $table->integer('default_language',false,true)->default(1);
            $table->integer('default_locale',false,true)->default(1);
            $table->integer('default_currency',false,true)->default(1);
            $table->json('main_attributes')->nullable();
            $table->timestamps();
            $table->foreign('default_locale')->references('id')->on('locales');
            $table->foreign('default_language')->references('id')->on('languages');
            $table->foreign('default_currency')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('offices');
    }
}
