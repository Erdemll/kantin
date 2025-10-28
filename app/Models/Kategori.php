<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoriler';
    protected $fillable = ['ad'];

    public function urunler()
    {
        return $this->hasMany(Urun::class, 'kategori_id');
    }
}
