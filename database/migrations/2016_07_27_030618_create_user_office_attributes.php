<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOfficeAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_office_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id',false,true);
            $table->integer('office_id',false,true);
            $table->date('anniversary_date')->nullable();
            $table->decimal('remaining_cap')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->unique(['user_id', 'office_id']);
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
    }
}
