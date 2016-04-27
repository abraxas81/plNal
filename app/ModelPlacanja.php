<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPlacanja extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ModeliPlacanja';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','Vrijednost', 'regex', 'Odobrenje', 'Zaduzenje'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function nalogOdobrenje(){
        return $this->hasMany('App\Nalog','ModelOdobrenjaId','id');
    }

    public function nalogZaduzenje(){
        return $this->hasMany('App\Nalog','ModelZaduzenjaId','id');
    }

    public function predlozakOdobrenje(){
        return $this->hasMany('App\Predlozak','ModelOdobrenjaId','id');
    }

    public function predlozakZaduzenje(){
        return $this->hasMany('App\Predlozak','ModelZaduzenjaId','id');
    }
}
