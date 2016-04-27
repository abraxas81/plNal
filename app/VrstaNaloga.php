<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VrstaNaloga extends Model
{
    protected $table = 'vrstaNaloga';

    protected $fillable = ['Naziv'];

    public function zbrojniNalog()
    {
        return $this->hasMany('App\ZbrojniNalog', 'VrstaNalogaId','id');
    }

    /*public function predlosci()
    {
        return $this->hasMany('App\Predlosci', 'vrsta_naloga_id', 'id');
    }*/

}
