<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ogrenci extends Model
{
    use HasFactory;

    protected $table = 'ogrenciler';
    public $incrementing = false; // elle id girilecek
    protected $keyType = 'int';

    protected $fillable = ['id', 'adsoyad', 'bakiye'];

    public function alinanlar()
    {
        return $this->hasMany(SatisGecmisi::class, 'alan_id');
    }

    public function vekaletSatislar()
    {
        return $this->hasMany(SatisGecmisi::class, 'vekalet_id');
    }

    public function yuklemeler()
    {
        return $this->hasMany(BakiyeGecmisi::class, 'ogrenci_id');
    }
}
