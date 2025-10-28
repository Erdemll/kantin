<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function sayfa()
    {
        return view('kategoriler', ['kategoriler' => Kategori::all()]);
    }

    public function ekle(Request $request)
    {
        try {
            $kayit = new kategori();
            $kayit->ad = $request->input('ad');
            $kayit->save();

            return redirect('/kategoriler')->with('create', 'ok');
        } catch (\Throwable $th) {
            return redirect('/kategoriler')->with('create', $th->getMessage());
        }
    }

    public function duzenle(Request $request)
    {
        $kayit = Kategori::where('id', $request->input('id'))->first();
        if($kayit)
        {
            try {
                $kayit->ad = $request->input('ad');
                $kayit->save();
                return redirect('/kategoriler')->with('update', true);
            } catch (\Throwable $th) {
                return redirect('/kategoriler')->with('update', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
            }
        }
        else
            return redirect('/kategoriler')->with('update', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
    }

    public function sil(Request $request)
    {
        try {
            $kayit = Kategori::find($request->input('id'));
            if($kayit->urunler->count() == 0)
            {
                $kayit->delete();
                return redirect('/kategoriler')->with('delete', true);
            }
            return redirect('/kategoriler')->with('delete', false)->with('error', 'Silmek istediğiniz kategoriye ait ürün buluduğundan silemezsiniz.');
        } catch (\Throwable $th) {
            return redirect('/kategoriler')->with('delete', false)->with('error', 'İşlem gerçekleştirilemedi, lütfen yeniden denyiniz.');
        }
    }

    
}
