<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_note_id',false,true);
            $table->integer('user_id',false,true)->nullable();
            $table->integer('office_id',false,true)->nullable();
            $table->integer('region_id',false,true)->nullable();
            $table->boolean('hide')->default(false);

            $table->foreign('transaction_note_id')->references('id')->on('transaction_notes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
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
        Schema::drop('mentions');
    }
}
