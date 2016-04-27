<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SifraNamjene extends Model
{
    protected $table = 'SifreNamjene';

    protected $fillable = ['id','Sifra','Definicija','Klasifikacija','Naziv'];

    public function predlosci()
    {
        return $this->hasMany('App\Predlozak', 'SifreNamjeneId','id');
    }
}
