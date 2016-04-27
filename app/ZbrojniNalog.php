<?php
/**
 * Created by PhpStorm.
 * User: Sasa
 * Date: 23/07/2015
 * Time: 10:09
 */

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ZbrojniNalog extends Model
{
    protected $table = 'zbrojniNalog';

    protected $fillable = ['id','Naziv','VrstaNalogaId','NacinIzvrsenjaId','KlijentiId'];

    public function vrsteNaloga()
    {
        return $this->belongsTo('App\VrsteNaloga','VrstaNalogaId');
    }

    public function nacinIzvrsenja()
    {
        return $this->belongsTo('App\NacinIzvrsenja','NacinIzvrsenjaId');
    }

    public function klijent()
    {
        return $this->belongsTo('App\Klijent','KlijentiId');
    }

    public function nalozi(){
        return $this->hasMany('App\Nalog','ZbrojniNalogId');
    }

    public function scopeZNKlijenta($query, $klijentId){

        return $query->where('KlijentiId', $klijentId);
    }

    public function scopeZNVrste($query, $vrstaNalogaId){

        return $query->where('VrstaNalogaId', $vrstaNalogaId);
    }

    public static function glavaSloga($id){
        $results = DB::select("select zn.VrstaNalogaId, zn.id, par.Naziv, zr.IBAN, nal.DatumIzvrsenja, v.Alfa ,zr.IBAN, par.Adresa, sum(nal.Iznos) suma,count(*) brojNaloga
                                            from zbrojniNalog zn
                                            join Nalozi nal
                                              on nal.ZbrojniNalogId = zn.id
                                            join Valute v
                                              on v.id = nal.ValuteId
                                            join ZiroRacuni zr
                                              on nal.PlatiteljId = zr.id
                                            join Partneri par
                                              on par.id = zr.PartneriId
                                              WHERE zn.id = '$id'
                                            group by par.Naziv, nal.DatumIzvrsenja, v.Alfa, zr.IBAN         
                      ORDER BY DatumIzvrsenja");
        return $results;
    }

    public static function stavke($vrstaNaloga, $znid, $iban, $datum){
        
        $results = DB::select("SELECT n.ZbrojniNalogId, n.Opis, n.Iznos, n.DatumIzvrsenja, plzr.IBAN ibanPlatitelja , mo.Vrijednost modelOdobrenja, n.BrojOdobrenja, przr.IBAN ibanPrimatelja, p.Naziv nazivPrimatelja, p.Adresa,  mz.Vrijednost modelZaduzenja, n.BrojZaduzenja 
                  FROM Nalozi n 
                  join Valute v
                    on v.id = n.ValuteId
                  join ModeliPlacanja mo
                    on n.ModelOdobrenjaId = mo.id
                  join ModeliPlacanja mz
                    on n.ModelZaduzenjaId = mz.id  
                  join ZiroRacuni plzr
                    on n.PlatiteljId = plzr.id
                  join ZiroRacuni przr
                    on n.ZiroPrimatelja = przr.id
                  join Partneri p
                    on p.id = przr.PartneriId
                  WHERE n.ZbrojniNalogId = '$znid' AND plzr.IBAN = '$iban' AND n.DatumIzvrsenja = '$datum'");
        
        return $results;
    }
    
    public static function slog3094($znid, $iban, $datum){

        $sql = "SELECT pl.zbrojni_nalog_id, pr.iban_primatelja, pr.naziv_primatelja, pl.opis, pl.iznos, r.iban, m.naziv mododobrenja, pr.broj_odobrenja, m2.naziv modzaduzenja, pr.broj_zaduzenja, pl.datum_izvrsenja, vp.sifra
                 FROM placanje pl
                 LEFT JOIN valute v ON sifra_valute_id = v.id
                 LEFT JOIN predlosci pr ON pl.predlozak_id = pr.id
                 LEFT JOIN racuni r ON pr.platitelj_id = r.id
                 LEFT JOIN model_placanja m ON pr.model_odobrenja_id = m.id
                 LEFT JOIN model_placanja m2 ON pr.model_zaduzenja_id = m2.id
                 LEFT JOIN vrste_osobnih_primanja vp ON pl.sifra_osobnog_primanja_id = vp.id
                 WHERE pl.zbrojni_nalog_id = $znid AND r.iban='$iban' AND pl.datum_izvrsenja = '$datum'";

        $results = app('db')->select($sql);
        return $results;
    }
}