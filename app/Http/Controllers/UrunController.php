<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urun;
use App\Models\Kategori;

class UrunController extends Controller
{
    public function sayfa()
    {
        return view('urunler', ['urunler' => Urun::all(), 'kategoriler' => Kategori::all()]);
    }

    public function ekle(Request $request)
    {
        try {
            $kayit = new Urun();
            $kayit->ad = $request->input('ad');
            $kayit->fiyat = $request->input('fiyat');
            if($request->input('kategori_id') != 0)
                $kayit->kategori_id = $request->input('kategori_id');
            else
                return redirect('/urunler')->with('create', false)->with('error', 'Lütfen bir kategori seçiniz.');
            $kayit->save();

            return redirect('/urunler')->with('create', true);
        } catch (\Throwable $th) {
            return redirect('/urunler')->with('create', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen tekrar deneyiniz.');
        }
    }

     public function duzenle(Request $request)
    {
        $kayit = Urun::where('id', $request->input('id'))->first();
        if($kayit)
        {
            try {
                $kayit->ad = $request->input('ad');
                $kayit->fiyat = $request->input('fiyat');
                $kayit->kategori_id = $request->input('kategori_id');
                $kayit->save();

                return redirect('/urunler')->with('update', true);
            } catch (\Throwable $th) {
                return redirect('/urunler')->with('update', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
            }
        }
        else
            return redirect('/urunler')->with('update', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
    }

    public function mevcutluk_guncelle(Request $request)
    {
        $kayit = Urun::where('id', $request->input('id'))->first();
        if($kayit)
        {
            try {
                if($request->input('durum')){
                    $kayit->mevcut = 1;
                    $kayit->save();
                }
                else{
                    $kayit->mevcut = 0;
                    $kayit->save();
                }
                return response()->json(['mevcut_update' => true]);
            } catch (\Throwable $th) {
                return response()->json(['mevcut_update' => false, 'error' => 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.']);
            }
        }
        else
            return response()->json(['mevcut_update' => false, 'error' => 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.']);
    }

    public function sil(Request $request)
    {
        try {
            $kayit = Urun::find($request->input('id'));
            if($kayit->satislar->count() == 0)
            {
                $kayit->delete();
                return redirect('/urunler')->with('delete', true);
            }
            return redirect('/urunler')->with('delete', false)->with('error', 'Silmek istediğiniz ürüne ait satış geçmişi buluduğundan silemezsiniz.');
        } catch (\Throwable $th) {
            return redirect('/urunler')->with('delete', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
        }
    }
}
