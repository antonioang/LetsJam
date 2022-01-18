<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_instruments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('instrument_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('instrument_id')->references('id')->on('instruments');
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
        Schema::dropIfExists('users_instruments');
    }
}
