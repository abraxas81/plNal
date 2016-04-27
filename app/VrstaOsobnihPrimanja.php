<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VrstaOsobnihPrimanja extends Model
{
    protected $table = 'VrsteOsobnihPrimanja';

    protected $fillable = ['id','Sifra','Naziv'];

    public function predlosci()
    {
        return $this->hasMany('App\Predlozak', 'VrsteOsobnihPrimanjaId','id');
    }
}
