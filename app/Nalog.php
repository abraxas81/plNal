<?php
/**
 * Created by PhpStorm.
 * User: Sasa
 * Date: 23/07/2015
 * Time: 10:09
 */

namespace App;
use app\Services\MoneyFormatter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Nalog extends Model
{
    protected $table = 'Nalozi';

    protected $fillable = ['Id','ModelOdobrenjaId','BrojOdobrenja','ModelZaduzenjaId','BrojZaduzenja','Iznos','Opis','datumizvrsenja','VrsteOsobnihPrimanjaId','SifreNamjeneId', 'ValuteId','PlatiteljId','ZiroPrimatelja', 'VrstaNalogaId','ZbrojniNalogId'];

    protected $dates =['datumizvrsenja'];

    public function getdatumizvrsenjaAttribute($value)
    {
        return date('d.m.Y',strtotime($value));
    }

    public function setdatumizvrsenjaAttribute($value)
    {
        $this->attributes['datumizvrsenja'] = date('Y-m-d',strtotime($value));
    }


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
        return $this->belongsToMany('App\Klijent', 'NaloziKlijenti','NaloziId','KlijentId');
    }

    public function platitelj(){
        return $this->belongsTo('App\ZiroRacun','PlatiteljId');
    }
    public function primatelj(){
        return $this->belongsTo('App\ZiroRacun','ZiroPrimatelja');
    }

    public function modelOdobrenja(){
        return $this->belongsTo('App\ModelPlacanja','ModelOdobrenjaId')->where('Odobrenje','1');
    }

    public function modelZaduzenja(){
        return $this->belongsTo('App\ModelPlacanja','ModelZaduzenjaId')->where('Zaduzenje','1');
    }

    public function zbrojniNalozi()
    {
        return $this->belongsTo('App\ZbrojniNalog','ZbrojniNalogId');
    }

    public static function NaloziKlijenta($id){
        $results = Nalog::where('predlozak_nalog',1)
            ->with(['predlosci' => function($query) use ($id)
            {
                $query->select('id','vrsta_naloga_id','platitelj_id');
            }])
            /*->with(['predlosci.racuni' => function($query)
            {
                $query->select('id','iban');
            }])*/->select('iznos')->get();
        return $results;
    }

    /*staro*/


    public static function nalozi($id){
        $results = Placanja::where('predlozak_nalog',1)
                             ->with(['predlosci' => function($query) use ($id)
                             {
                                $query->select('id','vrsta_naloga_id','platitelj_id');
                             }])
                             /*->with(['predlosci.racuni' => function($query)
                             {
                                 $query->select('id','iban');
                             }])*/->select('iznos')->get();
        return $results;
    }

    public static function nalozi2($id){
        $results = Placanja::with(['predlosci' => function($query) use ($id)
        {
            $query->where('zbrojni_nalog_id',$id)->select('iznos','datum_izvrsenja');

        }])->where('predlozak_nalog',1)
            ->with('predlosci.racuni')->get(['iznos','datum_izvrsenja','racuni.naziv','naziv_primatelja']);
        return $results;
    }

    public static function predlozak($id){
        $result = Placanja::where('id',$id)->with('predlosci','predlosci.racuni','racuni.naziv','predlosci.naziv_primatelja')->get();
        return $result;
    }

    public static function listaZbrojnihNaloga($id){
        $results = Placanja::where('predlozak_nalog',1)->whereHas('predlosci', function($q) use($id){
            $q->where('vrsta_naloga_id',$id);
        })->with('predlosci.racuni')
        ;
        $results = $results->groupBy('zbrojni_nalog_id')->get();
        return $results;
    }

    public static function nalog($id)
    {
        $results = Placanja::where('id',$id)->with('predlosci','predlosci.racuni')->get();

        return $results;
    }

}