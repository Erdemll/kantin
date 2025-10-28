<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;

class UrunFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ad' => $this->faker->word(),
            'fiyat' => $this->faker->numberBetween(5, 50),
            'kategori_id' => Kategori::factory(),
            'mevcut' => $this->faker->boolean(80), // %80 mevcut
        ];
    }
}
