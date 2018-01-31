<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('agent_commission');
            $table->integer('agent_commission_type',false,true);
            $table->decimal('payment_gross')->nullable();
            $table->decimal('payment_net')->nullable();
            $table->decimal('mc_dollar')->nullable();
            $table->decimal('agent_dollar')->nullable();

            $table->foreign('agent_commission_type')->references('id')->on('financial_attribute_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['agent_commission_type']);
            $table->dropColumn(['agent_commission', 'agent_commission_type', 'payment_gross', 'payment_net', 'mc_dollar', 'agent_dollar']);
        });
    }
}
