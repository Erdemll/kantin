<?php

use App\Models\Ogrenci;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\GorevliController;
use App\Http\Controllers\OgrenciController;
use App\Http\Controllers\UrunController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlisverisController;
use App\Http\Controllers\ExcelController;


use App\Http\Middleware\Gorevli_Kontrol;

Route::get('/', function () {
    return view('giris');
});

Route::middleware(Gorevli_Kontrol::class)->group(function () {
    Route::get('/anasayfa', function () {
        return view('anasayfa', ['adet' => Ogrenci::count(), 'toplam_bakiye' => Ogrenci::sum('bakiye')]);
    });

    //Route::get('/talebe_ekle', [OgrenciController::class, 'talebeler']);

    Route::get('/alisveris', [AlisverisController::class, 'sayfa']);
    Route::post('/bakiye_yukle', [AlisverisController::class, 'bakiye_yukle']);

    Route::get('/ogrenciler', [OgrenciController::class, 'sayfa']);
    Route::post('/ogrenci_duzenle', [OgrenciController::class, 'duzenle']);
    Route::post('/ogrenci_sil', [OgrenciController::class, 'sil']);
    Route::post('/ogrenci_ekle', [OgrenciController::class, 'ekle']);
    Route::post('/exel_ekle', [OgrenciController::class, 'exel_ekle']);

    Route::get('/kategoriler', [KategoriController::class, 'sayfa']);
    Route::post('/kategori_duzenle', [KategoriController::class, 'duzenle']);
    Route::post('/kategori_sil', [KategoriController::class, 'sil']);
    Route::post('/kategori_ekle', [KategoriController::class, 'ekle']);

    Route::get('/urunler', [UrunController::class, 'sayfa']);
    Route::post('/urun_duzenle', [UrunController::class, 'duzenle']);
    Route::post('/urun_sil', [UrunController::class, 'sil']);
    Route::post('/urun_ekle', [UrunController::class, 'ekle']);
    Route::post('/mevcutluk_guncelle', [UrunController::class, 'mevcutluk_guncelle']);

    Route::post('/ogrenci_getir', [OgrenciController::class, 'ogrenci_getir']);

    Route::post('/satis_yap', [AlisverisController::class, 'satis_yap']);

    Route::get('/cikis_yap', [GorevliController::class, 'cikis_yap']);

    Route::get('/satis_gecmisi', [AlisverisController::class, 'satis_gecmisi_sayfa']);
    Route::get('/satis_gecmisi/{id}', [AlisverisController::class, 'satis_gecmisi_detay']);
    Route::get('/iade_et/{satis_id}', [AlisverisController::class, 'iade']);

    Route::get('/bakiye_gecmisi', [AlisverisController::class, 'bakiye_gecmisi_sayfa']);
    Route::get('/bakiye_gecmisi/{id}', [AlisverisController::class, 'bakiye_gecmisi_detay']);

    Route::get('/gorevliler', [GorevliController::class, 'gorevliler_sayfa']);
    Route::post('/gorevli_ekle', [GorevliController::class, 'gorevli_ekle']);

    Route::get('/exel_deneme', function () {
        return view('exel_deneme');
    });

});

Route::post('/giris_yap', [GorevliController::class, 'giris_yap'])->name('giris_yap');