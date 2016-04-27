<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Partneri';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Naziv','Adresa','Email','Telefon','Mobitel','OIB'];

    public function klijenti(){
        return $this->belongsToMany('App\Klijent','KlijentiPartneri','Partneri_id', 'Klijenti_id');
    }

    public function ziroRacuni(){
        return $this->hasMany('App\ZiroRacun', 'PartneriId','id');
    }

    public function ziroRacuniPlatitelj(){
        return $this->hasMany('App\ZiroRacun', 'PartneriId','id')->where('Platitelj', 1);
    }

    public function predlozakPlatitelj(){
    return $this->hasMany('App\Predlozak','PlatiteljId');
    }

    public function predlozakPrimatelj(){
        return $this->hasMany('App\Predlozak','PrimateljId');
    }
    
    /*queries*/

    public static function filterKlijent($klijentId){
        $results = Partner::where('KlijentiId',$klijentId);
        return $results;
    }
    
}
