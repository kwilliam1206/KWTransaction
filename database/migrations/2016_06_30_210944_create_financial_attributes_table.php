<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_attribute_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });

        Schema::create('financial_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_translation')->nullable();
            $table->integer('type_id',false,true);
            $table->decimal('value')->nullable();
            $table->boolean('lock_type')->default(false);
            $table->integer('created_by',false,true)->nullable();

            $table->foreign('type_id')->references('id')->on('financial_attribute_types')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['name', 'type_id']);
            $table->index('name');
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
        Schema::drop('financial_attributes');
        Schema::drop('financial_attribute_types');
    }
}
