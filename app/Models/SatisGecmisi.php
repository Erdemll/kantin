<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatisGecmisi extends Model
{
    use HasFactory;

    protected $table = 'satis_gecmisi';
    protected $fillable = ['alan_id', 'satan_id', 'urun_id', 'vekalet_id', 'tutar', 'tarih'];

    public function ogrenci()
    {
        return $this->belongsTo(Ogrenci::class, 'alan_id');
    }

    public function gorevli()
    {
        return $this->belongsTo(Gorevli::class, 'satan_id');
    }

    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id');
    }

    public function vekalet()
    {
        return $this->belongsTo(Ogrenci::class, 'vekalet_id');
    }
}
