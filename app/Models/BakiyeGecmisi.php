<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BakiyeGecmisi extends Model
{
    use HasFactory;

    protected $table = 'bakiye_gecmisi';
    protected $fillable = ['ogrenci_id', 'tutar', 'gorevli_id'];

    public function ogrenci()
    {
        return $this->belongsTo(Ogrenci::class, 'ogrenci_id');
    }

    public function gorevli()
    {
        return $this->belongsTo(Gorevli::class, 'gorevli_id');
    }
}
