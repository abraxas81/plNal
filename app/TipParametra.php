<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipParametra extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'TipParametra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['NazivTipa'];

    public function parametri(){
        return $this->$this->hasMany('App\Partner','TipParametraId');
    }
}
