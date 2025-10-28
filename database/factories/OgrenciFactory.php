<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OgrenciFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1000, 9999), // elle girilir
            'adsoyad' => $this->faker->name(),
            'bakiye' => $this->faker->numberBetween(0, 500),
        ];
    }
}
