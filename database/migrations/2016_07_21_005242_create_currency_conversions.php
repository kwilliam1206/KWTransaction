<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyConversions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_conversions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_currency_id',false,true);
            $table->integer('to_currency_id',false,true);
            $table->dateTime('conversion_date');
            $table->double('rate')->nullable();

            $table->foreign('from_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('to_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->unique(['from_currency_id', 'to_currency_id', 'conversion_date'], 'currency_conversions_from_to_date_unique');
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
        Schema::drop('currency_conversions');
    }
}
