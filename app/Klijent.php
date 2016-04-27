<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klijent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Klijenti';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','Naziv'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /*definiraj vezu između klijenta i operatera*/
    public function operateri()
    {
        return $this->belongsToMany('App\Users', 'OperateriKlijenti', 'KlijentiId', 'OperateriId');
    }
    public function partneri(){
        return $this->belongsToMany('App\Partner','KlijentiPartneri','Klijenti_id','Partneri_id');
    }
    public function nalozi(){
        return $this->belongsToMany('App\Nalog', 'NaloziKlijenti', 'KlijentiId', 'NaloziId');
    }
    public function parametri(){
        return $this->hasMany('App\Parametar','KlijentiId','id');
    }
    public function predlosci(){
        return $this->hasMany('App\Predlozak','KlijentiId','id');
    }
    public function zbrojniNalozi(){
        return $this->hasMany('App\ZbrojniNalog','KlijentiId','id');
    }    

}
