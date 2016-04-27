<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valuta extends Model
{
    protected $table = 'Valute';

    protected $fillable = ['id','Alfa','Numericka','Naziv'];

    public function predlosci()
    {
        return $this->hasMany('App\Predlozak', 'ValuteId','id');
    }
}
