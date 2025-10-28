<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ogrenci;
use App\Models\Gorevli;
use App\Models\Urun;

class SatisGecmisiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'alan_id' => Ogrenci::factory(),
            'satan_id' => Gorevli::factory(),
            'urun_id' => Urun::factory(),
            'vekalet_id' => null,
            'tutar' => $this->faker->numberBetween(5, 50),
            'tarih' => $this->faker->dateTimeThisYear(),
        ];
    }
}
