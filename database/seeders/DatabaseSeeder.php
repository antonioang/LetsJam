<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Instrument;
use App\Models\MusicSheet;
use App\Models\Song;
use Illuminate\Database\Seeder;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(7)->create();
//        Instrument::factory(7)->create();
//        Genre::factory(7)->create();
//        Song::factory(7)->create();
//        MusicSheet::factory(7)->create();

//        $sheets = MusicSheet::all();
//        $trumpet = Instrument::where('name', 'Trumpet')->first();
//
//        foreach ($sheets as $sheet) {
//            $sheet->instruments()->attach($trumpet->id);
//
//            //aggiungo randomicamente dei generi alle canzoni
//            $genre = Genre::all()->random();
//            $sheet->genres()->attach($genre->id);
//
//            //aggiungo randomicamente dei likes alle canzoni
//            $user = User::all()->random();
//            $sheet->likes()->attach($user->id);
//        }


    }
}
