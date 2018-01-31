<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id',false,true);
            $table->integer('transaction_id',false,true);
            $table->integer('user_id',false,true)->nullable();
            $table->integer('office_id',false,true)->nullable();
            $table->integer('region_id',false,true)->nullable();
            $table->boolean('completed')->default(false);
            $table->integer('completed_by',false,true)->nullable();

            $table->foreign('type_id')->references('id')->on('task_types')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('tasks');
        Schema::drop('task_types');
    }
}
