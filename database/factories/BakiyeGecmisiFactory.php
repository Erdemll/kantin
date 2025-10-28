<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ogrenci;
use App\Models\Gorevli;

class BakiyeGecmisiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ogrenci_id' => Ogrenci::factory(),
            'tutar' => $this->faker->numberBetween(20, 200),
            'tarih' => $this->faker->dateTimeThisYear(),
            'gorevli_id' => Gorevli::factory(),
        ];
    }
}
