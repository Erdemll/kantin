<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Görevliler
        if (!Schema::hasTable('gorevliler')) {
            Schema::create('gorevliler', function (Blueprint $table) {
                $table->id();
                $table->string('kullanici_adi')->unique();
                $table->string('sifre');
                $table->timestamps();
            });
        }

        // Öğrenciler
        if (!Schema::hasTable('ogrenciler')) {
            Schema::create('ogrenciler', function (Blueprint $table) {
                $table->unsignedBigInteger('id')->primary(); // elle girilecek
                $table->string('adsoyad');
                $table->integer('bakiye')->default(0);
                $table->timestamps();
            });
        }

        // Kategoriler
        if (!Schema::hasTable('kategoriler')) {
            Schema::create('kategoriler', function (Blueprint $table) {
                $table->id();
                $table->string('ad');
                $table->timestamps();
            });
        }

        // Ürünler
        if (!Schema::hasTable('urunler')) {
            Schema::create('urunler', function (Blueprint $table) {
                $table->id();
                $table->string('ad');
                $table->integer('fiyat');
                $table->foreignId('kategori_id')->constrained('kategoriler')->onDelete('cascade');
                $table->boolean('mevcut')->default(1);
                $table->timestamps();
            });
        }

        // Satış Geçmişi
        if (!Schema::hasTable('satis_gecmisi')) {
            Schema::create('satis_gecmisi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('alan_id')->constrained('ogrenciler')->onDelete('cascade');
                $table->foreignId('satan_id')->constrained('gorevliler')->onDelete('cascade');
                $table->foreignId('urun_id')->constrained('urunler')->onDelete('cascade');
                $table->unsignedBigInteger('vekalet_id')->nullable();
                $table->integer('tutar');
                $table->timestamp('tarih');
                $table->timestamps();

                $table->foreign('vekalet_id')->references('id')->on('ogrenciler')->onDelete('set null');
            });
        }

        // Bakiye Geçmişi
        if (!Schema::hasTable('bakiye_gecmisi')) {
            Schema::create('bakiye_gecmisi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ogrenci_id')->constrained('ogrenciler')->onDelete('cascade');
                $table->integer('tutar');
                $table->timestamp('tarih');
                $table->foreignId('gorevli_id')->constrained('gorevliler')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bakiye_gecmisi');
        Schema::dropIfExists('satis_gecmisi');
        Schema::dropIfExists('urunler');
        Schema::dropIfExists('kategoriler');
        Schema::dropIfExists('ogrenciler');
        Schema::dropIfExists('gorevliler');
    }
};
