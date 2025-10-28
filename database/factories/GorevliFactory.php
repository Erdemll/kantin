<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class GorevliFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kullanici_adi' => $this->faker->unique()->userName(),
            'sifre' => Hash::make('123456'), // tüm görevliler için default şifre
        ];
    }
}
