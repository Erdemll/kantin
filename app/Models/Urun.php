<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urun extends Model
{
    use HasFactory;

    protected $table = 'urunler';
    protected $fillable = ['ad', 'fiyat', 'kategori_id', 'mevcut'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function satislar()
    {
        return $this->hasMany(SatisGecmisi::class, 'urun_id');
    }
}
