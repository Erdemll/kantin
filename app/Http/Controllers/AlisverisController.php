<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urun;
use App\Models\Kategori;
use App\Models\Ogrenci;
use App\Models\SatisGecmisi;
use App\Models\BakiyeGecmisi;
class AlisverisController extends Controller
{
    public function sayfa()
    {
        return view('alisveris', [
            'kategoriler' => Kategori::with('urunler')->get()
        ]);
    }

    public function satis_gecmisi_sayfa()
    {
        return view('satis_gecmisi', [
            'satislar' => SatisGecmisi::with(['ogrenci', 'gorevli', 'urun', 'vekalet'])->orderByDesc('created_at')->get()
        ]);
    }

    public function satis_gecmisi_detay($id)
    {
        $satislar = SatisGecmisi::with(['ogrenci', 'gorevli', 'urun', 'vekalet'])
            ->where('alan_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return view('satis_gecmisi_detay', [
            'satislar' => $satislar,
            'ogrenci' => Ogrenci::find($id)
        ]);
    }

    public function bakiye_gecmisi_sayfa()
    {
        return view('bakiye_gecmisi', ['yuklemeler' => BakiyeGecmisi::with(['ogrenci', 'gorevli'])->orderByDesc('created_at')->get()]);
    }

    public function bakiye_gecmisi_detay($id)
    {
        $yuklemeler = BakiyeGecmisi::with(['ogrenci', 'gorevli'])
            ->where('ogrenci_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return view('bakiye_gecmisi_detay', [
            'yuklemeler' => $yuklemeler,
            'ogrenci' => Ogrenci::find($id)
        ]);
    }
    public function bakiye_yukle(Request $request)
    {
        try {
            $kayit = Ogrenci::find($request->input('ogrenci_id'));
            if ($kayit) {
                $kayit->bakiye += $request->input('bakiye');
                $kayit->save();

                $bakiye_gecmisi = new BakiyeGecmisi();
                $bakiye_gecmisi->ogrenci_id = $kayit->id;
                $bakiye_gecmisi->gorevli_id = session()->get('gorevli_id');
                $bakiye_gecmisi->tutar = $request->input('bakiye');
                $bakiye_gecmisi->save();

                return response()->json(['bakiye_yukleme' => true, 'yeni_bakiye' => $kayit->bakiye]);
            }
            return response()->json(['bakiye_yukleme' => false, 'error' => 'Öğrenci bulunamadı.']);
        } catch (\Throwable $th) {
            return response()->json(['bakiye_yukleme' => false, 'error' => $th->getMessage()]);
        }
    }

    public function satis_yap(Request $request)
    {
        try {
            $ogrenci = Ogrenci::find($request->input('ogrenci_id'));
            if (!$ogrenci) {
                return response()->json(['satis' => false, 'error' => 'Öğrenci bulunamadı.']);
            }
            $toplam_fiyat = 0;
            foreach ($request->input('urunler') as $urun_id) {
                if ($urun_id == null) {
                    continue;
                }
                $urun = Urun::find($urun_id);
                if (!$urun) {
                    return response()->json(['satis' => false, 'error' => 'Ürün bulunamadı: ' . $urun['urun_id']]);
                }
                $satis = new SatisGecmisi();
                $satis->alan_id = $ogrenci->id;
                $satis->satan_id = session()->get('gorevli_id');
                $satis->urun_id = $urun->id;
                $satis->vekalet_id = $request->input('vekalet_id');
                $satis->tutar = $urun->fiyat;
                $satis->save();

                $toplam_fiyat += $urun->fiyat;
            }

            $ogrenci->bakiye -= $toplam_fiyat;
            $ogrenci->save();
            return response()->json(['satis' => true, 'yeni_bakiye' => $ogrenci->bakiye]);
        } catch (\Throwable $th) {
            return response()->json(['satis' => false, 'error' => $th->getMessage()]);
        }
    }

    public function iade($satis_id)
    {
        try {
            $satis = SatisGecmisi::find($satis_id);
            if (!$satis) {
                return redirect('/satis_gecmisi')->with('iade', false)->with('error', 'Satış kaydı bulunamadı.');
            }

            $ogrenci = Ogrenci::find($satis->alan_id);
            if (!$ogrenci) {
                return redirect('/satis_gecmisi')->with('iade', false)->with('error', 'Öğrenci bulunamadı.');
            }

            $ogrenci->bakiye += $satis->tutar;
            $ogrenci->save();

            $satis->delete();

            return redirect('/satis_gecmisi')->with('iade', true)->with('success', 'İade işlemi başarılı. Yeni bakiye: ' . $ogrenci->bakiye);
        } catch (\Throwable $th) {
            return redirect('/satis_gecmisi')->with('iade', false)->with('error', 'İade işlemi sırasında bir hata oluştu: ' . $th->getMessage());
        }
    }

}
