<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicsheetsInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musicsheets_instruments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('music_sheet_id')->unsigned();
            $table->bigInteger('instrument_id')->unsigned();
            $table->foreign('instrument_id')->references('id')->on('instruments');
            $table->foreign('music_sheet_id')->references('id')->on('music_sheets');
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
        Schema::dropIfExists('musicsheets_instruments');
    }
}
