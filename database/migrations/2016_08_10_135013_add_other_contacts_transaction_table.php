<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherContactsTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('referral_contact_id',false,true)->nullable();
            $table->integer('other_contact_id',false,true)->nullable();
            $table->integer('referral_agent_contact_id',false,true)->nullable();
            $table->integer('other_agent_contact_id',false,true)->nullable();

            $table->foreign('referral_contact_id')->references('id')->on('contacts');
            $table->foreign('other_contact_id')->references('id')->on('contacts');
            $table->foreign('referral_agent_contact_id')->references('id')->on('contacts');
            $table->foreign('other_agent_contact_id')->references('id')->on('contacts');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn(['referral_contact_id']);
        $table->dropColumn(['other_contact_id']);
        $table->dropColumn(['referral_agent_contact_id']);
        $table->dropColumn(['other_agent_contact_id']);
    }
}
