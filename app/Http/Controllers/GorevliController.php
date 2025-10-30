<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Gorevli;

class GorevliController extends Controller
{
    public function giris_yap(Request $request)
    {
        $kayit = Gorevli::where('kullanici_adi', $request->input('kullanici_adi'))->first();
        if($kayit)
        {
            if (Hash::check($request->sifre, $kayit->sifre)) {
                session(['gorevli_id' => $kayit->id]);
                session(['gorevli_ka' => $kayit->kullanici_adi]);
                return redirect('/anasayfa');
            }
            else
                return redirect('/')->with('error', 'Şifreniz yanlış.');
        }
        else
            return redirect('/')->with('error', 'Kullanıcı adınız yanlış.');
    }

    public function gorevli_ekle(Request $request)
    {
        try {
            $kayit = new Gorevli();
            $kayit->kullanici_adi = $request->input('kullanici_adi');
            $kayit->sifre = Hash::make('123456');
            $kayit->save();

            return redirect('/gorevliler')->with('create', 'ok');
        } catch (\Throwable $th) {
            return redirect('/gorevliler')->with('create', $th->getMessage());
        }
    }

    public function gorevliler_sayfa()
    {
        $gorevliler = Gorevli::all();
        return view('gorevliler', ['gorevliler' => $gorevliler]);
    }

    public function cikis_yap(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
