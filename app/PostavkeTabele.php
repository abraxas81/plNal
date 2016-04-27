<?php

namespace App;


class PostavkeTabele extends Parametar
{

    protected $casts = [
        'Vrijednost' => 'array'
    ];

    public function operateri(){
        return $this->belongsTo('App\Operater','OperaterId');
    }

    public function klijenti(){
        return $this->belongsTo('App\Klijent','KlijentiId');
    }

    public function tipParametra(){
        return $this->belongsTo('App\TipParametra','TipParametraId');
    }
}
