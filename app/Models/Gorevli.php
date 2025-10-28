<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gorevli extends Model
{
    use HasFactory;

    protected $table = 'gorevliler';

    protected $fillable = ['kullanici_adi', 'sifre'];

    public function satislar()
    {
        return $this->hasMany(SatisGecmisi::class, 'satan_id');
    }

    public function yuklemeler()
    {
        return $this->hasMany(BakiyeGecmisi::class, 'gorevli_id');
    }
}
