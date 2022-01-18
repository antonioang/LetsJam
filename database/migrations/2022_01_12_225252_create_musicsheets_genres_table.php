<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicsheetsGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musicsheets_genres', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('music_sheet_id')->unsigned();
            $table->bigInteger('genre_id')->unsigned();
            $table->foreign('genre_id')->references('id')->on('genres');
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
        Schema::dropIfExists('musicsheets_genres');
    }
}
