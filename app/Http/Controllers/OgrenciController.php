<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ogrenci;

class OgrenciController extends Controller
{
    public function sayfa()
    {
        return view('ogrenciler', ['ogrenciler' => Ogrenci::all()]);
    }

    public function ekle(Request $request)
    {
        try {
            $kayit = new Ogrenci();
            $kayit->id = $request->input('id');
            $kayit->adsoyad = $request->input('adsoyad');
            $kayit->save();

            return redirect('/ogrenciler')->with('create', 'ok');
        } catch (\Throwable $th) {
            return redirect('/ogrenciler')->with('create', $th->getMessage());
        }
    }

    public function exel_ekle(Request $request)
    {
        try {
            $ogrenciler = $request->input('ogrenciler', []);

            // Burada veritabanına kaydetme işlemini yapabilirsin
            foreach ($ogrenciler as $ogrenci) {
                $kayit = new Ogrenci();
                $kayit->id = $ogrenci['NO'];
                $kayit->adsoyad = $ogrenci['İSİM SOYİSİM'];
                $kayit->bakiye = $ogrenci['BAKİYE'] ?? 0;
                $kayit->save();
                // Örnek olarak log’a basalım:
                \Log::info('Öğrenci verisi:', $ogrenci);
            }

            return response()->json(['status' => 'ok', 'adet' => count($ogrenciler)]);
        } catch (\Throwable $th) {
            \Log::error('Excel verisi işlenirken hata oluştu: ' . $th->getMessage());
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function duzenle(Request $request)
    {
        $kayit = Ogrenci::where('id', $request->input('id'))->first();
        if ($kayit) {
            try {
                $kayit->adsoyad = $request->input('adsoyad');
                $kayit->save();
                return redirect('/ogrenciler')->with('update', true);
            } catch (\Throwable $th) {
                return redirect('/ogrenciler')->with('update', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
            }
        } else
            return redirect('/ogrenciler')->with('update', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
    }

    public function sil(Request $request)
    {
        try {
            $kayit = Ogrenci::find($request->input('id'));
            if ($kayit->alinanlar->count() == 0 && $kayit->bakiye == 0) {
                $kayit->delete();
                return redirect('/ogrenciler')->with('delete', true);
            } elseif ($kayit->bakiye == 0) {
                return redirect('/ogrenciler')->with('delete', false)->with('error', 'Silmek istediğiniz öğrencinin kayıtlı satın alma geçmişi bulunduğundan silemezsiniz.');

            }
            return redirect('/ogrenciler')->with('delete', false)->with('error', 'Silmek istediğiniz öğrencinin bakiyesi buluduğundan silemezsiniz.');
        } catch (\Throwable $th) {
            return redirect('/ogrenciler')->with('delete', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
        }
    }

    public function ogrenci_getir(Request $request)
    {
        $numara = $request->input('numara');
        $ogrenci = Ogrenci::where('id', $numara)->first();
        if ($ogrenci) {
            return response()->json([
                'success' => true,
                'ad_soyad' => $ogrenci->adsoyad,
                'bakiye' => $ogrenci->bakiye
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Öğrenci bulunamadı.'
            ]);
        }
    }
}
