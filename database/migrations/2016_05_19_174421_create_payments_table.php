<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });
        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by',false,true);
            $table->integer('updated_by',false,true)->nullable();
            $table->integer('status_id',false,true)->default(1);
            $table->integer('currency_id',false,true);
            $table->integer('transaction_id',false,true);
            $table->decimal('amount',10,2);
            $table->date('paid_date')->nullable();
            $table->dateTime('status_change_date');
            $table->decimal('est_amount',10,2)->nullable();
            $table->date('est_paid_date')->nullable();
            $table->boolean('locked');
            $table->boolean('paid');
            $table->json('main_attributes')->nullable();
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('payment_statuses');
            $table->softDeletes();
        });

        Schema::create('transaction_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id',false,true);
            $table->integer('payment_id',false,true)->nullable();
            $table->text('note');
            $table->integer('created_by',false,true);
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->timestamps();
        });

        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id',false,true);
            $table->integer('payment_id',false,true)->nullable();
            $table->text('line')->nullable();
            $table->integer('user_id',false,true);
            $table->integer('log_type_id',false,true);
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('log_type_id')->references('id')->on('log_types');
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
        Schema::drop('transaction_notes');
        Schema::drop('transaction_logs');
        Schema::drop('payments');
        Schema::drop('payment_types');
        Schema::drop('payment_statuses');
    }
}
