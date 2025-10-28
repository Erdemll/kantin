<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gorevli;
use App\Models\Ogrenci;
use App\Models\Kategori;
use App\Models\Urun;
use App\Models\SatisGecmisi;
use App\Models\BakiyeGecmisi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 görevli
        $gorevliler = Gorevli::factory(1)->create();

        // 20 öğrenci
        $ogrenciler = Ogrenci::factory(20)->create();

        // 5 kategori
        $kategoriler = Kategori::factory(5)->create();

        // 20 ürün
        $urunler = Urun::factory(20)->create();

        // 50 satış
        SatisGecmisi::factory(50)->create();

        // 30 bakiye yükleme
        BakiyeGecmisi::factory(30)->create();
    }
}
