<?php
/**
 * Created by PhpStorm.
 * User: Sasa
 * Date: 23/07/2015
 * Time: 10:09
 */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Predlozak extends Model
{
    protected $table = 'Predlosci';

    protected $fillable = ['id','Naziv','ModelOdobrenjaId','BrojOdobrenja','ModelZaduzenjaId','BrojZaduzenja','Iznos','Opis','VrsteOsobnihPrimanjaId','SifreNamjeneId', 'ValuteId','KlijentiId','PlatiteljId','ZiroPrimatelja', 'VrstaNalogaId'];

    public function setIznosAttribute($value)
    {
        $this->attributes['Iznos'] = str_replace(',','.',(str_replace('.','',$value)));
    }

    public function sifreNamjene(){
        return $this->belongsTo('App\SifraNamjene','SifreNamjeneId');
    }

    public function valute()
    {
        return $this->belongsTo('App\Valuta', 'ValuteId');
    }

    public function vrstePrimanja()
    {
        return $this->belongsTo('App\Racuni', 'VrsteOsobnihPrimanjaId');
    }

    public function klijenti(){
        return $this->belongsTo('App\Klijent','KlijentiId');
    }

    public function platitelj(){
        return $this->belongsTo('App\ZiroRacun','PlatiteljId');
    }

    public function primatelj(){
        return $this->belongsTo('App\ZiroRacun','ZiroPrimatelja');
    }

    public function modelOdobrenja(){
        return $this->belongsTo('App\ModelPlacanja','ModelOdobrenjaId');
    }

    public function modelZaduzenja(){
        return $this->belongsTo('App\ModelPlacanja','ModelZaduzenjaId');
    }

    public function vrsteNaloga()
    {
        return $this->belongsTo('App\VrsteNaloga','VrstaNalogaId');
    }

    public function scopePredlosciKlijenta($query, $klijentId){

        return $query->where('KlijentiId', $klijentId);
    }

    public function scopePredlosciVrsteNaloga($query, $vrstaNalogaId){

        return $query->where('VrstaNalogaId', $vrstaNalogaId);
    }

    public function scopeFilterNaziv($query, $letter){

        return $query->where('Naziv', 'like', $letter.'%');
    }

}