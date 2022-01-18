<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_sheets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('author');
            $table->string('title');
            $table->boolean('verified');
            $table->boolean('visibility');
            $table->boolean('rearranged');
            $table->json('music_sheet_data');
            $table->boolean('has_tablature');
            $table->bigInteger('song_id')->unsigned();
//            $table->bigInteger('likes')->unsigned();
            $table->foreign('song_id')->references('id')->on('songs');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('music_sheets');
    }
}
