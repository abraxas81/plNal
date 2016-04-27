<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZiroRacun extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ZiroRacuni';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['IBAN','Primatelj','Platitelj','vaziod','vazido','PartneriId'];

    protected $dates = ['vaziod', 'vazido'];

    public function getvaziodAttribute($value)
    {
        return date('d.m.Y',strtotime($value));
    }

    public function setvaziodAttribute($value)
    {
        $this->attributes['vaziod'] = date('Y-m-d',strtotime($value));
    }

    public function getvazidoAttribute($value)
    {
        return date('d.m.Y',strtotime($value));
    }

    public function setvazidoAttribute($value)
    {
        $this->attributes['vazido'] = date('Y-m-d',strtotime($value));
    }

    public function partneri(){
        return $this->belongsTo('App\Partner','PartneriId');
    }

    public function nalozi(){
        return $this->hasMany('App\Nalog','ZiroPrimatelja','id')/*->where('Odobrenje','1')*/;
    }

    public function scopePlatitelj($query){
        return $query->where('Platitelj', 1);
    }
    public function scopePrimatelj($query){
        return $query->where('Primatelj', 1);
    }
    //ovo se izgleda ne koristi pa bi treebalo izbaciti
    public function naloziPlatitelj(){
        return $this->hasMany('App\Nalog','PlatiteljId')/*->where('Odobrenje','1')*/;
    }

    public function predlosciPlatitelj(){
        return $this->hasMany('App\Nalog','PlatiteljId')/*->where('Odobrenje','1')*/;
    }
}
