<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alternate_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('office_name')->nullable();
            $table->integer('state_id',false,true)->nullable();
            $table->string('postal_code',10)->nullable();
            $table->integer('city_id',false,true)->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('type_id',false,true);
            $table->foreign('type_id')->references('id')->on('contact_types');
            $table->integer('user_id',false,true);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('phone_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_translation')->nullable();
            $table->index('name');
        });

        Schema::create('contact_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->boolean('primary')->default(false);
            $table->integer('type_id',false,true);
            $table->foreign('type_id')->references('id')->on('phone_types');
            $table->integer('contact_id',false,true);
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
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
        Schema::drop('contact_phones');
        Schema::drop('phone_types');
        Schema::drop('contacts');
        Schema::drop('contact_types');
    }
}
