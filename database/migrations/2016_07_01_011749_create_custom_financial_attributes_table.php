<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFinancialAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_financial_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('financial_attribute_id',false,true);
            $table->integer('region_id',false,true)->nullable();
            $table->integer('office_id',false,true)->nullable();
            $table->integer('user_id',false,true)->nullable();
            $table->decimal('value')->nullable();
            $table->decimal('minimum')->nullable();
            $table->decimal('maximum')->nullable();
            $table->decimal('waiver')->nullable();
            $table->dateTime('waiver_date')->nullable();
            $table->integer('created_by',false,true)->nullable();

            $table->foreign('financial_attribute_id')->references('id')->on('financial_attributes')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('custom_financial_attributes');
    }
}
