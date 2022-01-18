<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author' => $this->faker->name(),
            'title' => $this->faker->title(),
            'album_name' => $this->faker->title(),
            'album_type' => $this->faker->title(),
            'image_url' => Str::random(10),
            'is_explicit' => 1,
            'duration' => rand(100,10000),
            'spotify_id' => rand(100,10000),
            'genre_id' => 1,
            'lyrics' => Str::random(100),
        ];
    }
}
