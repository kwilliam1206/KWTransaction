<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRegionCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('region_countries', function (Blueprint $table) {
            $table->dropForeign('region_countries_country_id_foreign');
            $table->dropForeign('region_countries_region_id_foreign');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
