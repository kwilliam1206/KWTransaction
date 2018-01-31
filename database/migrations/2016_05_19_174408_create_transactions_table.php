<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->index('name');
        });
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->index('name');
        });

        Schema::create('log_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->index('name');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id',false,true);
            $table->integer('office_id',false,true);
            $table->integer('created_by',false,true);
            $table->integer('updated_by',false,true)->nullable();
            $table->integer('status_id',false,true)->default(1);
            $table->integer('type_id',false,true);
            $table->integer('buyer_contact_id',false,true)->nullable();
            $table->integer('seller_contact_id',false,true)->nullable();
            //$table->integer('seller_agent_id',false,true)->nullable();
            //$table->integer('buyer_agent_id',false,true)->nullable();
            $table->integer('buyer_agent_contact_id',false,true)->nullable();
            $table->integer('seller_agent_contact_id',false,true)->nullable();
            $table->integer('currency_id',false,true);
            $table->integer('listing_id',false,true);
            $table->dateTime('status_change_date');
            $table->decimal('price',10,2)->nullable();
            $table->date('effective_date')->nullable();
            $table->boolean('locked');
            $table->boolean('office_approved');
            $table->boolean('region_approved');
            $table->boolean('closed');
            $table->json('main_attributes')->nullable();
            $table->timestamps();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('listing_id')->references('id')->on('listings');
            $table->foreign('type_id')->references('id')->on('transaction_types');
            $table->foreign('status_id')->references('id')->on('transaction_statuses');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('agent_id')->references('id')->on('users');
            //$table->foreign('buyer_agent_id')->references('id')->on('users');
            //$table->foreign('seller_agent_id')->references('id')->on('users');
            $table->foreign('buyer_contact_id')->references('id')->on('contacts');
            $table->foreign('seller_contact_id')->references('id')->on('contacts');
            $table->foreign('buyer_agent_contact_id')->references('id')->on('contacts');
            $table->foreign('seller_agent_contact_id')->references('id')->on('contacts');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
        Schema::drop('transaction_types');
        Schema::drop('log_types');
        Schema::drop('transaction_statuses');
    }
}
