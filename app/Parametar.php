<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Parametri';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['NazivParametra','OpisParametra','Vrijednost','TipParametraId','OperaterId','KlijentiId'];

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
