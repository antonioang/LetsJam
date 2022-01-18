<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $instruments = [
            "Piano",
            "Organ",
            "Violin",
            "Cello",
            "Contrabass",
            "BassAcoustic",
            "BassElectric",
            "Guitar",
            "Banjo",
            "Sax",
            "Trumpet",
            "Horn",
            "Trombone",
            "Tuba",
            "Flute",
            "Oboe",
            "Clarinet",
            "Drum"];
        return [
            'name' => $instruments[rand(1,18)],
            'instrument_key'=> $this->faker->title(),
        ];
    }
}
