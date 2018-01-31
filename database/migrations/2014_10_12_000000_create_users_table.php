<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->index('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('kw_uid',false,true)->unique()->nullable();
            $table->date('kw_start_date')->nullable();
            $table->integer('sponsor_kw_uid',false,true)->nullable();
            $table->string('sponsor_name')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('photo')->nullable();
            $table->integer('language_id',false,true)->default(1);
            $table->foreign('language_id')->references('id')->on('languages');
            $table->integer('currency_id',false,true)->default(1);
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->integer('locale_id',false,true)->default(1);
            $table->foreign('locale_id')->references('id')->on('locales');
            $table->integer('status_id',false,true)->default(1);
            $table->dateTime('status_change_date');
            $table->foreign('status_id')->references('id')->on('user_statuses');
            $table->json('profile_attributes')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
        Schema::drop('user_statuses');
    }
}
