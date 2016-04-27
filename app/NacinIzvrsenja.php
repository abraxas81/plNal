<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NacinIzvrsenja extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'NacinIzvrsenja';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Naziv'];

    public function zbrojniNalog()
    {
        return $this->hasMany('App\ZbrojniNalog', 'NacinIzvrsenjaId','id');
    }


}
