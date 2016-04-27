<?php
/**
 * Created by PhpStorm.
 * User: Sasa
 * Date: 23/07/2015
 * Time: 10:09
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Racuni extends Model
{
    protected $table = 'racuni';

    protected $fillable = ['id','naziv','iban','korisnik_id'];

    public function predlosci()
    {
        return $this->hasMany('App\Predlosci','platitelj_id', 'id');
    }

    public function korisnici(){
        return $this->hasMany('App\User','korisnik_id', 'id');
    }

    public static function racuniKorisnika()
    {
        $results = Racuni::where('korisnik_id',Auth::id())->get();

        return $results;
    }

    public static function racuni()
    {
        $results = Racuni::where('korisnik_id',Auth::id())->get();

        return $results;
    }
}