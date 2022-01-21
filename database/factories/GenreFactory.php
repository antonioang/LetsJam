<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $genres = [
            "Rock'n'roll",
            "Classica",
            "Rock",
            "jazz",
            "Rap",
            "Hardcore",
            "Metal",
            "Hip hop",
            "Blues",
            "House",
            "Elettronica",
            "Pop",
            "British pop",
            "rhythm and blues",
            "Boogie-woogie",
            "R&B",
            "Soul",
            "Funk"];
        return [
            'name' => $this->faker->randomElement($genres),
            'description'=> $this->faker->text(),
        ];
    }
}
