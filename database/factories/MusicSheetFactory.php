<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class MusicSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $string = File::get("database/factories/fake.json");
//        $json_a = json_decode($string);
        return [
            'author'=> $this->faker->name(),
            'title' => $this->faker->name(),
            'verified' => 0,
            'visibility' => 0,
            'rearranged' => 0,
            'has_tablature' => 0,
            'music_sheet_data' => $string,
            //relazioni
            'song_id' => rand(1,7),
            'user_id' => rand(1,7),
        ];
    }
}
