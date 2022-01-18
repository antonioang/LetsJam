<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MusicSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author'=> $this->faker->name(),
            'title' => $this->faker->name(),
            'verified' => 0,
            'visibility' => 0,
            'rearranged' => 0,
            'has_tablature' => 0,
            'music_sheet_data' => json_encode(['ciao' => 'ciao']),
            //relazioni
            'song_id' => rand(1,7),
            'user_id' => rand(1,7),
        ];
    }
}
