<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomFinancialAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_financial_attributes', function (Blueprint $table) {
            $table->integer('type_id',false,true);

            $table->foreign('type_id')->references('id')->on('financial_attribute_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_financial_attributes', function (Blueprint $table) {
            $table->dropColumn(['type_id']);
        });
    }
}
